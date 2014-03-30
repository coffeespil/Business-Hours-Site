<?php
include 'includes/config.inc.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);


$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

$salt = "whwhw72heksksk";
$pass = "bizhours";
$account_name = "gmail";
$adminEmail = "whatsopened@gmail.com";

//a table to store user info for business hours website project
$go = mysql_query("CREATE TABLE IF NOT EXISTS ".USERS." (
id bigint(20) NOT NULL AUTO_INCREMENT,
md5_id varchar(220) NULL,
email longblob NOT NULL,
pwd varchar(220) NOT NULL DEFAULT '',
full_name varchar(200) NOT NULL,
city varchar(200) NOT NULL,
state char(2) NOT NULL,
postal_code varchar(10) NOT NULL,
activation_code varchar(250) NOT NULL,
session_start timestamp NULL,
session_key varchar(250) NULL,
isactivated char(1) NULL,
create_date timestamp NULL,
PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$go_again = mysql_query("CREATE TABLE IF NOT EXISTS ".PSTORE." (
id bigint(20) NOT NULL AUTO_INCREMENT,
acct_nam varchar(50) NOT NULL,
acct_val longblob,
acct_pwd longblob, 
PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$and_again = mysql_query("CREATE TABLE IF NOT EXISTS ".REFERENCES." (
ref_id longtext NOT NULL,
busn_name varchar(220) NOT NULL,
busn_address varchar(220) NOT NULL,
phone varchar(20) NULL,
busn_hours longblob NULL,
PRIMARY KEY (ref_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");



//a table to store most frequented locations, includes Google Places API ref id as well API business type and name
$go_again = mysql_query("CREATE TABLE IF NOT EXISTS ".FAVES." (
fave_id bigint(20) NOT NULL AUTO_INCREMENT,
user_id bigint(20) NOT NULL,
reference_id longtext NOT NULL,
PRIMARY KEY (fave_id),
FOREIGN KEY (user_id) REFERENCES bhours_users_mmorgan(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");



if($go && $go_again && $and_again)
{
	echo "Installed tables successfully";
}
else
{
	echo "Unable to install tables";
}



$insertEmail = mysql_query("INSERT INTO ".PSTORE." (acct_nam, acct_val, acct_pwd) VALUES ('$account_name',AES_ENCRYPT('$adminEmail', '$salt'),AES_ENCRYPT('$pass', '$salt'))", $link) or die("Unable to insert data");


?>