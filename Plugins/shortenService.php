<?PHP
class shortenService implements botPlugin
{
	
	public $commands = "shorten";
	
	public function onLoad() {
	
	}
	
	public function shorten($sender, $command, $data, $config) {
		if ((!filter_var($command[1], FILTER_VALIDATE_URL)) || strstr($command[1], "tinyurl")) {
			$data[0]->sendMessage($sender[0], $sender[1].": Well, that's not going to work!");
		} else {
			if (!empty($command[1])) { 
				$data[0]->sendMessage($sender[0], $sender[1].": ".file_get_contents("http://tinyurl.com/api-create.php?url=".$command[1]));
			} else {
				$data[0]->sendMessage($sender[0], $sender[1].": I can't just shorten nothing!");
			}
		}
	}
}
?>