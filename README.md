ircBot v3.6 - We're getting there!
==================================
ircBot v3.6 is a more complex IRC bot made for command line usage. It is coded in PHP, and currently has a large plugin framework, but doesn't support joining multiple channels at once.


Usage
-----
ircBot v3 requires a CLI PHP installation. It is recommended to run this bot on a linux based OS, due to the ease of installation / use of the PHP CLI. I am not planning on putting any tutorials up on how to install CLI PHP. If you don't know how to do it, this bot isn't for you.

**Starting the bot**

Run Start.bat or Start.sh(coming soon)

This should display messages about either setting up the bot, or loading plugins; depending on whether you have configured your bot or not.

If you experience any errors whilst starting or using the bot, please report them using the **issue tracker** above.

As of version 3.6, command line arguments are handled but only one specific argument is. I plan on adding more functionality soon.


Plugins
=======
ircBot v3 comes with a whole new plugin API, making it more flexible and allowing you to do much more than in v2. Plugin loading and calling has been made faster and more efficient, through the use of command variables, instructing the bot on which plugins contain which commands. The **onSpeak()** method has been kept, to allow for extra compatibility with plugins such as **filter**. This is called whenever a user speaks, allowing the plugin to see everything a person says. Usually, the bot looks for it's prefix before calling any functions, as this makes it faster and more efficient than just calling every plugin (like in v2).

Commands work in PM, so any commands with passwords in should be run via PM. e.g. *`/msg (botname) (prefix)auth <password>`*.

Take a look at the source of any of the plugins included, and you should be on your way coding plugins in no time (as long as you know some PHP).

**Please note:** The plugin file name must be the same as it's class name, but neither of these can be the same as any commands inside.

**Please note*(2)*:** To enable a plugin, add its filename in config.php to $plugins.


authService
-----------
This plugin is no longer required (or works!), as hostMasks have taken over. Look in config.php for more details


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

> `(prefix)restart` **[admin]** -Restarts the bot and reloads all config and plugins.

> `(prefix)sc <channel>`  **[admin]** -Restarts the bot, opens up a second instance of the bot in the specified channel.

Mainained by **crazyman10123** and **jackwilsdon**
