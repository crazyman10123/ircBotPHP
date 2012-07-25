<?PHP
class example implements iPlugin
{
	public $url = "http://goo.gl/CqhqH";
	
	public function onLoad() {
	}

	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		echo $sender." said ".$message;
		if ($message == $config->prefix."about") {	
			$connection->sendMessage($sender, "I'm coded in PHP, and my source is available at ".$url);
		}
	}

}
?>
