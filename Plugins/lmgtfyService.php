<?PHP
class lmgtfyService implements botPlugin
{
	
	public $commands = "lmgtfy";
	
	public function onLoad() {
	
	}
	
	public function lmgtfy($sender, $command, $data, $config) {
		if (!empty($command[1])) { 
			$data[0]->sendMessage($sender[0], $sender[1].": http://lmgtfy.com/?q=".urlencode($command[1]));
		} else {
			$data[0]->sendMessage($sender[0], $sender[1].": I can't just google nothing!");
		}
	}
}
?>