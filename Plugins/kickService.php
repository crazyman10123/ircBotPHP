<?PHP
class kickService implements botPlugin
{
	public $commands = "kick";

	public function onLoad() {
	}

	public function kick($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			$data[0]->runCommand("kick ".$config->channel." ".$command[1]." :Kicked by ".$sender[1]);
		}
	}
}
?>