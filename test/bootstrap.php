<?php
$_SERVER['REQUEST_METHOD'] = 'POST';
define('_PS_ROOT_DIR_', __DIR__ . '/../../..');
//define('_PS_MODULE_DIR_', _PS_ROOT_DIR_ . '/tests/Resources/modules/');
require_once __DIR__.'/../../../config/config.inc.php';
//define('_NEW_COOKIE_KEY_', PhpEncryption::createNewRandomKey());
require_once __DIR__.'/../../../init.php';
require_once _PS_CONFIG_DIR_ . 'autoload.php';
