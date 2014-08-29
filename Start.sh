#!/bin/bash 
set -v off
while [ "$?"  -ne "0" ]
do
	if [ "$?" -ne "2" ]
		php Main.php
	fi
	if [ "$?" -eq "2" ]
		channel=`channel.txt`
		gnome-terminal -x ./Start.sh
		php Main.php Channel=$channel
	fi
done