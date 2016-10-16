<?php
/*
Plugin Name: GameBattleStats
Plugin URI:  https://gbladder.com/
Description: This plugin creates a gaming ladders/tournaments system
Version:     0.1.0
Author:      George Rujoiu
Author URI:  https://georgerujoiu.com/
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: gbs
Domain Path: /languages
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once(plugin_dir_path(__FILE__).'bootstrap.php');

use GeorgeRujoiu\GameBattleStats\GameBattleStats;
use GeorgeRujoiu\GameBattleStats\Activator;
use GeorgeRujoiu\GameBattleStats\Deactivator;

function activate_game_battle_stats()
{
	Activator::getInstance()
		->activate()
	;
}

function deactivate_game_battle_stats()
{
	Deactivator::getInstance()
		->deactivate()
	;
}

register_activation_hook(__FILE__, 'activate_game_battle_stats');
register_deactivation_hook(__FILE__, 'deactivate_game_battle_stats');

function run_game_battle_stats()
{
	GameBattleStats::getInstance()
		->run()
	;
}
add_action('init', 'run_game_battle_stats');