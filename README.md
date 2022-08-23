# d2view

A DotA2 local data viewer and quizz generator.

## dependencies

	#pacman -S php

`src/VPKReader` is from https://github.com/Aphexx/php-vpk-reader but no
license found. It is included in src source tree and not as a git submodule
to make further debugging/modification easier.

## config.php

In the top-level directory, you must create and feed a config file containing
home directory of the user that installed and keep updated DotA2. It should
looks like that :

	<?php
	$home="/home/<your_username_here>/";
	?>

## Running

	cd src
	php test.php > out.html

Then, open the `out.html` with your favorite browser. This file may be huge
(>30Mo).

## Install on apache

The following example is what I use on a manjaro box. For more details see
https://wiki.archlinux.org/title/Apache_HTTP_Server

1.Dependencies installation :

	sudo pacman -S apache php-apache php-fpm

2.If you want to modify system-wide index file :

	sudo emacs /srv/http/index.html

3.Then, edit the */etc/hosts* file to add this line:

	127.0.0.1  d2view.localhost

4.Enable virtual hosts. Open */etc/httpd/conf/httpd.conf* file and uncomment :

	Include conf/extra/httpd-vhosts.conf

5.Open The vhost configuration file `/etc/httpd/conf/extra/httpd-vhosts.conf`,
	and add this content. Be sure to change both directory path if needed :

	<VirtualHost *:80>
		ServerAdmin webmaster@domainname1.dom
		DocumentRoot "/var/www/d2view/src"
		ServerName d2view.locahost
		ServerAlias d2view.locahost
		ErrorLog "/var/log/httpd/d2view.dom-error_log"
		CustomLog "/var/log/httpd/d2view.dom-access_log" common

	    <Directory "/var/www/d2view/src">
			Require all granted
			DirectoryIndex index.php
		</Directory>
	</VirtualHost>

Now, you can start (or restart apache) : `sudo systemctl start httpd.service`.


