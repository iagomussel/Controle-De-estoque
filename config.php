<?php
$con = 	mysql_connect("localhost", "root", "") or die(mysql_error());
	
	if($con){
		mysql_select_db("estoque") or die(mysql_error());
	}
?>