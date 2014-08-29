@echo off
:Start
php Main.php
GOTO Restart
:NewChan
set /p Chan=<channel.txt
start Start.bat
php Main.php Channel=%Chan%
GOTO Restart
:Restart
if "%errorlevel%"=="2" cls & GOTO NewChan
if "%errorlevel%"=="1" cls & GOTO Start