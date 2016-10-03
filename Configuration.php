<?PHP
class Configuration
{
	public $timeZone = "GMT"; // Your timezone (for CTCP TIME)

	public $server = "irc.chat.twitch.tv"; // The IRC server to connect to
	public $port = "6667"; //The IRC Server's Port
	public $nick = ""; // The Nick that the bot should use
	public $channel = ""; // The Channel that the bot should join
	public $oauth = "";
	public $prefix = "!"; // The Prefix to use when running commands
	public $authMask = ""; // Your IRC hostmask (accepts wildcards) E.G. tcial!~tcial@*.dslgb.com (the ~ is replaced to check if you are identified or not)
	//Your IRC hostmask is used for the bot to identify you as the owner and administrator. 

	public $nickServ = ""; // The nickserv password for the username, if it is registered (optional)
	
	//List your plugins here (by filename). End each line wth a comma and make sure the file name is in quotes.
	public $plugins = array(
		"defaultCommands",
		"lmgtfyService",
		"guessGame",
		"filterTwitch"
	); 
	
	public $debug = false; // Debug mode - DO NOT TOUCH UNLESS YOU KNOW WHAT YOU ARE DOING!
	
	public $version = "ircBot v4.0 unstable"; // DO NOT EDIT

	// DO NOT MODIFY
	public $allCommands = array();
	public $loadedPlugins = array();
}
?>
