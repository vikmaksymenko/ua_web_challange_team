#!/usr/bin/env bash

sudo apt-get update

sudo apt-get install -y make

sudo apt-get install -y apache2
sudo apt-get install -y openssl
sudo a2enmod rewrite

APACHEUSR=`grep -c 'APACHE_RUN_USER=www-data' /etc/apache2/envvars`
APACHEGRP=`grep -c 'APACHE_RUN_GROUP=www-data' /etc/apache2/envvars`
if [ APACHEUSR ]; then
sed -i 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=vagrant/' /etc/apache2/envvars
fi
if [ APACHEGRP ]; then
sed -i 's/APACHE_RUN_GROUP=www-data/APACHE_RUN_GROUP=vagrant/' /etc/apache2/envvars
fi
sudo chown -R vagrant:www-data /var/lock/apache2

sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password ROOTPASSWORD'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password ROOTPASSWORD'
sudo apt-get install -y mysql-server
sudo apt-get install -y mysql-client

if [ ! -f /var/log/dbinstalled ];
then
echo "CREATE USER 'mysqluser'@'localhost' IDENTIFIED BY 'USERPASSWORD'" | mysql -uroot -pROOTPASSWORD
echo "CREATE DATABASE internal" | mysql -uroot -pROOTPASSWORD
echo "GRANT ALL ON internal.* TO 'mysqluser'@'localhost'" | mysql -uroot -pROOTPASSWORD
echo "flush privileges" | mysql -uroot -pROOTPASSWORD
touch /var/log/dbinstalled
if [ -f /vagrant/data/initial.sql ];
then
mysql -uroot -pROOTPASSWORD internal < /vagrant/data/initial.sql
fi
fi

sudo apt-get install -y memcached libmemcached-tools

sudo apt-get install -y php5 php-pear php5-dev php5-gd php5-curl php5-mcrypt

yes | sudo pecl install memcache

sudo touch /etc/php5/conf.d/memcache.ini
sudo echo "extension=memcache.so" >> /etc/php5/conf.d/memcache.ini
sudo echo "memcache.hash_strategy=\"consistent\"" >> /etc/php5/conf.d/memcache.ini

# if /var/www is not a symlink then create the symlink and set up apache
if [ ! -h /var/www ];
then
rm -rf /var/www
ln -fs /vagrant /var/www
sudo a2enmod rewrite
sed -i '/AllowOverride None/c AllowOverride All' /etc/apache2/sites-available/default
sudo service apache2 restart
fi

# restart apache
sudo service apache2 reload

# copy addwebsite command
cp /vagrant/addwebsite /usr/local/bin/addwebsite
chmod +x /usr/local/bin/addwebsite
cp /vagrant/skeleton /etc/apache2/sites-available/skeleton

sudo apt-get install -y git

# set up mywebsite.localhost
if [ ! -d /vagrant/mywebsite.localhost ];
then
git clone ssh://git@domain.com/repo/mywebsite.com /vagrant/mywebsite.localhost
cp /vagrant/skeleton /etc/apache2/sites-available/mywebsite.localhost
find /etc/apache2/sites-available/mywebsite.localhost -type f -exec sed -i "s/SKELETON/mywebsite.localhost/" {} \;
fi
if [ ! -d /var/lib/mysql/mywebsite ];
then
echo "CREATE USER 'mysqluser'@'localhost' IDENTIFIED BY 'USERPASSWORD'" | mysql -uroot -pROOTPASSWORD
echo "CREATE DATABASE mywebsite" | mysql -uroot -pROOTPASSWORD
echo "GRANT ALL ON mywebsite.* TO 'mysqluser'@'localhost'" | mysql -uroot -pROOTPASSWORD
echo "flush privileges" | mysql -uroot -pROOTPASSWORD
if [ -f /vagrant/mywebsite.sql ];
then
mysql -uroot -pROOTPASSWORD mywebsite < /vagrant/mywebsite.sql
fi
fi