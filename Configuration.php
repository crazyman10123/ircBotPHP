<?PHP
class Configuration
{
	public $server = "";
	public $nick = "";
	public $channel = "";
	public $prefix = "-";
	public $authUser = "";
	public $authPass = "";
	
	public $plugins = array("authorisation", "defaultCommands");
	
	public $debug = false;
	
	public $allCommands = array();
	public $ownerHost = null;
}
?>
