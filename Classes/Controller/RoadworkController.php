<?php
namespace JWeiland\Roadworks\Controller;

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
class RoadworkController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * roadworksRepository
     *
     * @var \JWeiland\Roadworks\Domain\Repository\RoadworkRepository
     */
    protected $roadworkRepository;

    /**
     * inject roadworkRepository
     *
     * @param \JWeiland\Roadworks\Domain\Repository\RoadworkRepository $roadworkRepository
     *
     * @return void
     */
    public function injectRoadworkRepository(\JWeiland\Roadworks\Domain\Repository\RoadworkRepository $roadworkRepository)
    {
        $this->roadworkRepository = $roadworkRepository;
    }

    /**
     * preprocessing of all actions
     *
     * @return void
     */
    public function initializeAction()
    {
        // if this value was not set, then it will be filled with 0
        // but that is not good, because UriBuilder accepts 0 as pid, so it's better to set it to \n
        if (empty($this->settings['pidOfDetailPage'])) {
            $this->settings['pidOfDetailPage'] = \n;
        }
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $roadworks = $this->roadworkRepository->findAll();
        $this->view->assign('roadworks', $roadworks);
    }

    /**
     * action listPlanned
     *
     * @return void
     */
    public function listPlannedAction()
    {
        $roadworks = $this->roadworkRepository->findPlannedRoadworks();
        $this->view->assign('roadworks', $roadworks);
    }

    /**
     * action listFinished
     *
     * @return void
     */
    public function listFinishedAction()
    {
        $roadworks = $this->roadworkRepository->findFinishedRoadworks();
        $this->view->assign('roadworks', $roadworks);
    }

    /**
     * action listCurrent
     *
     * @return void
     */
    public function listCurrentAction()
    {
        $roadworks = $this->roadworkRepository->findCurrentRoadworks();
        $this->view->assign('roadworks', $roadworks);
    }

    /**
     * action show
     *
     * @param \JWeiland\Roadworks\Domain\Model\Roadwork $roadwork
     *
     * @return void
     */
    public function showAction(\JWeiland\Roadworks\Domain\Model\Roadwork $roadwork)
    {
        $this->view->assign('roadwork', $roadwork);
    }
}
