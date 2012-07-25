ircBot v2
=========
IRCBot is a basic bot I coded in PHP made for CLI use. It supports plugins, but can only join one channel at a time.
**WARNING: THIS BOT IS BUGGY**

Plugins
-------
ircBot v2 comes with a 'defaultCommands' plugin, along with a googl (url shortener) and lmgtfy plugin. These add basic bot function, such as -bye (shut down) and changing channels.

Take a look at the googl or lmgtfy plugins to get the basics. An example plugin is also included.

To enable your plugin, you need to modify config.php and add your plugin name to the array (without the .php).

defaultCommands
---------------
The bot has the following default commands.
* *reload* - Reloads the bots plugins (currently doesn't do anything)
* *bye* - Shuts down bot
* *plugins* - Lists currently loaded plugins
* *Botname: #channel* - Instructs the bot to change channels
* *cp <prefix>* - Instructs the bot to change prefix

**Please note** that all of these commands require the prefix defined in either config.php, or using cp <prefix>

**Please also note** that all of these commands work in PM, so if you lose the bot (it joins a non-existant channel), you can instruct it to move to a known channel.


lmgtfy
------
*Let me google that for you (lmgtfy)* is a popular web service, 'For all those people who find it more convenient to bother you with their question rather than google it for themselves.'. Basically, the web service google a term for you, but in an entertaining way, by 'taking control' of your computer, and typing it into google for you. (please note, it doesn't take control of your computer :D).

**Command Reference**
* *lmgtfy <search string>* - Links to the LMGTFY service with 'search string'.


googl
-----
*Google's web shortening service*
This plugin just shortens web URLs to around 10 characters. This can be useful in situations where you don't want to fill the chat with a large url, causing spam for some users.

**Command Reference**
* *shorten <url>* - Shortens a URL using goo.gl's shortening service.
