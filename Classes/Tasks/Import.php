<?php
namespace JWeiland\Roadworks\Tasks;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package roadworks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Import extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \JWeiland\Roadworks\Configuration\ExtConf
     */
    protected $extConf;

    /**
     * @var \JWeiland\Roadworks\Email\Reader
     */
    protected $reader;
    
    /**
     * @var array
     */
    protected $jakoPresse = array('VI_JAKOPRESSE', 'tx_roadworks_domain_model_roadwork');
    
    /**
     * @var array
     */
    protected $jakoLink = array('VI_JAKOLINK', 'tx_roadworks_domain_model_detail');
    
    /**
     * initialize this object
     *
     * @return void
     */
    public function init()
    {
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $this->extConf = $this->objectManager->get('JWeiland\\Roadworks\\Configuration\\ExtConf');
        $this->reader = $this->objectManager->get('JWeiland\\Roadworks\\Email\\Reader');
        $this->reader->connect($this->getReaderSettings());
    }

    /**
     * Generate email reader settings
     *
     * @return \JWeiland\Roadworks\Email\ReaderSettings
     */
    public function getReaderSettings()
    {
        /** @var $settings \JWeiland\Roadworks\Email\ReaderSettings */
        $settings = $this->objectManager->get('JWeiland\\Roadworks\\Email\\ReaderSettings');

        $settings->setServer($this->server);
        $settings->setUser($this->user);
        $settings->setPass($this->pass);
        $settings->setPort($this->port);
        $settings->setSsl($this->ssl);

        return $settings;
    }

    /**
     * This method will be executed first, when scheduler starts
     *
     * @return bool
     */
    public function execute()
    {
        // initialize this object
        $this->init();

        // delete realUrlCache
        /** @var \tx_realurl $realUrl */
        $realUrl = $this->objectManager->get('tx_realurl');
        $realUrl->clearPageCacheMgm(array(
            'pageIdArray' => GeneralUtility::trimExplode(',', $this->clearCachePids)
        ));
        // clearPageCacheMgm clears only pathcache, encode- and decodecache
        // we have to clear the uniqalias cache manually
        $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_realurl_uniqalias', 'tablename=\'tx_roadworks_domain_model_roadwork\'');

        $everyThingOk = true;

        /**
         * the normal way: only one email is in the inbox
         */
        if ($this->reader->getMessageCount() > 0) {
            $latestMail = $this->reader->getLatestMail();
            $mailBody = $this->reader->getMailBody($latestMail->Msgno);

            // data to import
            $arr_data = unserialize(imap_base64(str_replace('=', '', $mailBody)));
            if (is_array($arr_data)) {
                if (is_array($arr_data[$this->jakoPresse[0]])) {
                    $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery($this->jakoPresse[1]);
                    $updatedRows = 0;
                    $insertedRows = 0;
                    foreach ($arr_data[$this->jakoPresse[0]] as $value) {
                        $begin = \DateTime::createFromFormat('d.m.y', $value['BEGINN']);
                        $end = \DateTime::createFromFormat('d.m.y', $value['ENDE']);

                        $fieldValues = array(
                            'pid' => $this->pid,
                            'tstamp' => time(),
                            'nr' => $value['BEZUG'],
                            'description' => $value['NAME'],
                            'info' => $value['INFO'],
                            'roadwork_begin' => $begin->format('U'),
                            'roadwork_end' => $end->format('U'),
                            'class' => (string)$value['KLASSE'],
                        );

                        // check if record exists
                        $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
                            'uid',
                            $this->jakoPresse[1],
                            'nr="' . $value['BEZUG'] . '"' .
                                BackendUtility::deleteClause($this->jakoPresse[1]),
                            '', ''
                        );

                        if (is_array($row)) {
                            // update record
                            $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                                $this->jakoPresse[1],
                                'nr="' . $value['BEZUG'] . '"' .
                                    BackendUtility::deleteClause($this->jakoPresse[1]),
                                $fieldValues
                            );
                            $updatedRows = $updatedRows + $GLOBALS['TYPO3_DB']->sql_affected_rows();
                        } else {
                            // insert new record
                            $fieldValues['crdate'] = time();
                            $fieldValues['cruser_id'] = $GLOBALS['BE_USER']->user['username'];

                            $GLOBALS['TYPO3_DB']->exec_INSERTquery(
                                $this->jakoPresse[1],
                                $fieldValues
                            );
                            $insertedRows = $insertedRows + $GLOBALS['TYPO3_DB']->sql_insert_id();
                        }
                    }
                    $this->scheduler->log($updatedRows . ' updated and ' . $insertedRows . ' inserted rows of total: ' . count($arr_data[$this->jakoPresse[0]]) . ' records of type JAKOPRESSE have been imported');
                }
                if (is_array($arr_data[$this->jakoLink[0]])) {
                    $GLOBALS['TYPO3_DB']->exec_TRUNCATEquery($this->jakoLink[1]);
                    $insertedRows = 0;
                    foreach ($arr_data[$this->jakoLink[0]] as $value) {
                        // find UID of roadwork
                        list($roadwork) = BackendUtility::getRecordsByField($this->jakoPresse[1], 'nr', $value['JAKONR'], '', '', '', '1');

                        // insert detail
                        $insertData = array(
                            'pid' => (int)$this->pid,
                            'identifier' => $value['SCHLUESSEL'],
                            'roadwork' => (int)$roadwork['uid'],
                            'place' => $value['PLATZ'],
                            'tooltip' => (string)$value['TOOLTIP'],
                            'class' => (string)$value['KLASSE'],
                            'info' => (string)$value['INFO'],
                            'link' => (string)$value['VERWEIS'],
                        );
                        $GLOBALS['TYPO3_DB']->exec_INSERTquery($this->jakoLink[1], $insertData);
                        $insertedRows = $insertedRows + $GLOBALS['TYPO3_DB']->sql_affected_rows();
                    }
                    $this->scheduler->log($insertedRows . ' inserted rows of total: ' . count($arr_data[$this->jakoLink[0]]) . ' records of type JAKOLINK have been imported');
                }
                // move mail to Processed if set
                if ($this->extConf->getDeleteMailAfterProcessing()) {
                    $this->reader->move($latestMail->Msgno, 'INBOX.Processed');
                }
            } else {
                $everyThingOk = false;
                $this->reader->move($latestMail->Msgno, 'INBOX.Error');
            }
        }
        $this->reader->close();
        return $everyThingOk;
    }

    /**
     * configure additional fields for scheduler
     *
     * @return string
     */
    public function getAdditionalInformation()
    {
        return 'Server: ' . $this->server . ':' . $this->port . ' | User: ' . $this->user . ' | SSL: ' . ($this->ssl ? 'ja' : 'nein');
    }
}
