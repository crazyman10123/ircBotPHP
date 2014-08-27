<?PHP

// Boot time
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$begintime = $time;

// Require the neccessary stuff
require('IRC.php');
require('Configuration.php');
require('PluginManager.php');

// Retrieve the configuration
$config = new Configuration();

// Hide any errors we get :)
//Most errors are due to the code checking for certain codes that show up in extended messages, so this line doesn't cause any actual problems.
if($config->debug == false) {
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
}	

// Set time zone
date_default_timezone_set($config->timeZone);

// Define extra variables
$exit = false;
$hasJoined = false;
$sender = null;
$error = false;
$reload = false;

// Fix channel capitalisation
$config->channel = strtolower($config->channel);

// Fix name to character limit (9)
$nickArr = str_split($config->nick);
$i = 0;
while($i < 9) {
	$newArr[$i] = $nickArr[$i];
	$i++;
}
$config ->nick = implode("", $newArr);
echo "Username is ".$config->nick."\n";

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
	if ((empty($value) || !isset($value)) && $name != "debug" && $name != "allCommands" && $name != "isAuth" && $name != "nickServ" && $name != "loadedPlugins") {
		echo "Please set ".$name." in config.php!\n";
		$error = true;
	}
}
if ($error) {
	die();
}

// Connect to the IRC server
$irc = new IRC($config->server, $config->port, $config->nick, $config->channel);

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
	while($data = fgets($irc->connection)) {
	
		// Debug mode
		if ($config->debug) {
			echo $data;
		} else {
			$data = str_replace(array(chr(10), chr(13)), '', $data);
		}
		
		// Explode data for checking stuff
		$newline_data = str_replace(array(chr(10), chr(13)), '', $data);
		$exploded_data = explode(" ", $newline_data);
		
		// Check for server connection
		if ($exploded_data[1] == "001") {
			if (!$hasJoined) {
				echo "Connected to server\n";
				if (!empty($config->nickServ)) {
					echo "Identifying with NickServ...\n";
					$irc->sendMessage("NickServ", "identify ".$config->nickServ);
				}
				sleep(10);
				$irc->runCommand("JOIN ".$config->channel);
			}
		}
		
		// Check if NickServ password is wrong
		if (!empty($config->nickServ) && $exploded_data[3] == ":Invalid" && $exploded_data[4] == "password") {
			if (!$hasJoined) {
				die ("Oh no, invalid NickServ password!\n");
			}
		}
		
		
		// Check if NickServ login was successful
		if ($exploded_data[3] == ":You" && $exploded_data[6] == "identified") {
			echo "Successfully identified with NickServ!\n";
		}
		
		
		// Check for channel ban
		if ($exploded_data[1] == "474" && $exploded_data[4] == ":Cannot" && $exploded_data[6] == "channel") {
			die($config->nick." is banned from ".$config->channel."\n");
		}
		
		// Check for channel join
		if ($exploded_data[1] == "JOIN" && ($exploded_data[2] == $config->channel || $exploded_data[2] == ":".$config->channel)) {
			if (!$hasJoined) {
				echo "Joined ".$config->channel."\n";
				$hasJoined = true;
				$time = microtime();
				$time = explode(" ", $time);
				$time = $time[1] + $time[0];
				$endtime = $time;
				$totaltime = round(($endtime - $begintime));
				echo "Boot time: ".$totaltime." seconds.\n";
			}
		}
		
		// Check if nick is registered
		if (empty($config->nickServ) && $exploded_data[3] == ":This" && $exploded_data[6] == "registered.") {
			if (!$hasJoined) {
				die ("Oh no, that nick is registered!\n");
			}
		}
		
		// Check if nick is 'already in use'
		if ($exploded_data[4] == ":Nickname" && $exploded_data[8] == "use.") {
			if (!$hasJoined) {
				die ("Oh no, that nick is in use!\n");
			}
		}
	
		// Ping Pong
		if($exploded_data[0] == "PING"){
			fputs($irc->connection, "PONG ".$exploded_data[1]."\r\n");
			echo "Server sent ping\n";
		}
		
		// If the bot is on the server and in a channel
		if ($hasJoined) {
				
			// CTCP PING
			if ($exploded_data[1] == "PRIVMSG" && $exploded_data[2] == $config->nick && $exploded_data[3] == ":".chr(1)."PING".chr(1)) {
				$exploded_hostmask = explode("!", $hostmask);
				$sender_nick = substr($exploded_hostmask[0], 1);
				$message = explode(":", $data);
				if (!empty($exploded_data[4])) {
					$irc->runCommand("NOTICE ".$sender_nick." :".chr(1)."PING ".$exploded_data[4].chr(1));
				} else {
					$irc->runCommand("NOTICE ".$sender_nick." :".chr(1)."PING".chr(1));
				}
			}
			
			// CTCP VERSION
			if ($exploded_data[1] == "PRIVMSG" && $exploded_data[2] == $config->nick && $exploded_data[3] == ":".chr(1)."VERSION".chr(1)) {
				$hostmask = $exploded_data[0];
				$exploded_hostmask = explode("!", $hostmask);
				$sender_nick = substr($exploded_hostmask[0], 1);
				$irc->runCommand("NOTICE ".$sender_nick." :".chr(1)."VERSION ".$config->version.chr(1));
			}
			
			// CTCP TIME
			if ($exploded_data[1] == "PRIVMSG" && $exploded_data[2] == $config->nick && $exploded_data[3] == ":".chr(1)."TIME".chr(1)) {
				$hostmask = $exploded_data[0];
				$exploded_hostmask = explode("!", $hostmask);
				$sender_nick = substr($exploded_hostmask[0], 1);
				$irc->runCommand("NOTICE ".$sender_nick." :".chr(1)."TIME ".date("F j, Y, g:i a").chr(1));
			}
			
			// PM sender retrieval
			if ($exploded_data[1] == "PRIVMSG" && $exploded_data[2] == $config->nick) {
				$exploded_data = explode(" ", $data);
				$exploded_message = explode(" PRIVMSG ".$config->nick." :", $data);
				$message = $exploded_message[1];
				$hostmask = $exploded_data[0];
				$exploded_hostmask = explode("!", $hostmask);
				$sender_nick = substr($exploded_hostmask[0], 1);
				$sender = $sender_nick;
			}
			
			// Channel sender retrieval
			if ($exploded_data[1] == "PRIVMSG" && $exploded_data[2] == $config->channel) {
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
			if($message == "prefix") {
				$data[0]->sendMessage($sender[0], "Current prefix is ".$config->prefix);
			}
			foreach ($config->loadedPlugins as &$loadedPlugin) {
				if (method_exists($loadedPlugin, "onSpeak")) {
					$loadedPlugin->onSpeak($sender, $command, $data, $config);
				}
				$pluginCommands = explode(",", $loadedPlugin->commands);
				if ($message[0] == $config->prefix) {
					if($command[0] == "restart") {
						$exploded_data = explode(" ", $data[1]);
						$hostmask = $exploded_data[0];
						if ($data[0]->isOwner($hostmask, $config)) {
							$data[0]->sendMessage($sender[0], "Restarting. Please wait.");
							exit(1);
						}
					} else {
						foreach ($pluginCommands as &$pluginCommand) {	
							if ($command[0] == $pluginCommand) {
								if (!method_exists($loadedPlugin, $command[0])) {
									die("Error, a command was defined without creating a function for it!\n");
								} else {
									if (empty($parameters)) {
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
			}
			unset($message);
			unset($sender);
		}
	}
}
?>
