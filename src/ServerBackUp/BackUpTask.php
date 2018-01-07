<?php
namespace ServerBackUp;

use pocketmine\scheduler\PluginTask;
use pocketmine\plugin\PluginBase;
use ServerBackUp\Main;

class BackUpTask extends PluginTask{
	public function __construct(PluginBase $owner) {
		$this->owner = $owner;
	}
	public function onRun(int $currentTick){
		$this->owner->serverBackUp();
	}
}
