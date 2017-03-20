<?php
defined('TYPO3_MODE') || die();

/**
 * Include credentials to allow final local overwrite
 *
 * different credential file for testing will be included
 * to have seperate database connection
 */
$configDir = realpath(
    dirname(__FILE__) . DIRECTORY_SEPARATOR .
    '..' . DIRECTORY_SEPARATOR .
    '..' . DIRECTORY_SEPARATOR .
    '..' . DIRECTORY_SEPARATOR .
    'private/config'
);

require_once($configDir . DIRECTORY_SEPARATOR . 'credentials.typo3.php');
