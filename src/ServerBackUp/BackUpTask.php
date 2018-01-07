<?php



class BackUpTask extends PluginTask{
	public function __construct(PluginBase $owner) {
		$this->owner = $owner;
	}
	public function onRun(int $currentTick){
		$this->owner->serverBackUp();
	}
}
