<?PHP
class Config
{
	public $server = ""; // IRC server
	public $nick = "ircBotV2"; // bot's nickname
	public $channel = ""; // channel to join
	public $plugins = array("defaultCommands", "googl", "lmgtfy",  "isup", "examples"); // plugins to load
	public $prefix = "-"; // prefix to call the bot by. e.g. -plugins
	public $owner = ""; // admin able to access all defaultCommands
	public $bye = ""; // user with 'bye' permissions
}
?>
