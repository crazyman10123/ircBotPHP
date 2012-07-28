ircBot v3.5 - We're getting there!
==================================
ircBot v3.5 is a more complex IRC bot made for command line usage. It is coded in PHP, and currently has a large plugin framework, but doesn't support joining multiple channels at once.


Usage
-----
ircBot v3 requires a CLI PHP installation. It is recommended to run this bot on a linux based OS, due to the ease of installation / use of the PHP CLI. I am not planning on putting any tutorials up on how to install CLI PHP. If you don't know how to do it, this bot isn't for you.

**Starting the bot**

*Ensure you are in the same directory as the bot*

> php Main.php

This should display messages about either setting up the bot, or loading plugins; depending on whether you have configured your bot or not.

If you experience any errors whilst starting or using the bot, please report them using the **issue tracker** above.


Plugins
=======
ircBot v3 comes with a whole new plugin API, making it more flexible and allowing you to do much more than in v2. Plugin loading and calling has been made faster and more efficient, through the use of command variables, instructing the bot on which plugins contain which commands. The **onSpeak()** method has been kept, to allow for extra compatibility with plugins such as **filter**. This is called whenever a user speaks, allowing the plugin to see everything a person says. Usually, the bot looks for it's prefix before calling any functions, as this makes it faster and more efficient than just calling every plugin (like in v2).

Commands work in PM, so any commands with passwords in should be run via PM. e.g. *`/msg (botname) (prefix)auth <password>`*.

Take a look at the source of any of the plugins included, and you should be on your way coding plugins in no time (as long as you know some PHP).

**Please note:** The plugin file name must be the same as it's class name, but neither of these can be the same as any commands inside.

**Please note*(2)*:** To enable a plugin, add it's filename in config.php to $plugins.


authService
-----------
This plugin ensure you are who you say you are.
To run any admin commands on the bot, you need to first authorise yourself using the command `(prefix)auth`.
If authorisation was successful, it will return "You have been authorised."

This plugin requires configuring in **Configuration.php**. You need to enter your full hostmask including the colon at the beginning. The variable to alter is called `$authMask`.

**Commands**

> `(prefix)auth` - Authorises the current user using their hostmask

> `(prefix)deauth` - Deauthorises the current user


defaultCommands
---------------
This plugin contains all of the default commands for the bot to be useful.

**Commands**

> `(prefix)about` - Prints bot version and a link to github

> `(prefix)action <action>` **[admin]** - The same as doing /me <action>, except it causes the bot to do the action 

> `(prefix)cycle` **[admin]** - Disconnects and reconnects to the channel. Good housekeeping

> `(prefix)help` - Lists all commands from the enabled plugins

> `(prefix)poweroff` **[admin]** - Causes bot to shut down and exit with a return code of 0

> `(prefix)prefix <new prefix>` **[admin]** - Changes the command prefix to the parameter passed

> `(prefix)say <text>` **[admin]** - Causes the bot to say the parameter passed

> `(prefix)uptime` - Returns the bot's uptime in hours, minutes and seconds

> `(prefix)version` - Does the same as `(prefix)about`

> `(prefix)reload` - Reloads all loaded plugins (if runkit is enabled)


filter
------
This is a bad words filter. On startup, you should get a message saying 'missing badwords.txt'. This means that you need to create badwords.txt in the main directory, and put words (that should trigger the user being kicked) inside it. badwords.txt is a newline-seperated list, meaning one word per line.

This plugin has no commands. It simply kicks the user when they say any of the words contained in badwords.txt.


guessGame
---------
This plugin is a simple number guessing game, where you have to guess a random number between one and ten.

**Commands**

> `(prefix)guess <number>` - Sends the bot your guess, it will reply with **Nope, try again** or **You win**


isupService
-----------
The isupService plugin allows you to check whether a domain is online or not.

**Commands**

> `(prefix)isup <url>` - Returns whether the provided domain is online or offline


lmgtfyService
-------------
**Warning:** This can look snarky if you use it a lot, try and refrain from using it unless someone ask a stupid question.

The lmgtfyService (let me google that for you) is "For all those people who find it more convenient to bother you with their question rather than google it for themselves.". This plugin provides a search term on LMTFY and returns the URL.

**Commands**

> `(prefix)lmgtfy <search terms>` - Returns a lmgtfy url with the search terms entered


pastebinService
---------------
This simple plugin just returns the pastebin URL along with a message about not posting code in the channel.

**Commands**

> `(prefix)pastebin` - Returns the pastebin URL along with a message about not posting code in the channel


quotes
------
This plugin just returns a random, geeky quote whenever you run it. It requires a quotes.txt in the main directory, and this file should contain newline-seperated quotes, meaning one quote per line.

**Commands**

> `(prefix)quote` - Returns a random quote from quotes.txt


shortenService
--------------
This service shortens URLs to something like `tinyurl.com/<randomstring>`.

**Commands**

> `(prefix)shorten <url>` - Returns a shortened URL directing to the parameter passed.


xkcdComics
----------
**Warning:** Remove this plugin from Configuration.php if you are going to use this bot properly. It causes lag due to the cURL function inside it.

This plugin simply returns a random xkcd comic URL. xkcd comics are usually geeky, so this plugin may be suitable for your channel, as a bit of fun.

**Commands**

> `(prefix)xkcd` - Returns a random xkcd comic URL

***

Mainained by **crazyman10123** and **jackwilsdon**