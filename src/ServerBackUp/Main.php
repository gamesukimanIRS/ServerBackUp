<?php

namespace ServerBackUp;

use pocketmine\Plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;
use ServerBackUp\BackUpTask;

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
				$this->serverBackUp();
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
	
	public function serverBackUp(){
		$timestamp = date("Y-m-d-H-i")."/";
		$pass = $this->getServer()->getDataPath();
		$this->dircopy($pass ."players/", $this->getDataFolder().$timestamp."/players");
		$this->dircopy($pass ."plugins/", $this->getDataFolder().$timestamp."/plugins");
		$this->dircopy($pass ."worlds/", $this->getDataFolder().$timestamp."/worlds");
		copy($pass ."banned-players.txt", $this->getDataFolder().$timestamp."/banned-players.txt");
		copy($pass ."banned-ips.txt", $this->getDataFolder().$timestamp."/banned-ips.txt");
		copy($pass ."ops.txt", $this->getDataFolder().$timestamp."/ops.txt");
		copy($pass ."white-list.txt", $this->getDataFolder().$timestamp."/white-list.txt");
		$this->getLogger()->info("バックアップ完了");
	}
	
	public function dircopy($dir_name, $new_dir){//コピー元、コピー先
		if (!is_dir($new_dir)) {
			mkdir($new_dir, 0744, true);
		} 
		if (is_dir($dir_name)){
			if ($dh = opendir($dir_name)) {
				while (($file = readdir($dh)) !== false) {
					$findpass = strpos($dir_name, "ServerBackUp");
					$findkbb = strpos($dir_name, "KillBearBoys");
					if($findpass === false and $findkbb === false){
						if ($file == "." || $file == "..") {
							continue;
						}
						if (is_dir($dir_name . "/" . $file)) {
							$this->dircopy($dir_name . "/" . $file, $new_dir . "/" . $file);
						}else{
							copy($dir_name . "/" . $file, $new_dir . "/" . $file);
						}
					}
				}
				closedir($dh);
			}
		}
	}

	public function onDisable(){
		$taskintervalconfig = $this->config->get("バックアップ間隔(min)");
		if(ctype_digit($taskintervalconfig)){
			$this->getServer()->getScheduler()->cancelAllTask();
		}
	}
}
