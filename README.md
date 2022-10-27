# d2view

A DotA2 local data viewer and quizz generator.

## dependencies

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

## Install on apache

The following example is what I use on a manjaro box. For more details see
https://wiki.archlinux.org/title/Apache_HTTP_Server

1.Dependencies installation :

	sudo pacman -S apache php-apache php-fpm

2.If you want to modify system-wide index file :

	sudo emacs /srv/http/index.html

3.Then, edit the */etc/hosts* file to add this line:

	127.0.0.1  d2view.localhost

4.Enable *virtual hosts* and *php* apache features. Open 
*/etc/httpd/conf/httpd.conf* file and uncomment or add this statements :

	Include conf/extra/httpd-vhosts.conf
	Include conf/extra/php_module.conf
	...
	LoadModule php_module modules/libphp.so
	AddHandler php-script .php

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

You may also need to uncomment *mpm_prefork_module* LoadModule statement
and comment other mpm configuration like *mpm_event_module*.

Now, you can start (or restart apache) : `sudo systemctl start httpd.service`.

If you keep the directory in your home one, you may have a 
*access to / denied ... because search permissions are missing on a component*
*of the path*. You may need to call

	chmod +x ~

and restart `apache` to fix this issue. It is used to let the webserver user
traverse (i.e. read content) of your directory.

## Steam file permission issues

First time you run this script, it may conplain about file permissions. At least
on linux, steam in installed as a symbolic link to `~/.local/share/Steam`, it
seems top be the source of this issue. A simple :

	chmod a+r ~/.local/share/Steam
	chmod a+x ~/.local/share/Steam

It should fix the issue and do not prevent steam from working.
