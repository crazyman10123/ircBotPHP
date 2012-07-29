<?PHP
class defaultCommands implements botPlugin
{

	public $commands = "help,about,version,poweroff,uptime,cycle,prefix,say,action,cc,reload";
	public $begintime;
	
	public function onLoad() {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$this->begintime = $time;
	}
	
	public function secondsToTime($seconds) {
		$hours = floor($seconds / (60 * 60));
		$divisor_for_minutes = $seconds % (60 * 60);
		$minutes = floor($divisor_for_minutes / 60);
		$divisor_for_seconds = $divisor_for_minutes % 60;
		$seconds = ceil($divisor_for_seconds);
		$obj = array(
			"h" => (int) $hours,
			"m" => (int) $minutes,
			"s" => (int) $seconds,
		);
		return $obj;
	}
	
	public function help($sender, $command, $data, $config) {
		$commands = implode(" ", $config->allCommands);
		$data[0]->sendMessage($sender[0], "Commands:".$commands);
	}
	
	public function about($sender, $command, $data, $config) {
		$data[0]->sendMessage($sender[0], $sender[1].": ".chr(2)."ircBot v3.5 ".chr(3)."4"."unstable".chr(3).chr(15)." - http://github.com/jackwilsdon/ircBot/");
	}
	
	public function version($sender, $command, $data, $config) {
		$data[0]->sendMessage($sender[0], $sender[1].": ".chr(2)."ircBot v3.5 ".chr(3)."4"."unstable".chr(3).chr(15)." - http://github.com/jackwilsdon/ircBot/");
	}
	
	public function lmgtfy($sender, $command, $data, $config) {
		if (!empty($command[1])) { 
			$data[0]->sendMessage($sender[0], $sender[1].": http://lmgtfy.com/?q=".urlencode($command[1]));
		} else {
			$data[0]->sendMessage($sender[0], $sender[1].": I can't just google nothing!");
		}
	}
	
	public function poweroff($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			$data[0]->disconnect("Shutdown requested by ".$sender[1], $config->channel);
			exit(0);
		}
	}
	
	public function uptime($sender, $command, $data, $config) {
		$time = microtime();
		$time = explode(" ", $time);
		$time = $time[1] + $time[0];
		$endtime = $time;
		$totaltime = ($endtime - $this->begintime);
		$time = $this->secondsToTime($totaltime);
		$data[0]->sendMessage($sender[0], "I have been up for ".$time['h']." hours, ".$time['m']." minutes and ".$time['s']." seconds!");
	}
	
	public function cycle($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			$data[0]->cycle($config, $sender[1]);
		}
	}
	
	public function prefix($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		$prefix = $command[1];
		if ($data[0]->isOwner($hostmask, $config)) {
			if (!empty($command[1])) {
				$data[0]->sendMessage($sender[0], "My prefix has been changed to ".$prefix[0]);
				$config->prefix = $prefix[0];
			} else {
				$data[0]->sendMessage($sender[0], "Well that won't work!");
			}
		}
	}

	public function say($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			$data[0]->sendMessage($config->channel, $command[1]);
		}
	}
	
	public function action($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			$data[0]->doAction($config->channel, $command[1]);
		}
	}

	public function cc($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			if (!empty($command[1])) {
				$data[0]->changeChannel($command[1], $config);
			}
		}
	}

	public function reload($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			foreach ($config->loadedPlugins as &$plugin) {
				echo "Reloading ".get_class($plugin)."\n";
				runkit_import(get_class($plugin));
			}
		}
	}
}
?>