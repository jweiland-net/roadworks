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
class Detail extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * identifier
     *
     * @var string
     * @validate NotEmpty
     */
    protected $identifier;

    /**
     * roadwork
     *
     * @var \JWeiland\Roadworks\Domain\Model\Roadwork
     */
    protected $roadwork;

    /**
     * place
     *
     * @var string
     */
    protected $place;

    /**
     * tooltip
     *
     * @var string
     */
    protected $tooltip;

    /**
     * class
     *
     * @var string
     */
    protected $class;

    /**
     * info
     *
     * @var string
     */
    protected $info;

    /**
     * link
     *
     * @var string
     */
    protected $link;

    /**
     * setter for identity
     *
     * @param string $identifier
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * getter for identity
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * setter for roadwork
     *
     * @param \JWeiland\Roadworks\Domain\Model\Roadwork $roadwork
     */
    public function setRoadwork(\JWeiland\Roadworks\Domain\Model\Roadwork $roadwork)
    {
        $this->roadwork = $roadwork;
    }

    /**
     * getter for roadwork
     *
     * @return \JWeiland\Roadworks\Domain\Model\Roadwork
     */
    public function getRoadwork()
    {
        return $this->roadwork;
    }

    /**
     * setter for place
     *
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * getter for place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * getter for placePosition
     * helper method to get the first number of place
     *
     * @return string
     */
    public function getPlacePosition()
    {
        return substr($this->place, 0, 1);
    }

    /**
     * setter for tooltip
     *
     * @param string $tooltip
     */
    public function setTooltip($tooltip)
    {
        $this->tooltip = $tooltip;
    }

    /**
     * getter for tooltip
     *
     * @return string
     */
    public function getTooltip()
    {
        return $this->tooltip;
    }

    /**
     * setter for class
     *
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * getter for class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * setter for info
     *
     * @param string $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * getter for info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * setter for link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * getter for link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
}
