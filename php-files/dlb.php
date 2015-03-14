<?php

include("connect.php");

mysql_query("DELETE FROM messages WHERE msg_id=".$_POST['mid']);


?>
