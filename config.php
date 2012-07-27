<?PHP
class Config
{
	public $server = "irc.freenode.net"; // IRC server
	public $nick = "HeathBot"; // bot's nickname
	public $channel = "#botwar"; // channel to join
	public $plugins = array("defaultCommands", "googl", "lmgtfy",  "isup", "filter", "uptime",  "example"); // plugins to load
	public $prefix = "-"; // prefix to call the bot by. e.g. -plugins
	public $owner = "x12"; // admin able to access all defaultCommands (this should be your NickServ username)
	public $debug = false; // don't use this
}
?>
