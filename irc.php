<?PHP
class IRC
{

	public $connection = false;

	function IRC($server, $nick, $channel) {
		global $connection;
		$connection = fsockopen($server, 6667);
                fputs($connection,"NICK ".$nick."\r\n");
		fputs($connection,"USER ".$nick." * * :".$nick."\r\n");
		$this->connection = $connection;
	}
	
	function sendMessage($recipient, $message) {
		global $connection;
		fputs($connection->connection, "PRIVMSG ".$recipient." :".$message."\r\n");
	}
	
	function disconnect($message, $channel) {
		global $connection;
		fputs($connection->connection, "PART ".$channel." :".$message."\r\n");
		sleep(5);
		exit(0);
	}
	
	function changeChannel($channel, $config) {
		global $connection;
		fputs($connection->connection, "PART ".$config->channel." :Changing channel to ".$channel."\r\n");
		fputs($connection->connection,"JOIN ".$channel."\r\n");
		$config->channel = $channel;
	}

	function runCommand($command) {
		global $connection;
		fputs($connection->connection, $command."\r\n");
	}
	

}

?>
