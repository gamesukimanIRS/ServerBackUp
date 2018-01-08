<?php
namespace ServerBackUp;

use pocketmine\Thread;

use pocketmine\BackUpTask;
use pocketmine\Main;

class BackUp extends Thread{
	public function __construct(){
		# code...
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

	public function　run(){
		$this->serverBackUp();
		
	}
}