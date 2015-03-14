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


$con =  mysql_connect("localhost","root","");


mysql_select_db('storage',$con);


$check = mysql_query("SELECT * FROM users WHERE `uname` =  '".$_POST['uname']."'");


$checkuname = mysql_fetch_array($check);
	

if($checkuname['uname']){
?>

<script type="text/javascript">
alert("Sorry This Username already exist");
window.location = "index.php";
</script>
<?php	
	
}	

else{
mysql_query("INSERT INTO users(`uname`,`upass`,`name`,`email`) VALUES(

'".$_POST['uname']."','".$_POST['upass']."','".$_POST['name']."','".$_POST['email']."'
)
");	
	
	
?>	

<script type="text/javascript">
alert("Thank You for registering");
window.location = "index.php";


</script>


<?php	
	}
?>
