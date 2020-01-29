# Requirements
### Apache server
> sudo apt-get install apache2

Test that php is working
> sudo nano /var/www/html/info.php

add this
> <?php phpinfo(); ?>

then restart the server
> sudo systemctl restart apache2

Go to localhost and you should see the landing page

### Install mysql database
> sudo apt-get install mysql-server

### Install php
> sudo apt-get install php libapache2-mod-php

### Starting Apache and MySQL on boot
> sudo systemctl enable apache2.service
<br/>
> sudo systemctl enable mysql.service

#### Import database
Create a blank version of the database
> CREATE DATABASE cuhvmiwg_hvz;

Import sql file of database
> mysql -u root -p cuhvmiwg_hvz < cuhvmiwg_hvz.sql

Add cuhvmiwg user to database
> GRANT ALL PRIVILEGES ON *.* TO 'cuhvmiwg'@'localhost' IDENTIFIED BY 'Yummybrainz!2';

### How to make PDO use mysql driver
Add repository
> sudo apt-add-repository ppa:ondrej/php

Update
> sudo apt-get update

Install required modules
> sudo apt-get install php7.0-mysql

## Useful commands

connect to local mysql database using this command
> sudo mysql -u root -p cuhvmiwg_hvz

To run sql scripts in mysql use
> source <file.sql>;

Run local php server using this command
> php -S localhost:8000

To run php scripts on the command line use
> php -f <file.php>

Connect to cPanel terminal
> ssh cuhvmiwg@server122.web-hosting.com -p21098

sql query to get weeklong emails
>select users.email from users inner join weeklongXXX on weeklongXXX.user_id=users.id

add cpanel to git
> git remote add www ssh://cuhvmiwg@server122.web-hosting.com:21098/home/cuhvmiwg/www.git/
