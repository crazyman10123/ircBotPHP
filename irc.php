<?PHP
class IRC
{

	public $irc = false;

	function IRC($server, $port, $nick, $channel, $password) {
		global $irc;
		$irc = fsockopen($server, $port);
		echo "PASS ".$password."\r\n";
		fputs($irc,"PASS ".$password."\r\n");
		fputs($irc,"NICK ".$nick."\r\n");
		fputs($irc,"USER ".$nick." * * :".$nick."\r\n");
		
		$this->connection = $irc;
	}
	
	function sendMessage($recipient, $message) {
		global $irc;
		fputs($irc->connection, "PRIVMSG ".$recipient." :".$message."\r\n");
	}
	
	function doAction($recipient, $action) {
		global $irc;
		fputs($irc->connection,"PRIVMSG ".$recipient." :".chr(1)."ACTION ".$action.chr(1)."\r\n");
	}
	
	function disconnect($message, $channel) {
		global $irc;
		fputs($irc->connection, "PART ".$channel." :".$message."\r\n");
		sleep(0.5);
		exit(0);
	}
	
	function cycle($config, $user) {
		global $irc;
		fputs($irc->connection, "PART ".$config->channel." :Cycle requested by ".$user."\r\n");
		fputs($irc->connection,"JOIN ".$config->channel."\r\n");
	}
	
	function changeChannel($channel, $config) {
		global $irc;
		fputs($irc->connection, "PART ".$config->channel." :Changing channel to ".$channel."\r\n");
		fputs($irc->connection,"JOIN ".$channel."\r\n");
		$config->channel = $channel;
	}

	function runCommand($command) {
		global $irc;
		fputs($irc->connection, $command."\r\n");
	}
	
	function isOwner($host, $config) {
		$generated_regex = str_replace("*", "[a-zA-Z0-9-]*", $config->authMask);
		$generated_regex = str_replace("~", "[~]?", $generated_regex);
		if (preg_match("/".$generated_regex."/", $host)) {
			return true;
		} else {
			return false;
		}
	}

}

?>
