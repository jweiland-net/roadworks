<?php
namespace JWeiland\Roadworks\Email;

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

/**
 * @package roadworks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Reader
{
    /**
     * @var \JWeiland\Roadworks\Email\ReaderSettings
     */
    protected $readerSettings;

    // imap server connection
    public $conn;
    public $errors = array();

    // inbox storage and inbox message count
    protected $inbox = array();
    protected $messageCount = 0;

    /**
     * close the server connection
     *
     * return void
     */
    public function close()
    {
        $this->inbox = array();
        $this->setMessageCount(0);
        imap_close($this->conn);
    }

    /**
     * open the server connection
     * the imap_open function parameters will need to be changed for the particular server
     * these are laid out to connect to a Dreamhost IMAP server
     *
     * @param \JWeiland\Roadworks\Email\ReaderSettings $settings
     *
     * @return void
     */
    public function connect(\JWeiland\Roadworks\Email\ReaderSettings $settings)
    {
        $this->readerSettings = $settings;

        // check for ssl connection. apache module open_ssl must be activated
        if ($this->readerSettings->getSsl()) {
            $sslPart = '/ssl/novalidate-cert';
        } else {
            $sslPart = '';
        }

        $serverPart = $this->readerSettings->getServer() . ':' . $this->readerSettings->getPort();

        // establish connection to imap server
        $this->conn = imap_open(
            '{' . $serverPart . '/imap' . $sslPart . '}',
            $this->readerSettings->getUser(),
            $this->readerSettings->getPass()
        );

        // check if connection was successful
        if (!$this->conn) {
            $this->errors = imap_errors();
        } else {
            $this->readInbox();
        }
    }

    /**
     * move the message to another folder
     *
     * @param integer $msgIndex
     * @param string $folder
     *
     * @return void
     */
    public function move($msgIndex, $folder = 'INBOX.Processed')
    {
        // move on server
        imap_mail_move($this->conn, $msgIndex, $folder);
        imap_expunge($this->conn);

        // re-read the inbox
        $this->readInbox();
    }

    /**
     * get a specific message (1 = first email, 2 = second email, etc.)
     *
     * @param integer $msgIndex
     *
     * @return array
     */
    public function getMailBody($msgIndex)
    {
        return imap_body($this->conn, $msgIndex);
    }

    /**
     * get header of the most current mail
     *
     * @return \stdClass object with imap headerInfo of latest mail
     */
    public function getLatestMail()
    {
        $latestMail = end($this->inbox);
        reset($this->inbox);
        return $latestMail;
    }

    /**
     * read the inbox
     *
     * @return void
     */
    public function readInbox()
    {
        if ($this->conn) {
            $this->setMessageCount(imap_num_msg($this->conn));
            $in = array();
            for ($i = 1; $i <= $this->getMessageCount(); $i++) {
                $headerInfo = imap_headerinfo($this->conn, $i);
                $in[$headerInfo->Msgno] = $headerInfo;
            }
            $this->inbox = $in;
        }
    }

    /**
     * Getter for message count
     *
     * @return int
     */
    public function getMessageCount()
    {
        return $this->messageCount;
    }

    /**
     * Setter for message count
     *
     * @param $messageCount
     */
    public function setMessageCount($messageCount)
    {
        $this->messageCount = (int)$messageCount;
    }
}
