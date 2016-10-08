<?php
namespace GeorgeRujoiu\GameBattleStats;

abstract class AbstractSingleton
{
	protected static $instance;

	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	protected function __construct()
	{
	}

	private function __clone()
	{
	}

	private function __wakeup()
	{
	}
}