<?PHP
class Configuration
{
	public $timeZone = "GMT"; // Your timezone (for CTCP TIME)

	public $server = "irc.freenode.net"; // The IRC server to connect to
	public $nick = "DeadBot5"; // The Nick that the bot should use
	public $channel = "##super"; // The Channel that the bot should join
	public $prefix = "-"; // The Prefix to use when running commands
	public $authMask = ":tcial!~tcial@host-87-75-138-84.dslgb.com"; // Your IRC hostmask (with semicolon at beginning)

	public $nickServ = "jack"; // The nickserv password for the username, if it is registered (optional)
	
	public $plugins = array("authService", "defaultCommands", "filter", "lmgtfyService", "shortenService", "isupService", "quotes", "xkcdComics", "pastebinService", "guessGame"); // A list of plugins to enable
	
	public $debug = false; // Debug mode - DO NOT TOUCH UNLESS YOU KNOW WHAT YOU ARE DOING!
	
	public $version = "ircBot v3.5 unstable"; // DO NOT EDIT

	// DO NOT MODIFY
	public $allCommands = array();
	public $isAuth = null;
	public $loadedPlugins = array();
}
?>
