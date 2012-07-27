<?PHP
class defaultCommands implements iPlugin
{	
	public function onLoad() {
	}

	public function getUser($data, $connection) {
		$user = explode("!", $data);
		$user = substr($user[0], 1);
		fputs($connection->connection, "WHO ".$user." %na\r\n");
		return fgets($connection->connection, 128)."\n";
	}
	
	public function isOwner($data, $connection, $config) {
		
	}

	public function onSpeak($sender, $message, $rawdata = null, $connection, $config) {
		$exploded_message = explode(" ", $message);
		$command = $exploded_message[0];
		array_shift($exploded_message);
		$parameters = implode(" ", $exploded_message);
		$user = $this->getUser($data, $connection);
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
				
			case $config->prefix."cc":
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
					
		}
	}
}
?>
