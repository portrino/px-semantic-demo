<?php
defined('TYPO3_MODE') || die();

$boot = function ($_EXTKEY) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
        $_EXTKEY,
        'setup',
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:px_semantic_example/Configuration/TypoScript/setup.txt">'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
        $_EXTKEY,
        'constants',
        '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:px_semantic_example/Configuration/TypoScript/constants.txt">'
    );
};

$boot($_EXTKEY);
unset($boot);