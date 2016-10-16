<?php
namespace GeorgeRujoiu\GameBattleStats;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;
use GeorgeRujoiu\GameBattleStats\Admin;

class GameBattleStats extends AbstractSingleton
{
	public function run()
	{
		if (is_admin()) {
			Admin::getInstance();
		}
	}
}