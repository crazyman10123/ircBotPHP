<?PHP

interface botPlugin
{
	public function onLoad();
}

class PluginManager
{

	public $loadedPlugins = array();
	
	function PluginManager($config) {
		$plugins = $config->plugins;
		sort($plugins);
		foreach ($plugins as &$plugin) {
			echo "Loading plugin '".$plugin."'...\n";
			if (file_exists("Plugins/".$plugin.".php")) {
				include("Plugins/".$plugin.".php");
				$this->loadPlugin(new $plugin(), $config);
			} else {
				echo "Unable to load '".$plugin."'!\nFile does not exist!\n";
			}
		}
		sort($config->allCommands);
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
