<?PHP
class Configuration
{
	public $server = ""; // The IRC server to connect to
	public $nick = ""; // The Nick that the bot should use
	public $channel = ""; // The Channel that the bot should join
	public $prefix = "-"; // The Prefix to use when running commands
	public $authUser = ""; // Your IRC username
	public $authPass = ""; // A password to use with the -auth command
	
	public $nickServ = ""; // The nickserv password for the username, if it is registered (optional)
	
	public $plugins = array("authService", "defaultCommands", "filter", "lmgtfyService", "shortenService", "isupService", "quotes", "xkcdComics", "pastebinService", "guessGame"); // A list of plugins to enable
	
	public $debug = false; // Debug mode - DO NOT TOUCH UNLESS YOU KNOW WHAT YOU ARE DOING!
	

	// DO NOT MODIFY
	public $allCommands = array();
	public $ownerHost = null;
}
?>