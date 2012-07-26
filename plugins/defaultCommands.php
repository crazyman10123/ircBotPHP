<?PHP
class defaultCommands implements iPlugin
{	
	public function onLoad() {
	}

	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		$exploded_message = explode(" ", $message);
		$command = $exploded_message[0];
		$user = explode("!", $rawdata);
		$user = substr($user[0], 1);
		array_shift($exploded_message);
		$parameters = implode(" ", $exploded_message);
		switch ($command) {
			case $config->prefix."reload":
				$connection->sendMessage($sender, "How about NO.");
				break;
			case $config->prefix."bye":
				if ($user == $config->owner || $user == $config->bye) {
					echo "Shutdown requested by ".$user."\n";
					$connection->sendMessage($sender, "Goodbye, ".$user);
					sleep(5);
					$connection->disconnect("Shutdown requested by ".$user, $config->channel);
				}
				break;
			case $config->prefix."plugins":
				$plugins = implode(" ", $config->plugins);
				$connection->sendMessage($sender, "Currently loaded plugins: ".$plugins);
				break;
			case $config->nick.": #":
				if ($user == $config->owner) {
					if (empty($parameters)) {
						$connection->sendMessage($sender, "What do you think I am, stupid?");
					} else {
						$connection->changeChannel($parameters, $config);
					}
				}
				break;
				case $config->nick.":#":
					if ($user == $config->owner) {
						if (empty($parameters)) {
							$connection->sendMessage($sender, "What do you think I am, stupid?");
						} else {
							$connection->changeChannel($parameters, $config);
						}
					}
					break;
			case $config->prefix."cp":
				if ($user == $config->owner) {
					if (empty($parameters[0])) {
						$connection->sendMessage($sender, "What do you think I am, stupid?");
					} else {
						$connection->sendMessage($sender, "My prefix is now ".$parameters[0]);
						$config->prefix = $parameters[0];
					}
				}
				break;
			case $config->nick.": prefix":
				$connection->sendMessage($sender, $user.", my prefix is '".$config->prefix."'");
				break;
			case $config->nick.":prefix":
				$connection->sendMessage($sender, $user.", my prefix is '".$config->prefix."'" );
				break;
			case $config->prefix."nick":
				if ($user == $config->owner) {
					$parameters = explode(" ", $parameters);
					if (empty($parameters[0])) {
						$connection->sendMessage($sender, "What do you think I am, stupid?");
					} else {
						if ($connection->changeNick($parameters[0], $config)) {
							$connection->sendMessage($sender, "My nickname is now ".$parameters[0]);
							$config->nick = $parameters[0];
						} else {
							$connection->sendMessage($sender, "I was unable to change my nick to ".$parameters[0]);
						}
					}
				}
				break;
					
		}
	}
}
?>
