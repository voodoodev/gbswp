<?php
namespace GeorgeRujoiu\GameBattleStats;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;

class Activator extends AbstractSingleton
{
	private $charsetCollate;

	private $prefixedTable;

	/**
	 * Runs when activating the plugin
	 * @return $this
	 */
	public function activate()
	{
		global $wpdb;

		# charset
		$this->charsetCollate = $wpdb->get_charset_collate();

		# prefix the table name before adding to the db
		$this->prefixedTable = $wpdb->prefix;

        require_once(ABSPATH.'wp-admin/includes/upgrade.php');

        # create the tables
        $this->platformsTable();
		$this->teamsTable();
		$this->laddersTable();
		$this->tournamentsTable();

		return $this;
	}

	private function platformsTable()
	{
		dbDelta('CREATE TABLE '.$this->prefixedTable.'platforms (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name tinytext NOT NULL,
                PRIMARY KEY  (id)
            ) '.$this->charsetCollate.';');
	}

	private function teamsTable()
	{
		dbDelta('CREATE TABLE '.$this->prefixedTable.'teams (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name tinytext NOT NULL,
                PRIMARY KEY  (id)
            ) '.$this->charsetCollate.';');
	}

	private function laddersTable()
	{
		dbDelta('CREATE TABLE '.$this->prefixedTable.'ladders (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name tinytext NOT NULL,
                PRIMARY KEY  (id)
            ) '.$this->charsetCollate.';');
	}

	private function tournamentsTable()
	{
		dbDelta('CREATE TABLE '.$this->prefixedTable.'tournaments (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name tinytext NOT NULL,
                PRIMARY KEY  (id)
            ) '.$this->charsetCollate.';');
	}
}