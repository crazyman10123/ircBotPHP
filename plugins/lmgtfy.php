<?PHP
class lmgtfy implements iPlugin
{	
	public function onLoad() {
	}

	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		$exploded_message = explode(" ", $message);
		if ($exploded_message[0] == $config->prefix."lmgtfy") {
			array_shift($exploded_message);
			$parameters = implode(" ", $exploded_message);
			if (empty($parameters)) {
				$connection->sendMessage($sender, "I can't just google nothing!");
			} else {
				$connection->sendMessage($sender, "http://lmgtfy.com/?q=".urlencode($parameters));
			}
		}
	}
}
?>