Note!!!
* npm install
* composer install


FOR LINUX USERS (for mpdf to function else HTTP ERROR 500)
* Requires >= php7.8 for mpdf/mpdf to work
* sudo chmod -R 775 ihris/vendor
* sudo chown -R $USER:www-data ihris/vendor
* /etc/mysql/my.conf  --> under [mysqld] insert <sql_mode= >,then sudo systemctl restart mysql (to disable mysql strict mode)
* Example:
[mysqld]
sql_mode=
lower_case_table_names=1


# Fix for certbot ERR_CERT_COMMON_NAME_INVALID:
# hr-lgubayawan.online-le-ssl.conf
<IfModule mod_ssl.c>
<VirtualHost *:443>
    ServerName hr-lgubayawan.online
#    ServerAlias www.hr-lgubayawan.online
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/hr-lgubayawan.online
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

RewriteEngine on
# Some rewrite rules in this file were disabled on your HTTPS site,
# because they have the potential to create redirection loops.

# RewriteCond %{SERVER_NAME} =hr-lgubayawan.online [OR]
# RewriteCond %{SERVER_NAME} =www.hr-lgubayawan.online
# RewriteRule ^ https://%{SERVER_NAME}%{REQUEST_URI} [END,NE,R=permanent]

<Directory /var/www/hr-lgubayawan.online/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>


SSLCertificateFile /etc/letsencrypt/live/hr-lgubayawan.online/fullchain.pem
SSLCertificateKeyFile /etc/letsencrypt/live/hr-lgubayawan.online/privkey.pem
Include /etc/letsencrypt/options-ssl-apache.conf
</VirtualHost>
<VirtualHost *:443>
    ServerName www.hr-lgubayawan.online
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/hr-lgubayawan.online
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

RewriteEngine on
# Some rewrite rules in this file were disabled on your HTTPS site,
# because they have the potential to create redirection loops.
