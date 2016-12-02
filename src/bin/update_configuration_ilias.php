<?php
/* Copyright (c) 2016 Stefan Hecken <stefan.hecken@concepts-and-training.de>, Extended GPL, see LICENSE */

$config_path = $argv[1];

require __DIR__ . '/../../vendor/autoload.php';

error_reporting(E_ALL & ~E_STRICT & ~E_DEPRECATED);

$yaml_string = file_get_contents($config_path);
$parser = new \CaT\InstILIAS\YamlParser();
$general_config = $parser->read_config($yaml_string, "\\CaT\\InstILIAS\\Config\\General");

$absolute_path = $general_config->server()->absolutePath();
$client_id = $general_config->client()->name();

echo "\n\nConfigure ILIAS.";
$ilias_configurator = new \CaT\InstILIAS\IliasReleaseConfigurator($absolute_path, $client_id);

if($general_config->plugin() !== null) {
	echo "\nUpdating plugins...";
	$ilias_configurator->installPlugins($general_config->plugin());
	$ilias_configurator->activatePlugins($general_config->plugin());
	echo "\t\t\t\t\t\t\t\t\t\t\tDone!\n";
}