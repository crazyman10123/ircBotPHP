<?PHP
class Configuration
{
	public $timeZone = "GMT"; // Your timezone (for CTCP TIME)

	public $server = "irc.freenode.net"; // The IRC server to connect to
	public $nick = "DeadBot5"; // The Nick that the bot should use
	public $channel = "#test"; // The Channel that the bot should join
	public $prefix = "-"; // The Prefix to use when running commands
	public $authMask = "*.dslgb"; // Your IRC hostmask (accepts wildcards) E.G. tcial!~tcial@*.dslgb.com (the ~ is replaced to check if you are identified or not)

	public $nickServ = "jack"; // The nickserv password for the username, if it is registered (optional)
	
	//List your plugins here (by filename). End each line wth a comma and make sure the file name is in quotes.
	public $plugins = array(
		"defaultCommands",
		"guessGame",
		"lmgtfyService",
		"filter",
		"isupService",
		"opService",
		"shortenService",
		"findURLService",
		"kickService",
		"pastebinService",
		"xkcdComics",
		"feelingLuckyService"
	); 
	
	public $debug = false; // Debug mode - DO NOT TOUCH UNLESS YOU KNOW WHAT YOU ARE DOING!
	
	public $version = "ircBot v3.5 unstable"; // DO NOT EDIT

	// DO NOT MODIFY
	public $allCommands = array();
	public $loadedPlugins = array();
}
?>
