<?php
session_start('user');

move_uploaded_file($_FILES['file']['tmp_name'],"userdata/".$_SESSION['username']."_".$_SESSION['userid']."/".$_FILES['file']['name']);


unset($_FILES['file']);

?>
