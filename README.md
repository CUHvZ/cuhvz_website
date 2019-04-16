connect to local mysql database using this command
$ mysql -u root -p cuhvmiwg_hvz

To run sql scripts in mysql use
> source <file.sql>;

Run local php server using this command
$ php -S localhost:8000

To run php scripts on the command line use
$ php -f <file.php>

Connect to cPanel terminal
$ ssh cuhvmiwg@server122.web-hosting.com -p21098

sql query to get weeklong emails
select users.email from users inner join weeklongXXX on weeklongXXX.user_id=users.id
