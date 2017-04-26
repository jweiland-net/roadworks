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

/**
 * @package roadworks
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class StrftimeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * implements a vievHelper to convert seconds since 0:00 to a readable format
     *
     * @param string $format How to format the date
     * @param string $locale set_locale
     * @return string
     */
    public function render($format = '%d.%m.%Y', $locale = 'de_DE.UTF-8')
    {
        $date = $this->renderChildren();
        setlocale(LC_TIME, $locale);
        if ($date instanceof \DateTime) {
            return strftime($format, $date->format('U'));
        } else return '';
    }
}
