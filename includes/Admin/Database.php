<?php
namespace GeorgeRujoiu\GameBattleStats\Admin;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;

class Database extends AbstractSingleton
{
	private $prefixedTable;

	private $wpdb;

	protected function __construct()
	{
		global $wpdb;

		# assign wpdb to it's own property
		$this->wpdb = $wpdb;

		# prefix the table name before adding to the db
		$this->prefixedTable = $this->wpdb->prefix;
	}

	public function select($table, array $columns)
	{
		$columns = implode(', ', $columns);
		return $this->wpdb->get_results('SELECT '.$columns.' FROM '.$this->prefixedTable.$table);
	}

	public function insert($table, array $config)
	{
		return $this->wpdb->insert($this->prefixedTable.$table, $config);
	}

	public function delete($table, array $config)
	{
		return $this->wpdb->delete($this->prefixedTable.$table, $config);
	}
}