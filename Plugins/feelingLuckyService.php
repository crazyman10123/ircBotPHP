<?PHP
class feelingLuckyService implements botPlugin
{
	
	public $commands = "ifl";
	
	public function onLoad() {
	
	}
	
	public function lmgtfy($sender, $command, $data, $config) {
		if (!empty($command[1])) { 
			$data[0]->sendMessage($sender[0], $sender[1].": http://google.com/search?q=".urlencode($command[1])."&btnI");
		} else {
			$data[0]->sendMessage($sender[0], $sender[1].": I can't just google nothing!");
		}
	}
}
?>