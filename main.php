<?PHP

// Require neccessary stuff
require('irc.php');
require('config.php');
require('pluginmgr.php');

// Configuration
$config = new Config();

// Validate configuration
$error = false;
$vars = get_class_vars("Config");
if (!filter_var("http://".$config->server, FILTER_VALIDATE_URL) && !empty($config->server)) {
	echo "Invalid server!\n";
	$error = true;
}
if ($config->channel[0] != "#" && !empty($config->channel)) {
	echo "Invalid channel!\n";
	$error = true;
}
foreach ($vars as $name => $value) {
	if ((empty($value) || !isset($value)) && $name != "debug") {
		echo "Please set ".$name." in config.php!\n";
		$error = true;
	}
}
if ($error) {
	die();
} else {
	$joined = false;
}

// Connect
$connection = new IRC($config->server, $config->nick, $config->channel);

// Load plugins
loadplugins($config->plugins);

// Status notification
echo "Attempting to connect to ".$config->server."\n";

// Check connection
if ($connection->connection == false) {
	die("Unable to connect to ".$config->server."\n");
}

while(1) {
	while($data = fgets($connection->connection, 128)) {
		
		// Debug mode
		if ($config->debug) {
			echo $data;
		}
		
		// Check for registered
		if (strstr($data, "This nickname is registered.")) {
			if (!$joined) {
				die ("Oh no, that nick is registered to someone else!\n");
			}
		}
		
		// Check for nick use
		if (strstr($data, "Nickname is already in use.")) {
			if (!$joined) {
				die ("Oh no, that nick is in use!\n");
			}
		}
		
		// Check for MOTD
		if (strstr($data, "End of /MOTD command.")) {
			if (!$joined) {
				echo "Joined server!\n";
				fputs($connection->connection,"JOIN ".$config->channel."\r\n");
			}
		}

		// Check for channel join
		if (strstr($data, $config->nick) && strstr($data, "JOIN ".$config->channel)) {
			if (!$joined) {
				echo "Joined ".$config->channel."\n";
				$joined = true;
			}
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
