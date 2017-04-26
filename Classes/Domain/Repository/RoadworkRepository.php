<?php
namespace JWeiland\Roadworks\Domain\Repository;

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
class RoadworkRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * find all planned roadworks
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findPlannedRoadworks()
    {
        $now = new \DateTime('today');
        $query = $this->createQuery();

        return $query->matching(
            $query->greaterThan('roadworkBegin', $now)
        )->execute();
    }

    /**
     * find all finished roadworks
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findFinishedRoadworks()
    {
        $now = new \DateTime('today');
        $query = $this->createQuery();

        return $query->matching(
            $query->lessThan('roadworkEnd', $now)
        )->execute();
    }

    /**
     * find all current roadworks
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findCurrentRoadworks()
    {
        $now = new \DateTime('today');
        $query = $this->createQuery();

        $constraint = array();
        $constraint[] = $query->lessThanOrEqual('roadworkBegin', $now);
        $constraint[] = $query->greaterThanOrEqual('roadworkEnd', $now);

        return $query->matching($query->logicalAnd($constraint))->execute();
    }
}
