<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);


define ("DB_HOST", "localhost"); // set database host
define ("DB_USER", "hci573"); // set database user
define ("DB_PASS","hci573"); // set database password
define ("DB_NAME","hci573"); // set database name
define("USERS","bhours_users_mmorgan");//users table as a constant
define("FAVES","bhours_users_favorites_mmorgan");//users table as a constant


$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

//a table to store user info for business hours website project
$go = mysql_query("CREATE TABLE IF NOT EXISTS ".USERS." (
id bigint(20) NOT NULL AUTO_INCREMENT,
email longblob NOT NULL,
pwd varchar(220) NOT NULL DEFAULT '',
full_name varchar(200) NOT NULL,
city varchar(200) NOT NULL,
state char(2) NOT NULL,
postal_code varchar(10) NOT NULL,
activation_code varchar(250) NOT NULL,
last_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

/*
//a table to store most frequented locations, includes Google Places API ref id as well API business type and name
$go_again = mysql_query("CREATE TABLE IF NOT EXISTS ".FAVES." (
fave_id bigint(20) NOT NULL AUTO_INCREMENT,
id bigint(20) NOT NULL,
reference varchar(220),
busn_name varchar(220),
busn_type varchar(220),
PRIMARY KEY (fave_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
*/
if($go)
{
	echo "Installed tables successfully";
}
else
{
	echo "Unable to install tables";
}


/*
//insert rows into user table. for the purposes of this exercise use the same password. in reality, this wouldnt be the case
$insertUser1 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Mike Morgan','New York','NY','10025', '2012-01-03 00:00:00')", $link) or die("Unable to insert data");

$insertUser2 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Jesse James','Milwaulkee','WI','87678', '2012-01-14 00:00:00')", $link) or die("Unable to insert data");

$insertUser3 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Joe Namath','New York','NY','11345','2012-01-23 00:00:00')", $link) or die("Unable to insert data");

$insertUser12 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Joe Namath','New York','NY','11345','2012-02-23 00:00:00')", $link) or die("Unable to insert data");

$insertUser4 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','John Belushi','Buffalo','NY','99809','2012-02-12 00:00:00')", $link) or die("Unable to insert data");

$insertUser4 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','John Belushi','Buffalo','NY','99809','2012-02-12 00:00:00')", $link) or die("Unable to insert data");

$insertUser24 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','April Kepner','Woodmere','NY','73785','2012-03-01 00:00:00')", $link) or die("Unable to insert data");

$insertUser14 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','April Kepner','Seattle','WA','73785','2012-01-01 00:00:00')", $link) or die("Unable to insert data");

$insertUser15 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','April Kepner','Seattle','WA','73785','2012-03-01 00:00:00')", $link) or die("Unable to insert data");

$insertUser16 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','April Kepner','Seattle','WA','73785','2012-03-01 00:00:00')", $link) or die("Unable to insert data");

$insertUser17 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','April Kepner','Seattle','WA','73785','2012-03-01 00:00:00')", $link) or die("Unable to insert data");

$insertUser5 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','April Kepner','Seattle','WA','73785','2012-02-01 00:00:00')", $link) or die("Unable to insert data");

$insertUser6 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Bill Gates','Redmond','WA','98925','2012-03-14 00:00:00')", $link) or die("Unable to insert data");

$insertUser7 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Brett Favre','Madison','WI','99890','2012-03-01 00:00:00')", $link) or die("Unable to insert data");

$insertUser18 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Bill Gates','Redmond','WA','98925','2012-03-14 00:00:00')", $link) or die("Unable to insert data");

$insertUser19 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Bill Gates','Redmond','WA','98925','2012-03-14 00:00:00')", $link) or die("Unable to insert data");

$insertUser20 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Jimmy Kimmel','Los Angeles','CA','37263','2012-01-23 00:00:00')", $link) or die("Unable to insert data");

$insertUser21 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Jimmy Kimmel','Los Angeles','CA','37263','2012-01-23 00:00:00')", $link) or die("Unable to insert data");

$insertUser22 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Jimmy Kimmel','Los Angeles','CA','37263','2012-03-23 00:00:00')", $link) or die("Unable to insert data");

$insertUser23 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Arnold S.','Sacramento','CA','46483','2012-03-26 00:00:00')", $link) or die("Unable to insert data");

$insertUser8 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Jimmy Kimmel','Los Angeles','CA','37263','2012-03-23 00:00:00')", $link) or die("Unable to insert data");

$insertUser25 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Arnold S.','Sacramento','CA','46483','2012-02-26 00:00:00')", $link) or die("Unable to insert data");

$insertUser26 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Arnold S.','Sacramento','CA','46483','2012-02-26 00:00:00')", $link) or die("Unable to insert data");

$insertUser27 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Arnold S.','Sacramento','CA','46483','2012-02-26 00:00:00')", $link) or die("Unable to insert data");

$insertUser28 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Arnold S.','Sacramento','CA','46483','2012-02-26 00:00:00')", $link) or die("Unable to insert data");

$insertUser9 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Arnold S.','Sacramento','CA','46483','2012-03-26 00:00:00')", $link) or die("Unable to insert data");

$insertUser10 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Jack Trice','Ames','IA','58589','2012-03-30 00:00:00')", $link) or die("Unable to insert data");

$insertUser11 = mysql_query("INSERT INTO ".USERS." (email, pwd, full_name, city, state, postal_code, last_login) VALUES (AES_ENCRYPT('michael.a.morgan@gmail.com', '$salt'),'$password','Stephen King','Bangor','ME','47459','2012-03-12 00:00:00')", $link) or die("Unable to insert data");


//insert rows into favorites table
$insertFave1 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (1,'wdwdwdwdwd','TD Bank','bank')", $link) or die("Unable to insert data");

$insertFave2 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (1,'wdwdwdwdwd','Citibank','bank')", $link) or die("Unable to insert data");

$insertFave3 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (1,'wdwdwdwdwd','HSBC','bank')", $link) or die("Unable to insert data");

$insertFave4 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (1,'wdwdwdwdwd','Sovereign Bank','bank')", $link) or die("Unable to insert data");


$insertFave5 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (3,'wdwdwdwdwd','Big Daddy\'s','restaurant')", $link) or die("Unable to insert data");

$insertFave6 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (2,'wdwdwdwdwd','Jean Georges','restaurant')", $link) or die("Unable to insert data");

$insertFave7 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (4,'wdwdwdwdwd','Starbucks','cafe')", $link) or die("Unable to insert data");

$insertFave8 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (8,'wdwdwdwdwd','Maison Kayser','bakery')", $link) or die("Unable to insert data");

$insertFave9 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (4,'wdwdwdwdwd','Paris Bakery','bakery')", $link) or die("Unable to insert data");

$insertFave10 = mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (4,'wdwdwdwdwd','Museum of Modern Art','museum')", $link) or die("Unable to insert data");

$insertFave11= mysql_query("INSERT INTO ".FAVES." (id, reference, busn_name, busn_type) VALUES (6,'wdwdwdwdwd','Guggenheim','museum')", $link) or die("Unable to insert data");
*/






?>