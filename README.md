ircBot v2.0
=========
IRCBot is a basic bot I coded in PHP made for CLI use. It supports plugins, but can only join one channel at a time.

**WARNING: THIS IS THE UNSTABLE BRANCH. THIS CODE MAY NOT FUNCTION HOW IT'S MEANT TO**

When running commands, you will need to use the prefix defined in **config.php** or using the command **-cp**.

Usage
-----
This bot requires a CLI installation of PHP. It is reccomended to run this bot on a *nix based OS, as this allows you to run PHP in the command line easily. I will not put a tutorial up on how to use this bot in Windows. You will just have to google "Windows CLI PHP" and hope for the best :)

**Starting the bot**

*Ensure your current directory is that of the bot (has config.php, main.php etc)*

> php main.php

This should start the bot.

If you experience any errors, please don't hesistate to use the **issues** page located here: https://github.com/jackwilsdon/ircBot/issues

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
* *cc <channel>* - Instructs the bot to change channels
* *cp <prefix>* - Instructs the bot to change prefix
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

isup
----
*Checks whether a url is online*
There isn't much to say about this plugin, you just run the command and pass it a domain, and it will tell you if the site is online or not.

**Command Reference**
* *isup <url>* - Returns whether a URL is online or offline.

uptime
------
*Shows the bot's current uptime*
* *uptime* - Returns the bot's current uptime in hours, minutes and seconds.

Changelog
---------
*I probably won't update these*
* Removed some unused configuration options
* Added config validation
* Added registration detection, if username is registered, bot exits

Planned
-------
* Registration username and password
* Statistics
* More plugin API documentation
