<?php


include("connect.php");


copy("userdata/".$_POST['sname']."_".$_POST['sid']."/".$_POST['fname'],"userdata/".$_POST['rname']."_".$_POST['rid']."/".$_POST['fname']);

mysql_query("DELETE FROM sharing WHERE `file_id`='".$_POST['fid']."'");




?>
