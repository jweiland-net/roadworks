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
class ReaderSettings implements \TYPO3\CMS\Core\SingletonInterface
{
    /**
     * Server
     *
     * @var string
     */
    protected $server;

    /**
     * User
     *
     * @var string
     */
    protected $user;

    /**
     * Pass
     *
     * @var string
     */
    protected $pass;

    /**
     * Port
     *
     * @var integer
     */
    protected $port;

    /**
     * SSL
     *
     * @var string
     */
    protected $ssl;

    /**
     * Setter for server
     *
     * @param string $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }

    /**
     * Getter for server
     *
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Setter for user
     *
     * @param string $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Getter for user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Setter for pass
     *
     * @param string $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * Getter for pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Setter for port
     *
     * @param integer $port
     */
    public function setPort($port)
    {
        $this->port = (int) $port;
    }

    /**
     * Getter for port
     *
     * @return integer
     */
    public function getPort()
    {
        return (int) $this->port;
    }

    /**
     * Setter for ssl
     *
     * @param string $ssl
     */
    public function setSsl($ssl)
    {
        $this->ssl = $ssl;
    }

    /**
     * Getter for ssl
     *
     * @return string
     */
    public function getSsl()
    {
        return $this->ssl;
    }
}
