<?php

include("connect.php");

mysql_query("DELETE FROM sharing WHERE `file_id`='".$_POST['fid']."'");

?>
