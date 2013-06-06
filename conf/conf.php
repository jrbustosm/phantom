<?php

######################
#basic configuration#
######################

$_TITLE = "phantom";
$_EMAIL = "foo@server";

#############################
#Database settings#
#############################

$_DBENGINE = "SQLite";
$_DBNAME = "data/MyDB.bd";

#In case it is MySQL uncomment
#$_DBENGINE = "MySQL";
#$_DBNAME ="";
#$_DBSERVER ="";
#$_DBPORT ="";
#$_DBUSER ="";
#$_DBPASSWORD ="";

###############################################
#Configuration control urls#
###############################################

$_URLBASE = "/phantom-master/";
$_URLIMGS = $_URLBASE . "img/";
$_URLEXCLUDE = array("img","js","css");
$_CONTROL_INI = "Image";

