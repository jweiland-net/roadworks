<?php
namespace JWeiland\Roadworks\Configuration;

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
class ExtConf implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * delete mail after processing
     *
     * @var boolean
     */
    protected $deleteMailAfterProcessing;

    /**
     * constructor of this class
     * This method reads the global configuration and calls the setter methods
     */
    public function __construct()
    {
        // get global configuration
        $extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['roadworks']);
        if (is_array($extConf) && count($extConf)) {
            // call setter method foreach configuration entry
            foreach($extConf as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($value);
                }
            }
        }
    }

    /**
     * getter for deleteMailAfterProcessing
     *
     * @return boolean
     */
    public function getDeleteMailAfterProcessing()
    {
        if (empty($this->deleteMailAfterProcessing)) {
            return false;
        } else {
            return $this->deleteMailAfterProcessing;
        }
    }

    /**
     * setter for deleteMailAfterProcessing
     *
     * @param boolean $deleteMailAfterProcessing
     * @return void
     */
    public function setDeleteMailAfterProcessing($deleteMailAfterProcessing)
    {
        $this->deleteMailAfterProcessing = (bool) $deleteMailAfterProcessing;
    }
}
