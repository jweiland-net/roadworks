<?php
namespace JWeiland\Roadworks\Domain\Model;

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
class Roadwork extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * nr of the roadworks
     *
     * @var string
     * @validate NotEmpty
     */
    protected $nr;

    /**
     * the description of the roadworks
     *
     * @var string
     * @validate NotEmpty
     */
    protected $description;

    /**
     * the info of the roadworks
     *
     * @var string
     */
    protected $info;

    /**
     * roadworkBegin
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $roadworkBegin;

    /**
     * roadworkEnd
     *
     * @var \DateTime
     * @validate NotEmpty
     */
    protected $roadworkEnd;

    /**
     * class information of the roadworks
     *
     * @var string
     */
    protected $class;

    /**
     * details for this roadwork
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Roadworks\Domain\Model\Detail>
     */
    protected $details;

    /**
     * TxMaps2Uid
     *
     * @var \JWeiland\Maps2\Domain\Model\PoiCollection
     */
    protected $txMaps2Uid;

    /**
     * constructor of this model
     * it initializes all objectStorages
     */
    public function __construct()
    {
        $this->details = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the nr
     *
     * @return string
     */
    public function getNr()
    {
        return $this->nr;
    }

    /**
     * Sets the nr
     *
     * @param string $nr
     *
     * @return void
     */
    public function setNr($nr)
    {
        $this->nr = $nr;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     *
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Sets the info
     *
     * @param string $info
     *
     * @return void
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * Returns the roadworkBegin
     *
     * @return \DateTime
     */
    public function getRoadworkBegin()
    {
        return $this->roadworkBegin;
    }

    /**
     * Sets the roadworkBegin
     *
     * @param \DateTime $roadworkBegin
     *
     * @return void
     */
    public function setRoadworkBegin(\DateTime $roadworkBegin)
    {
        $this->roadworkBegin = $roadworkBegin;
    }

    /**
     * Returns the roadworkEnd
     *
     * @return \DateTime
     */
    public function getRoadworkEnd()
    {
        return $this->roadworkEnd;
    }

    /**
     * Sets the roadworkEnd
     *
     * @param \DateTime $roadworkEnd
     *
     * @return void
     */
    public function setRoadworkEnd(\DateTime $roadworkEnd)
    {
        $this->roadworkEnd = $roadworkEnd;
    }

    /**
     * Returns the class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets the class
     *
     * @param string $class
     *
     * @return void
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * Returns the details
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Sets the details
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $details
     *
     * @return void
     */
    public function setDetails(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $details)
    {
        $this->details = $details;
    }

    /**
     * Returns the txMaps2Uid
     *
     * @return \JWeiland\Maps2\Domain\Model\PoiCollection $txMaps2Uid
     */
    public function getTxMaps2Uid()
    {
        return $this->txMaps2Uid;
    }

    /**
     * Sets the txMaps2Uid
     *
     * @param \JWeiland\Maps2\Domain\Model\PoiCollection $txMaps2Uid
     *
     * @return void
     */
    public function setTxMaps2Uid(\JWeiland\Maps2\Domain\Model\PoiCollection $txMaps2Uid)
    {
        $this->txMaps2Uid = $txMaps2Uid;
    }
}
