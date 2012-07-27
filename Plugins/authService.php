<?PHP
class authService implements botPlugin
{

	public $commands = "auth,deauth";

	public function onLoad() {
	
	}
	
	public function auth($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if($data[0]->makeOwner($sender[1], $command[1], $hostmask, $config)) {
			$data[0]->sendMessage($sender[0], "You have been authorised.");
			echo "'".$sender[1]."' authorised successfully!\n";
		} else {
			echo "'".$sender[1]."' tried to authorise, but failed\n";
		}
	}
	
	public function deauth($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($hostmask, $config)) {
			$config->ownerHost = null;
			$data[0]->sendMessage($sender[0], "You have been deauthorised.");
			echo "'".$sender[1]."' deauthorised!\n";
		}
	}
}
?>