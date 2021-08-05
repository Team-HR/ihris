# PRE-INSTALLATION
* LAMP Stack Installation: https://www.linuxbabe.com/ubuntu/install-lamp-stack-ubuntu-20-04-server-desktop
* Install phpMyAdmin: https://www.linuxbabe.com/ubuntu/install-phpmyadmin-apache-lamp-ubuntu-20-04
* Secure with Let's Encrypt: https://www.digitalocean.com/community/tutorials/how-to-secure-apache-with-let-s-encrypt-on-ubuntu-20-04
* `sudo nano /etc/php/7.4/fpm/php.ini`
* Change `upload_max_filesize=2M` to `upload_max_filesize=256M`
* `sudo systemctl restart php7.4-fpm`
* `sudo systemctl restart apache2`
* `npm install`
* `composer install`
* db config file: https://gist.github.com/FranzValencia/36bfe675600bef62512b0ed05d3ee664
# For MPDF to function else HTTP ERROR 500
* Requires >= php7.8 for mpdf/mpdf to work
* `sudo chmod -R 775 ihris/vendor`
* `sudo chown -R $USER:www-data ihris/vendor`
# Disable mysql strict mode default (Prevents saving DB records with null/empty data) and disable table name case sensitivity.
* /etc/mysql/my.conf  --> under [mysqld] insert <sql_mode= >,then `sudo systemctl restart mysql` (to disable mysql strict mode)
* Example:
[mysqld]
sql_mode=
lower_case_table_names=1 #Disable table name case sensitivity
# FIX FOR CERTBOT ERR_CERT_COMMON_NAME_INVALID:
https://gist.github.com/FranzValencia/8d4a224f5b8186be1275766e4b3dc9a0
# SETUP MAILX FOR LINUX
https://drive.google.com/file/d/1ueFT8b4i_YXYurv1uObjhe17kvCKLGrz/view?usp=sharing
# AUTO BACKUP DB SCRIPT
https://gist.github.com/FranzValencia/6940aff30980e101aca816e5f011f2df
* change timezone of server to Asia/Manila
* `sudo crontab -e`
* Add `00 17 * * * bash /home/<USER>/backup-db.sh`
* `sudo service cron restart`
