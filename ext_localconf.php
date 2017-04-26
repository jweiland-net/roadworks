<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'JWeiland.' . $_EXTKEY,
    'Roadworks',
    array(
        'Roadwork' => 'list, show',
    ),
    // non-cacheable actions
    array(
        'Roadwork' => '',
    )
);

// create scheduler to import roadworks from mail
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['JWeiland\\Roadworks\\Tasks\\Import'] = array(
    'extension' => $_EXTKEY,
    'title' => 'Baustellen importieren (neu)',
    'description' => 'Baustellen, die per E-Mail gesendet wurden, importieren.',
    'additionalFields' => 'JWeiland\\Roadworks\\Tasks\\AdditionalFieldProvider'
);
