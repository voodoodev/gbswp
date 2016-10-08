<?php
namespace GeorgeRujoiu\GameBattleStats;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;

class Activator extends AbstractSingleton
{
	private $tables = [
		'platforms',
		'ladders',
		'tournaments',
	];

	public function activate()
	{
        # create the tables
        $this->createTables();
	}

	private function createTables()
	{
		global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        $sql = '';

		foreach ($this->tables as $table) {
			# prefix the table name before adding to the db
			$prefixedTable = $wpdb->prefix.$table;

            $sql .= 'CREATE TABLE '.$prefixedTable.' (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name tinytext NOT NULL,
                PRIMARY KEY  (id)
            ) '.$charsetCollate.';';
		}
        
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        dbDelta($sql);
	}
}