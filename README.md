Note!!!
* npm install
* composer install


FOR LINUX USERS (for mpdf to function else HTTP ERROR 500)
* Requires >= php7.8 for mpdf/mpdf to work
* sudo chmod -R 775 ihris/vendor
* sudo chown -R $USER:www-data ihris/vendor
* /etc/mysql/my.conf  --> under [mysqld] insert <sql_mode= >,then sudo systemctl restart mysql (to disable mysql strict mode)
