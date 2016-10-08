<?php
namespace GeorgeRujoiu\GameBattleStats;

use GeorgeRujoiu\GameBattleStats\AbstractSingleton;

class Deactivator extends AbstractSingleton
{
	private $tables = [
		'platforms',
		'ladders',
		'tournaments',
	];

	public function deactivate()
	{
		global $wdpb;
	}
}