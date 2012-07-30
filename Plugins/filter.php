<?PHP
class filter implements botPlugin
{
	public $badWords = array();
	public $commands = "";
	public $canRun = true;

	public function onLoad() {
		if (!file_exists("badwords.txt")) {
			echo "badwords.txt is missing!\n";
			$this->canRun = false;
		} else {
			$this->canRun = true;
		}
		$badWordsList = file_get_contents("badwords.txt");
		$badWordsList = str_replace("*", "", $badWordsList);
		$this->badWords = explode("\n", $badWordsList);
	}
	
	public function onSpeak($sender, $command, $data, $config) {
		if ($this->canRun) {
			foreach ($this->badWords as &$badWord) {
				if (!empty($badWord)) {
					if (strstr(strtolower($command[2]), strtolower($badWord))) {
						$badword = true;					
					}
				}
			}
		}
		if ($badword) {
			$data[0]->runCommand("KICK ".$config->channel." ".$sender[1]." :Please don't swear.");
		}
	}
}
?>
