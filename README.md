# d2view

A DotA2 local data viewer and quizz generator.

## Dependencies

`src/VPKReader` is from https://github.com/Aphexx/php-vpk-reader but no
license found. It is included in src source tree and not as a git submodule
to make further debugging/modification easier.

## Configuration

In the top-level directory, you must create and feed a configuration file 
containing home directory of the user that installed and keep updated DotA2. 
This file **must** be called `config.php` and should
looks like that :

	<?php
	global $home, $extractdir;

	$home="/home/<your_username_here>/";
	$extractdir="$home/d2view-extract";
	?>

The `$extractdir` directory must be writable by your HTTP server (a+w).
Use `ls -lhd` to know actual flags and `chmod a+w` to add writting permissions
to everybody.

Also remember that, to be writable, all parents to this directory must also be
writable.

## Installation example on apache

The following example is what I use on a *manjaro* box. For more details see
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

## Admin section

The *admin/* subdir contains page that can display sensitive informations.
We can suggest you use a *htaccess* file to protect it is your site is
accessible : 
https://httpd.apache.org/docs/2.4/en/howto/htaccess.html

## Steam file permission issues

First time you run this script, it may conplain about file permissions. At least
on linux, steam in installed as a symbolic link to `~/.local/share/Steam`, it
seems top be the source of this issue. A simple :

	chmod a+r ~/.local/share/Steam
	chmod a+x ~/.local/share/Steam

It should fix the issue and do not prevent steam from working.

## Unit tests

Unit tests are powered by phpunit wich is, unfortunately, only available on
AUR. To install this package :

	git clone https://aur.archlinux.org/phpunit.git
	cd phpunit
	less PKGBUILD
	gpg --keyserver https://sebastian-bergmann.de/gpg.asc \
		--recv-keys 4AA394086372C20A
	makepkg
	sudo pamac install phpunit-*-any.pkg.tar.zst

Then, you can run :

	make check

