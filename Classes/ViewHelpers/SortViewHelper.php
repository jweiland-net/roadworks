<?php
namespace JWeiland\Roadworks\ViewHelpers;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * @author Claus Due, Wildside A/S
 * @package Fed
 * @subpackage ViewHelpers\Data
 */
class SortViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('as', 'string', 'Which variable to update in the TemplateVariableContainer. If left out, returns sorted data instead of updating the varialbe (i.e. reference or copy)');
        $this->registerArgument('sortBy', 'string', 'Which property/field to sort by - leave out for numeric sorting based on indexes(keys)');
        $this->registerArgument('order', 'string', 'ASC or DESC', false, 'ASC');
        $this->registerArgument('array', 'array', 'DEPRECATED: Optional; use to sort an array');
        $this->registerArgument('objectStorage', 'TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage|TYPO3\\CMS\\Extbase\\Persistence\\Generic\\LazyObjectStorage', 'DEPRECATED: Optional; use to sort an ObjectStorage');
        $this->registerArgument('queryResult', 'TYPO3\\CMS\\Extbase\\Persistence\\QueryResultInterface', 'DEPRECATED: Optional; use to sort a QueryResult');
    }

    /**
     * "Render" method - sorts a target list-type target. Either $array or $objectStorage must be specified. If both are,
     * ObjectStorage takes precedence.
     *
     * @param array|object An array, Iterator, ObjectStorage, LazyObjectStorage or QueryResult to sort
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function render($subject = null)
    {
        if ($subject === null) {
            $priorities = array('array', 'objectStorage', 'queryResult');
            foreach ($priorities as $argumentName) {
                if ($this->arguments[$argumentName]) {
                    $subject = $this->arguments[$argumentName];
                    break;
                }
            }
        }
        $sorted = null;
        if (is_array($subject) === true) {
            $sorted = $this->sortArray($subject);
        } else {
            if ($subject instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage || $subject instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyObjectStorage) {
                $sorted = $this->sortObjectStorage($subject);
            } elseif ($subject instanceof \Iterator) {
                /** @var \Iterator $subject */
                $array = array();
                foreach ($subject as $index => $item) {
                    $array[$index] = $item;
                }
                $sorted = $this->sortArray($array);
            } elseif ($subject instanceof \TYPO3\CMS\Extbase\Persistence\QueryResultInterface) {
                /** @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface $subject */
                $sorted = $this->sortArray($subject->toArray());
            }
        }
        if ($sorted === null) {
            throw new \Exception('Nothing to sort, SortViewHelper has no purpose in life, performing LATE term self-abortion');
        }
        if ($this->arguments['as']) {
            if ($this->templateVariableContainer->exists($this->arguments['as'])) {
                $this->templateVariableContainer->remove($this->arguments['as']);
            }
            $this->templateVariableContainer->add($this->arguments['as'], $sorted);
            return $this->renderChildren();
        } else {
            return $sorted;
        }
    }

    /**
     * Sort an array
     *
     * @param array $array
     *
     * @return array
     */
    protected function sortArray($array)
    {
        $sorted = array();
        foreach ($array as $index => $object) {
            if ($this->arguments['sortBy']) {
                $index = $this->getSortValue($object);
            }
            while (isset($sorted[$index])) {
                $index .= '1';
            }
            $sorted[$index] = $object;
        }
        if ($this->arguments['order'] === 'ASC') {
            ksort($sorted);
        } else {
            krsort($sorted);
        }
        return $sorted;
    }

    /**
     * Sort a \TYPO3\CMS\Extbase\Persistence\ObjectStorage instance
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $storage
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    protected function sortObjectStorage($storage)
    {
        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\ObjectManager');
        /** @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage $temp */
        $temp = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
        foreach ($storage as $item) {
            $temp->attach($item);
        }
        $sorted = array();
        foreach ($storage as $index => $item) {
            if ($this->arguments['sortBy']) {
                $index = $this->getSortValue($item);
            }
            while (isset($sorted[$index])) {
                $index .= '1';
            }
            $sorted[$index] = $item;
        }
        if ($this->arguments['order'] === 'ASC') {
            ksort($sorted);
        } else {
            krsort($sorted);
        }
        $storage = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage');
        foreach ($sorted as $item) {
            $storage->attach($item);
        }
        return $storage;
    }

    /**
     * Gets the value to use as sorting value from $object
     *
     * @param mixed $object
     *
     * @return mixed
     */
    protected function getSortValue($object)
    {
        $field = $this->arguments['sortBy'];
        $value = ObjectAccess::getProperty($object, $field);
        if ($value instanceof \DateTime) {
            $value = $value->format('U');
        } elseif ($value instanceof \TYPO3\CMS\Extbase\Persistence\ObjectStorage) {
            $value = $value->count();
        } elseif (is_array($value)) {
            $value = count($value);
        }
        return $value;
    }
}
