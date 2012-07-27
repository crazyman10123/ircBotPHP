<?PHP
class filter implements iPlugin
{
	public $badMessage = "Hey don't say that!";
	public $badWords = array();

	public function onLoad() {
		if (!file_exists("badwords.txt")) {
			die("badwords.txt is missing!\n");
		}
		$badWordsList = file_get_contents("badwords.txt");
		$badWordsList = str_replace("*", "", $badWordsList);
		$this->badWords = explode("\n", $badWordsList);
	}
	
	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		$user = explode("!", $rawdata);
		$user = substr($user[0], 1);
		foreach ($this->badWords as &$badWord) {
			if (!empty($badWord)) {
				if (strstr(strtolower($message), strtolower($badWord))) {
					$badword = true;					
				}
			}
		}
		if ($badword) {
			$connection->runCommand("KICK ".$config->channel." ".$user." :Please don't swear.");
		}
	}
}
?>
