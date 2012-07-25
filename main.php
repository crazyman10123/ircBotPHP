<?PHP

// Require neccecary stuff
require('irc.php');
require('config.php');
require('pluginmgr.php');

// Configuration
$config = new Config();

// Connect
$connection = new IRC($config->server, $config->nick, $config->channel);

// Load plugins
loadplugins($config->plugins);

// Check connection
if ($connection->connection == false) {
	die("Unable to connect to ".$config->server);
}

while(1) {
	while($data = fgets($connection->connection, 128)) {

		// Check for MOTD
		if (strstr($data, "End of /MOTD command")) {
			echo "Joined server!\n";
		}

		// Check for speaking
		if ((strstr($data, " PRIVMSG ".$config->channel) || strstr($data, " PRIVMSG ".$config->nick))) {
			$split_data = explode(" PRIVMSG ", $data);
			$message = str_replace(array(chr(10), chr(13)), '', $split_data[1]);
			$message = explode(" :", $message);
			$sender = $message[0];
			if ($sender == $config->nick) {
				$sender = explode("!", $data);
				$sender = substr($sender[0], 1);
			}
			array_shift($message);
			$message = implode(" ", $message);
			foreach ($loadedPlugins as &$loadedPlugin) {
				$loadedPlugin->onSpeak($sender, $message, $data, $connection, $config);
			}
		}

		// Ping
		$ex = explode(' ', $data);
		if($ex[0] == "PING"){
		fputs($connection->connection, "PONG ".$ex[1]."\r\n");
		echo "Server sent ping\n";
		}

	}
}
?>
