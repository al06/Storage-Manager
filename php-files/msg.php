<?php

include("connect.php");
session_start('user');
$mydate=getdate(date("U"));
$final = "$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]";
mysql_query("
INSERT INTO messages(`msg`,`sender_id`,`reciever_id`,`date_added`) VALUES(
'".$_POST['umsg']."','".$_SESSION['userid']."','".$_POST['userselect']."','".$final."'


)


")


?>

<input type="hidden" name="uid" value="<?php echo $_SESSION['$final']; ?>"/>
