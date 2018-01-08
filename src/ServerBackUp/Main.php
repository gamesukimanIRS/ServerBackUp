<?php

namespace ServerBackUp;

use pocketmine\Plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;

use ServerBackUp\BuckUp;
use ServerBackUp\BuckUpTask;

class Main extends PluginBase implements Listener{
	
	public function onEnable(){//このプラグインが読み込まれたときの処理
		$PluginName = "ServerBackUp";
		$version = "1.0";
		$this->getlogger()->info($PluginName." v".$version."を読み込みました。作者:gamesukimanIRS");
    	$this->getlogger()->warning("製作者偽りと二次配布、改造、改造配布はおやめ下さい。");
    	$this->getlogger()->info("このプラグインを使用する際はどこかにプラグイン名「".$PluginName."」と作者名「gamesukimanIRS」を記載する事を推奨します。");
    	$this->getLogger()->info("this plugin enabled");
		if(!file_exists($this->getDataFolder())){ 
		mkdir($this->getDataFolder(), 0755, true); 
		}
		$this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
			'#バックアップ間隔を分単位で設定できます。offで無効化されます。数字、off以外を入力するとエラーになります。',
			'バックアップ間隔(min)' => "180"
		));
		$taskintervalconfig = $this->config->get("バックアップ間隔(min)");
		if(ctype_digit($taskintervalconfig)){
			$taskintervalconfig = intval($taskintervalconfig);
			$this->getLogger()->notice("サーバーバックアップがオンに指定されました。".$taskintervalconfig."分の間隔でバックアップします。");
			$taskinterval = 20 * 60 * $taskintervalconfig;
			$task = new BackUpTask($this);
			$this->getServer()->getScheduler()->scheduleRepeatingTask($task, $taskinterval);
		}else{
			if ($taskintervalconfig == "off") {
				$backup = new BackUp();
				$backup->start();
				$this->getLogger()->notice("サーバーバックアップはオフです。/backupで手動でバックアップができます。");
			}else{
				$this->config->set("バックアップ間隔(min)","error");
				$this->config->save();
				$this->getLogger()->error("config.ymlに数字、off以外の値が指定されています。再設定して再起動してください。数字、offなどの値は半角の".'「"」'."で囲ってください。");
				$this->getServer()->getPluginManager()->disablePlugin($this);
			}
		}
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
		if($command->getName() == "backup"){
			$this->serverBackUp();
			$sender->sendMessage("バックアップ完了");
			return true;
		}
	}

	public function onDisable(){
		$taskintervalconfig = $this->config->get("バックアップ間隔(min)");
		if(ctype_digit($taskintervalconfig)){
			$this->getServer()->getScheduler()->cancelAllTask();
		}
	}
}