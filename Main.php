<?PHP

// Require the neccessary stuff
require('IRC.php');
require('Configuration.php');
require('PluginManager.php');

// Retrieve the configuration
$config = new Configuration();

// Define extra variables
$exit = false;
$hasJoined = false;
$sender = null;

// Validate the configuration
$config_options = get_class_vars("Configuration");
if (!filter_var("http://".$config->server, FILTER_VALIDATE_URL) && !empty($config->server)) {
	echo "Invalid server!\n";
	$error = true;
}
if ($config->channel[0] != "#" && !empty($config->channel)) {
	echo "Invalid channel!\n";
	$error = true;
}
foreach ($config_options as $name => $value) {
	if ((empty($value) || !isset($value)) && $name != "debug" && $name != "allCommands" && $name != "ownerHost" && $name != "nickServ") {
		echo "Please set ".$name." in config.php!\n";
		$error = true;
	}
}
if ($error) {
	die();
}

// Connect to the IRC server
$irc = new IRC($config->server, $config->nick, $config->channel);

// Create plugin manager and load plugins
$pluginManager = new PluginManager($config);

// Status notification
echo "Attempting to connect to ".$config->server."\n";

// Check connection
if ($irc->connection == false) {
	die("Unable to connect to ".$config->server."\n");
}

// Loop until exit
while (!$exit) {
	while($data = fgets($irc->connection, 128)) {
	
		// Debug mode
		if ($config->debug) {
			echo $data;
		}
		
		// Check for server connection
		if (strstr($data, "376 ".$config->nick." :End of /MOTD command.")) {
			if (!$hasJoined) {
				echo "Connected to server\n";
				$irc->sendMessage("NickServ", "identify ".$config->nickServ);
				echo "Waiting 5 seconds for identification...\n";
				sleep(5);
				$irc->runCommand("JOIN ".$config->channel);
			}
		}
		
		// Check for channel join
		if (strstr($data, $config->nick) && strstr($data, "JOIN ".$config->channel)) {
			if (!$hasJoined) {
				echo "Joined ".$config->channel."\n";
				$hasJoined = true;
			}
		}
		
		// Check if nick is registered
		if (empty($config->nickServ) && strstr($data, "This nickname is registered.")) {
			if (!$hasJoined) {
				die ("Oh no, that nick is registered!\n");
			}
		}
		
		// Check if ns password is wrong
		if (!empty($config->nickServ) && strstr($data, "Invalid password for ")) {
			if (!$hasJoined) {
				die ("Oh no, invalid nickserv password!\n");
			}
		}
		
		// Check if nick is 'already in use'
		if (strstr($data, "Nickname is already in use.")) {
			if (!$hasJoined) {
				die ("Oh no, that nick is in use!\n");
			}
		}
		
		// Ping Pong
		$ex = explode(' ', $data);
		if($ex[0] == "PING"){
			fputs($irc->connection, "PONG ".$ex[1]."\r\n");
			echo "Server sent ping\n";
		}
		
		
		// If the bot is on the server and in a channel
		if ($hasJoined) {
		
			// PM sender retrieval
			if (strstr($data, " PRIVMSG ".$config->nick." :")) {
				$exploded_data = explode(" ", $data);
				$exploded_message = explode(" PRIVMSG ".$config->nick." :", $data);
				$message = $exploded_message[1];
				$hostmask = $exploded_data[0];
				$exploded_hostmask = explode("!", $hostmask);
				$sender_nick = substr($exploded_hostmask[0], 1);
				$sender = $sender_nick;
			}
			
			// Channel sender retrieval
			if (strstr($data, " PRIVMSG ".$config->channel." :")) {
				$exploded_data = explode(" ", $data);
				$hostmask = $exploded_data[0];
				$exploded_hostmask = explode("!", $hostmask);
				$sender_nick = substr($exploded_hostmask[0], 1);
				$sender = $sender_nick;
				$exploded_message = explode(" PRIVMSG ".$config->channel." :", $data);
				$message = $exploded_message[1];
				$sender = $config->channel;
			}
			
			$sender = array($sender, $sender_nick);
			
			$message = str_replace(array(chr(10), chr(13)), '', $message);
			
			// Check plugin commands
			$message_split = explode(" ", $message);
			$command = substr($message_split[0], 1);
			array_shift($message_split);
			$parameters = implode(" ", $message_split);
			$data = array($irc, $data);
			$command = array($command, $parameters, $message);
			foreach ($pluginManager->loadedPlugins as &$loadedPlugin) {
				if (method_exists($loadedPlugin, "onSpeak")) {
					$loadedPlugin->onSpeak($sender, $command, $data, $config);
				}
				$pluginCommands = explode(",", $loadedPlugin->commands);
				if ($message[0] == $config->prefix) {
					foreach ($pluginCommands as &$pluginCommand) {	
						if ($command[0] == $pluginCommand) {
							if (!method_exists($loadedPlugin, $command[0])) {
								die("Error, a command was defined without creating a function for it!\n");
							} else {
								if (empty($parameters) || $command[1] == $config->authPass) {
									echo "'".$sender[1]."' ran '".$command[0]."'\n";
								} else {
									echo "'".$sender[1]."' ran '".$command[0]." ".$command[1]."'\n";
								}
								$loadedPlugin->$command[0]($sender, $command, $data, $config);
							}
						}
					}
				}
			}
			unset($message);
			unset($sender);
		}
		
		
	}
}
?>
