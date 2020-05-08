apt-get update -y && sudo apt-get upgrade -y; 
apt-get install curl -y;
apt-get install git -y; 
apt install software-properties-common -y;
add-apt-repository ppa:ondrej/ph -y; 
apt install php7.4 php7.4-gd php7.4-mbstring php7.4-xml -y;
apt install php-sqlite3 -y;
apt install apache2 libapache2-mod-php7.4 -y;
apt install mysql-server php7.4-mysql -y;
curl -sS https://getcomposer.org/installer | php;
mv composer.phar /usr/local/bin/composer;
chmod +x /usr/local/bin/composer;


if [ -d "/var/www/PlantPro" ];
	then rm -rf /var/www/PlantPro;
fi

git clone https://github.com/rudiejd/PlantPro.git /var/www/PlantPro;
chmod 777 -R /var/www/PlantPro

mysql -u root -e "CREATE DATABASE PlantPro;"
mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';";

rm /etc/apache2/sites-enabled/000-default.conf
echo "<VirtualHost *:80>

        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/PlantPro/public

        <Directory />
                Options FollowSymLinks
                AllowOverride All
        </Directory>
        <Directory /var/www/PlantPro>
                AllowOverride All
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>" >> /etc/apache2/sites-enabled/000-default.conf;
sudo a2enmod rewrite
systemctl restart apache2

cd /var/www/PlantPro;
php artisan migrate;
php artisan test;

echo 'PlantPro up to date! Enjoy!';


