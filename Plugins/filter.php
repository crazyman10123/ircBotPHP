<?PHP
class filter implements botPlugin
{
	public $badMessage = "Hey don't say that!";
	public $badWords = array();
	public $commands = "";

	public function onLoad() {
		if (!file_exists("badwords.txt")) {
			die("badwords.txt is missing!\n");
		}
		$badWordsList = file_get_contents("badwords.txt");
		$badWordsList = str_replace("*", "", $badWordsList);
		$this->badWords = explode("\n", $badWordsList);
	}
	
	public function onSpeak($sender, $command, $data, $config) {
		foreach ($this->badWords as &$badWord) {
			if (!empty($badWord)) {
				if (strstr(strtolower($command[2]), strtolower($badWord))) {
					$badword = true;					
				}
			}
		}
		if ($badword) {
			$data[0]->runCommand("KICK ".$config->channel." ".$sender[1]." :Please don't swear.");
		}
	}
}
?>
