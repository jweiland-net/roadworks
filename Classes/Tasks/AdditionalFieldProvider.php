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

/**
 * Class AdditionalFieldProvider
 *
 * @package JWeiland\Roadworks\Tasks
 */
class AdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface
{
    /**
     * configure additional fields for scheduler
     *
     * @param array $taskInfo
     * @param $task
     * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject
     * @return array
     */
    public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject)
    {
        if (empty($taskInfo['pid'])) {
            if($parentObject->CMD == 'edit') {
                $taskInfo['pid'] = $task->pid;
            } else {
                $taskInfo['pid'] = 0;
            }
        }

        if (empty($taskInfo['server'])) {
            if($parentObject->CMD == 'edit') {
                $taskInfo['server'] = $task->server;
            } else {
                $taskInfo['server'] = '';
            }
        }

        if (empty($taskInfo['user'])) {
            if($parentObject->CMD == 'edit') {
                $taskInfo['user'] = $task->user;
            } else {
                $taskInfo['user'] = '';
            }
        }

        if (empty($taskInfo['pass'])) {
            if($parentObject->CMD == 'edit') {
                $taskInfo['pass'] = $task->pass;
            } else {
                $taskInfo['pass'] = '';
            }
        }

        if (empty($taskInfo['port'])) {
            if ($parentObject->CMD == 'add') {
                $taskInfo['port'] = '993';
            } elseif($parentObject->CMD == 'edit') {
                $taskInfo['port'] = $task->port;
            } else {
                $taskInfo['port'] = '';
            }
        }

        if (empty($taskInfo['ssl'])) {
            if ($parentObject->CMD == 'add') {
                $taskInfo['ssl'] = '1';
            } elseif($parentObject->CMD == 'edit') {
                $taskInfo['ssl'] = $task->ssl;
            } else {
                $taskInfo['ssl'] = '';
            }
        }

        if (empty($taskInfo['clearCachePids'])) {
            if($parentObject->CMD == 'edit') {
                $taskInfo['clearCachePids'] = $task->clearCachePids;
            } else {
                $taskInfo['clearCachePids'] = '';
            }
        }

        // Write the code for the field
        $fieldID = 'task_pid';
        $fieldCode = '<input type="text" name="tx_scheduler[pid]" id="' . $fieldID . '" value="' . $taskInfo['pid'] . '" size="30" />';
        $additionalFields = array();
        $additionalFields[$fieldID] = array(
            'code' => $fieldCode,
            'label' => 'Pid'
        );

        // Write the code for the field
        $fieldID = 'task_server';
        $fieldCode = '<input type="text" name="tx_scheduler[server]" id="' . $fieldID . '" value="' . $taskInfo['server'] . '" size="30" />';
        $additionalFields[$fieldID] = array(
            'code' => $fieldCode,
            'label' => 'Server'
        );

        // Write the code for the field
        $fieldID = 'task_user';
        $fieldCode = '<input type="text" name="tx_scheduler[user]" id="' . $fieldID . '" value="' . $taskInfo['user'] . '" size="30" />';
        $additionalFields[$fieldID] = array(
            'code' => $fieldCode,
            'label' => 'User'
        );

        // Write the code for the field
        $fieldID = 'task_pass';
        $fieldCode = '<input type="text" name="tx_scheduler[pass]" id="' . $fieldID . '" value="' . $taskInfo['pass'] . '" size="30" />';
        $additionalFields[$fieldID] = array(
            'code' => $fieldCode,
            'label' => 'Password (klar!)'
        );

        // Write the code for the field
        $fieldID = 'task_port';
        $fieldCode = '<input type="text" name="tx_scheduler[port]" id="' . $fieldID . '" value="' . $taskInfo['port'] . '" size="30" />';
        $additionalFields[$fieldID] = array(
            'code' => $fieldCode,
            'label' => 'Port'
        );

        // Write the code for the field
        $fieldID = 'task_ssl';
        $fieldCode = '<input type="checkbox" name="tx_scheduler[ssl]" id="' . $fieldID . '" value="' . $taskInfo['ssl'] . '"'.($taskInfo['ssl']?' checked="checked"':'').' />';
        $additionalFields[$fieldID] = array(
            'code' => $fieldCode,
            'label' => 'SSL'
        );

        // Write the code for the field
        $fieldID = 'task_clearCachePids';
        $fieldCode = '<input type="text" name="tx_scheduler[clearCachePids]" id="' . $fieldID . '" value="' . $taskInfo['clearCachePids'] . '" size="30" />';
        $additionalFields[$fieldID] = array(
            'code' => $fieldCode,
            'label' => 'Clear RealUrl Cache of comma seperated page UIDs just before import starts'
        );

        return $additionalFields;
    }

    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject)
    {
        $submittedData['pid'] = (int)$submittedData['pid'];
        $submittedData['server'] = trim($submittedData['server']);
        $submittedData['user'] = trim($submittedData['user']);
        $submittedData['pass'] = trim($submittedData['pass']);
        $submittedData['port'] = trim((int)$submittedData['port']);
        return true;
    }

    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task)
    {
        $task->pid = $submittedData['pid'];
        $task->server = $submittedData['server'];
        $task->user = $submittedData['user'];
        $task->pass = $submittedData['pass'];
        $task->port = $submittedData['port'];
        $task->ssl = $submittedData['ssl'];
        $task->clearCachePids = $submittedData['clearCachePids'];
    }
}
