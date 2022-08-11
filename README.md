# d2view

A DotA2 local data viewer and quizz generator.

## dependencies

	#pacman -S php

`src/VPKReader` is from https://github.com/Aphexx/php-vpk-reader but no
license found. It is included in src source tree and not as a git submodule
to make further debugging/modification easier.

## Running

	cd src
	php test.php > out.html

Then, open the `out.html` with your favorite browser. This file may be huge
(>30Mo).

## Install on apache

	sudo pacman -S apache php-apache
	sudo systemctl start httpd.service

Then follow https://wiki.archlinux.org/title/Apache_HTTP_Server
