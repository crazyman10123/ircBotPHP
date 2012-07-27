<?PHP

interface botPlugin
{
	public function onLoad();
}

class PluginManager
{

	public $loadedPlugins = array();
	
	function PluginManager($plugins, $config) {
		foreach ($plugins as &$plugin) {
			echo "Loading plugin '".$plugin."'...\n";
			if (file_exists("plugins/".$plugin.".php")) {
				include("plugins/".$plugin.".php");
				$this->loadPlugin(new $plugin(), $config);
			} else {
				echo "Unable to load '".$plugin."'!\nFile does not exist!\n";
			}
		}
	}
	
	function loadPlugin($plugin, $config) {
		global $loadedPlugins;
		if (!isset($plugin->commands)) {
			die("There is no commands variable in ".get_class($plugin)."\n");
		} else {
			$commands = explode(",", $plugin->commands);
			foreach ($commands as &$command) {
				array_push($config->allCommands, $command);
			}
		}		
		$plugin->onLoad();
		array_push($this->loadedPlugins, $plugin);
	}
}

?>