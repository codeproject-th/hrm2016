<?
@mysql_connect(DB_HOST,DB_USERNAME,DB_PASSWORD);
mysql_select_db(DB_NAME) or die("DB ERROR");
mysql_query("SET NAMES UTF8");

?>