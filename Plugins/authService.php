<?PHP
class authService implements botPlugin
{

	public $commands = "auth,deauth,isauth";

	public function onLoad() {
	
	}
	
	public function auth($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if($data[0]->makeOwner($hostmask, $config)) {
			$data[0]->sendMessage($sender[0], "You have been authorised.");
			echo "'".$sender[1]."' authorised successfully!\n";
		} else {
			echo "'".$sender[1]."' tried to authorise, but failed\n";
		}
	}
	
	public function deauth($sender, $command, $data, $config) {
		$exploded_data = explode(" ", $data[1]);
		$hostmask = $exploded_data[0];
		if ($data[0]->isOwner($config)) {
			$config->isAuth = null;
			$data[0]->sendMessage($sender[0], "You have been de-authorised.");
			echo "'".$sender[1]."' de-authorised!\n";
		}
	}
	
	public function isauth($sender, $command, $data, $config) {
		if ($data[0]->isOwner($config)) {
			$data[0]->sendMessage($sender[0], "You are authorised.");
		}
	}
}
?>
