<?php

// autoload_psr4.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'vocabularyFunctions\\' => array($baseDir . '/admin/vocabularyFunctions'),
    'settings\\' => array($baseDir . '/admin/settings'),
    'schemaTypes\\organization\\' => array($baseDir . '/admin/schemaTypes/organization'),
    'schemaTypes\\cw\\' => array($baseDir . '/admin/schemaTypes/creativeWorks'),
    'schemaTypes\\' => array($baseDir . '/admin/schemaTypes'),
    'schemaFunctions\\' => array($baseDir . '/admin/schemaFunctions'),
    'requiredPlugins\\' => array($baseDir . '/admin/requiredPlugins'),
    'networkFunctions\\' => array($baseDir . '/admin/networkFunctions'),
    'adminFunctions\\' => array($baseDir . '/admin/adminFunctions'),
    'Spatie\\SchemaOrg\\' => array($vendorDir . '/spatie/schema-org/src'),
);