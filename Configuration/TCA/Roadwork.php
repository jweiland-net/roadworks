<?php
if (!defined ('TYPO3_MODE')) {
    die ('Access denied.');
}

$GLOBALS['TCA']['tx_roadworks_domain_model_roadwork'] = array(
    'ctrl' => $GLOBALS['TCA']['tx_roadworks_domain_model_roadwork']['ctrl'],
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, nr, description, info, roadwork_begin, roadwork_end, class, details, tx_maps2_uid',
    ),
    'types' => array(
        '1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, nr, description;;4;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_roadworks/rte/], info;;4;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_roadworks/rte/], roadwork_begin, roadwork_end, class, details, tx_maps2_uid,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => array(
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
                    array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
                ),
            ),
        ),
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_roadworks_domain_model_roadwork',
                'foreign_table_where' => 'AND tx_roadworks_domain_model_roadwork.pid=###CURRENT_PID### AND tx_roadworks_domain_model_roadwork.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'hidden' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => array(
                'type' => 'check',
            ),
        ),
        'starttime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'nr' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:roadworks/Resources/Private/Language/locallang_db.xlf:tx_roadworks_domain_model_detail.nr',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'description' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:roadworks/Resources/Private/Language/locallang_db.xlf:tx_roadworks_domain_model_roadwork.description',
            'config'  => array(
                'type' => 'text',
                'rows' => 10,
                'cols' => 80,
                'wizards' => array(
                    '_PADDING' => 2,
                    'RTE' => array(
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
                        'icon' => 'wizard_rte2.gif',
                        'script' => 'wizard_rte.php',
                    ),
                ),
            ),
        ),
        'info' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:roadworks/Resources/Private/Language/locallang_db.xlf:tx_roadworks_domain_model_roadwork.info',
            'config'  => array(
                'type' => 'text',
                'rows' => 10,
                'cols' => 80,
                'wizards' => array(
                    '_PADDING' => 2,
                    'RTE' => array(
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
                        'icon' => 'wizard_rte2.gif',
                        'script' => 'wizard_rte.php',
                    ),
                ),
            ),
        ),
        'roadwork_begin' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:roadworks/Resources/Private/Language/locallang_db.xlf:tx_roadworks_domain_model_roadwork.roadwork_begin',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'date,required',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'roadwork_end' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:roadworks/Resources/Private/Language/locallang_db.xlf:tx_roadworks_domain_model_roadwork.roadwork_end',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'eval' => 'date,required',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
        'class' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:roadworks/Resources/Private/Language/locallang_db.xlf:tx_roadworks_domain_model_roadwork.class',
            'config' => array(
                'type' => 'input',
                'size' => 1,
                'eval' => 'trim',
            ),
        ),
        'details' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:roadworks/Resources/Private/Language/locallang_db.xlf:tx_roadworks_domain_model_roadwork.details',
            'config' => array(
                'type' => 'inline',
                'foreign_table' => 'tx_roadworks_domain_model_detail',
                'foreign_field' => 'roadwork',
                'minitems' => 0,
                'maxitems' => 99,
                'appearance' => array(
                    'collapseAll' => true,
                    'newRecordLinkAddTitle' => true,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ),
            ),
        ),
        'tx_maps2_uid' => array (
            'exclude' => 1,
            'label' => 'LLL:EXT:maps2/Resources/Private/Language/locallang_db.xlf:tx_maps2_uid',
            'config' => array (
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'tx_maps2_domain_model_poicollection',
                'prepend_tname' => false,
                'show_thumbs' => false,
                'size' => 1,
                'maxitems' => 1,
                'wizards' => array(
                    'suggest' => array(
                        'type' => 'suggest',
                        'default' => array(
                            'searchWholePhrase' => true
                        ),
                    ),
                ),
            ),
        ),
    ),
);
