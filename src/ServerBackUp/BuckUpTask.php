<?php
namespace ServerBackUp;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;

use ServerBackUp\BuckUp;
use ServerBackUp\Main;


class BackUpTask extends PluginTask{
	public function __construct(PluginBase $owner) {
		$this->owner = $owner;
	}

	public function onRun(int $currentTick){
		$buckUp = new BackUp();
		$backUp->start();
	}
}