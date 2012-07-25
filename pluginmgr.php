<?PHP

$loadedPlugins = array();

interface iPlugin
{
	public function onLoad();
	public function onSpeak($sender, $message, $rawdata, $connection, $config);
    /* Optional methods to implement
     public function onUnload();
     public function onSpeak();
     public function onBeforeSpeak();
     */
}

function loadPlugins($plugins, $reload = false) {
	global $loadedPlugins;
	if ($reload) {
		$loadedPlugins = array();
		foreach ($plugins as &$plugin) {
			echo "Reoading plugin '".$plugin."'...\n";
			loadPlugin(new $plugin());
		}
	} else {
		foreach ($plugins as &$plugin) {
			echo "Loading plugin '".$plugin."'...\n";
			if (file_exists("plugins/".$plugin.".php")) {
				include("plugins/".$plugin.".php");
				loadPlugin(new $plugin());
			} else {
				echo "Unable to load '".$plugin."'!\nFile does not exist!\n";
			}
		}
	}
}

function loadPlugin($plugin) {
	global $loadedPlugins;
	$plugin->onLoad();
	array_push($loadedPlugins, $plugin);
}

?>