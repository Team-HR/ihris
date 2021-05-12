# PRE-SETUP
* npm install
* composer install
* 
# FOR LINUX SERVER (for mpdf to function else HTTP ERROR 500)
* Requires >= php7.8 for mpdf/mpdf to work
* sudo chmod -R 775 ihris/vendor
* sudo chown -R $USER:www-data ihris/vendor
* /etc/mysql/my.conf  --> under [mysqld] insert <sql_mode= >,then sudo systemctl restart mysql (to disable mysql strict mode)
* Example:
[mysqld]
sql_mode=
lower_case_table_names=1

# FIX FOR CERTBOT ERR_CERT_COMMON_NAME_INVALID:
https://gist.github.com/FranzValencia/8b863d1bc97be58bf67f646e0080fff8

# SETUP MAILX FOR LINUX
https://drive.google.com/file/d/1ueFT8b4i_YXYurv1uObjhe17kvCKLGrz/view?usp=sharing
