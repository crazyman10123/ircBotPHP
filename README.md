ircBot v3 - Nearly done!
========================
ircBot v3 is a more complex IRC bot made for command line usage. It is coded in PHP, and currently has a large plugin framework, but doesn't support joining multiple channels at once.

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
ircBot v3 comes with a whole new plugin API, making it more flexible and allowing you to do much more than in v2. Plugin loading and calling has been made faster and more efficient, through the use of command variables, instructing the bot on which plugins run which commands.

Take a look at the source of any of the plugins included, and you should be on your way coding plugins in no time (as long as you know some PHP).

**Please note:** The plugin file name must be the same as it's class name, but neither of these can be the same as any commands inside.

**Please note*(2)*:** To enable a plugin, add it's filename in config.php to $plugins.

***

This will soon be updated with the command syntax for all included plugins
--------------------------------------------------------------------------
Mainained by **crazyman10123** and **jackwilsdon**

