#!/bin/bash

DATABASE_NAME=pages


echo "Provisioning virtual machine..."

# Update the box release repositories
# -----------------------------------
echo "Updating repositories ... "
apt-get update

echo "Installing GIT ..."
apt-get install git-core -y

echo "Installing Apache ..."
apt-get install apache2 -y

# Add ServerName to httpd.conf for localhost
echo "ServerName localhost" > /etc/apache2/httpd.conf

echo -e "\n--- Enabling mod-rewrite ---\n"
a2enmod rewrite

echo "Installing PHP ..."
apt-get install libapache2-mod-php5 -y

echo "Installing PHP extensions ..."
apt-get install curl php5-cli php5-curl php5-gd php5-mcrypt php5-mysql php-pear php5-xdebug php5-intl -y

php5enmod mcrypt

# Setting the timezone
sed 's#;date.timezone\([[:space:]]*\)=\([[:space:]]*\)*#date.timezone\1=\2\"'"$PHP_TIMEZONE"'\"#g' /etc/php5/apache2/php.ini > /etc/php5/apache2/php.ini.tmp
mv /etc/php5/apache2/php.ini.tmp /etc/php5/apache2/php.ini
sed 's#;date.timezone\([[:space:]]*\)=\([[:space:]]*\)*#date.timezone\1=\2\"'"$PHP_TIMEZONE"'\"#g' /etc/php5/cli/php.ini > /etc/php5/cli/php.ini.tmp
mv /etc/php5/cli/php.ini.tmp /etc/php5/cli/php.ini
# Showing error messages
sed 's#display_errors = Off#display_errors = On#g' /etc/php5/apache2/php.ini > /etc/php5/apache2/php.ini.tmp
mv /etc/php5/apache2/php.ini.tmp /etc/php5/apache2/php.ini
sed 's#display_startup_errors = Off#display_startup_errors = On#g' /etc/php5/apache2/php.ini > /etc/php5/apache2/php.ini.tmp
mv /etc/php5/apache2/php.ini.tmp /etc/php5/apache2/php.ini
sed 's#error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT#error_reporting = E_ALL#g' /etc/php5/apache2/php.ini > /etc/php5/apache2/php.ini.tmp
mv /etc/php5/apache2/php.ini.tmp /etc/php5/apache2/php.ini

# Configure the virtual host for apache
echo -e "\n--- Add apache virtual host. ---\n" 
cat > /etc/apache2/sites-enabled/000-default.conf <<EOF
<VirtualHost *:80>
  DocumentRoot /var/www/public
  
  <Directory /var/www/public>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
  </Directory>
        
  ErrorLog ${APACHE_LOG_DIR}/error.log
  CustomLog ${APACHE_LOG_DIR}/access.log combined
  
</VirtualHost>
EOF

# Finally, restart apache
service apache2 restart

# Set MySQL root password
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password root'

apt-get -y install mysql-server

# Setup database
echo "DROP DATABASE IF EXISTS ${DATABASE_NAME}" | mysql -uroot -proot
echo "CREATE USER '${DATABASE_NAME}'@'%' IDENTIFIED BY '${DATABASE_NAME}'" | mysql -uroot -proot
echo "CREATE DATABASE ${DATABASE_NAME}" | mysql -uroot -proot
echo "GRANT ALL ON ${DATABASE_NAME}.* TO '${DATABASE_NAME}'@'%'" | mysql -uroot -proot
echo "FLUSH PRIVILEGES" | mysql -uroot -proot
