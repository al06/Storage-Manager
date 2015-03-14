<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<img src="images/background.jpg" class="back" />

<body>

<?php


$uname = $_POST['uname'];
$upass = $_POST['upass'];

$con =  mysql_connect("localhost","root","");


mysql_select_db('storage',$con);

$check = mysql_query("SELECT * FROM users WHERE `uname` =  '".$_POST['uname']."' AND `upass` = '".$_POST['upass']."'");

$checkuname = mysql_fetch_array($check);

if($checkuname['uname'] && $checkuname['upass']){
	
session_start('user');
$_SESSION['username'] = $checkuname['uname']; 
$_SESSION['userid'] = 	$checkuname['id'];

?>	

<script type="text/javascript">
var name = "<?php echo $checkuname['name']; ?>";
alert("Welcome "+name);
window.location = "profile.php";
</script>

	
<?php	
}
else{
?>	
<script type="text/javascript">
alert("Sorry Invalid Username or Password");
window.location = "index.php";

</script>	
	
<?php	
	}
?>
