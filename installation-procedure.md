#my environment is ubuntu-15.04
#1.first launch terminal shortcut(ctrl+alt+t)
#2.now connect to server using ssh by this command
	ssh root@<domain-name> 
#(replace <domain-name> with actual domain eg. www.magzhub.com)
#(it will prompt for password)

#3.update remote system by this command
	apt-get update

#4.install apache2 using this command
	apt-get install apache2

#5.test apache by opening browser and checking the domain url
#(if an apache page is shown then apache is installed successfully)

#6.now install mysql-server using this command
	apt-get install mysql-server
#7.now install php5 and its component on server using this command
	apt-get install php5  php5-mysqlnd
#8.restart apache using this command 
	/etc/init.d/apache2 restart
#9.now its time to test php if installed and configured properly 
	
#	a)go to the default public directory (default is /var/www/html) use command
		cd /var/www/html
#	b)make a file named info.php using following command
		nano info.php
#	c)type these lines 
		<?php
			echo phpinfo();
		?>
#	d)save and exit (ctrl+x)
#10) open browser and test the php by typing this url <domain-name>/info.php
#11)note down the configuration path of apache and php
#12)check whether the support of mysqli is there by searching mysqli on the info page.


	

#path to apache conf file (000-default.conf)
	/etc/apache2/sites-available 
#path to php.ini
	/etc/php5/apache2/php.ini

#restarting server
	a).restarting apache
		/etc/init.d/apache2 restart
	b).restarting mysql
		/etc/init.d/mysql restart

#changing the public directory
	a)paste your directory in public folder i.e /var/www/html/

	b)go to apache configuration file
	c)append the name of your folder at line having 'DocumentRoot'
	eg. DocumentRoot /var/www/html/magzhub (if folder name is magzhub).
	d)restart server

#to stop autoindexing of files run the following command 
	a2dismod autoindex