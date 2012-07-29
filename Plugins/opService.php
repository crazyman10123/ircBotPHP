<?PHP
class opService implements botPlugin
{
	public $commands = "op,deop";

	public function onLoad() {
	}

	public function op($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if (!empty($command[1])) {
			if ($data[0]->isOwner($hostmask, $config)) {
				$data[0]->runCommand("mode ".$config->channel." +o ".$command[1]);
			}
		}
		else {
			if ($data[0]->isOwner($hostmask, $config)) {
				$data[0]->runCommand("mode ".$config->channel." +o ".$sender[1]);
			}
		}
	}

	public function deop($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if (!empty($command[1])) {
			if ($data[0]->isOwner($hostmask, $config)) {
				$data[0]->runCommand("mode ".$config->channel." -o ".$command[1]);
			}
		}
		else {
			if ($data[0]->isOwner($hostmask, $config)) {
				$data[0]->runCommand("mode ".$config->channel." -o ".$sender[1]);
			}
		}
	}
}
?>