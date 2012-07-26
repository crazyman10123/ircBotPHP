<?PHP
class isup implements iPlugin
{ 
	
	function isOnline($site) {
		$fp = @fsockopen($site, 80, $errno, $errstr, 2);
		if (!$fp) {
			return false;
		} else { 
			return true;
		}
	}
	
	public function onLoad() {

	}
	
	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		$exploded_message = explode(" ", $message);
		if($exploded_message[0] == $config->prefix."isup") {
			array_shift($exploded_message);
			$parameters = $exploded_message[0];
			if ($this->isDomainAvailible($parameters)) {
				$connection->sendMessage($sender, $parameters." is up and running!");
			} else {
				$connection->sendMessage($sender, $parameters." is currently down. Sorry.");
			}
		}
	}
}
?>
