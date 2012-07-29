<?PHP
class Configuration
{
	public $timeZone = "GMT"; // Your timezone (for CTCP TIME)

	public $server = ""; // The IRC server to connect to
	public $nick = ""; // The Nick that the bot should use
	public $channel = ""; // The Channel that the bot should join
	public $prefix = "-"; // The Prefix to use when running commands
	public $authMask = ""; // Your IRC hostmask (accepts wildcards) E.G. tcial!~tcial@*.dslgb.com (the ~ is replaced to check if you are identified or not)

	public $nickServ = ""; // The nickserv password for the username, if it is registered (optional)
	
	public $plugins = array("defaultCommands", "guessGame", "lmgtfyService", "quotes", "filter", "isupService", "opService", "shortenService", "findURLService", "kickService", "pastebinService", "xkcdComics"); // A list of plugins to enable
	
	public $debug = false; // Debug mode - DO NOT TOUCH UNLESS YOU KNOW WHAT YOU ARE DOING!
	
	public $version = "ircBot v3.5 unstable"; // DO NOT EDIT

	// DO NOT MODIFY
	public $allCommands = array();
	public $loadedPlugins = array();
}
?>
