<?php
namespace GeorgeRujoiu\GameBattleStats;

abstract class AbstractSingleton
{
	protected static $instance ;

	public static function getInstance()
	{
		if (null === static::$instance || !is_a(static::$instance, get_called_class())) {
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