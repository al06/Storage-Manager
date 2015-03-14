<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="jquery-1.9.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  
$(".delete").click(function() {
var data = $(this).parent("span").parent("form").serialize();
$.post('delete.php',data,function(){
	
});
$(this).parent("span").parent("form").fadeOut(); 
    
}); 
 
$(".sendmsg").click(function() {
var msg = $(".msgtext").val();
if(msg==""){
alert("Please Type a Message");	
	
}
else{	
var data = $(this).parent("form").serialize();
$.post('msg.php',data,function(){
	
});
alert("Message Sent Successfully");
$(".msgtext").val(" ");
}
}); 


$(".dlb").click(function(){
var msg  = $(this).parent().parent().parent().parent("form").serialize();
$.post("dlb.php",msg,function(){

	});	
$(this).parent().parent().parent().parent("form").fadeOut();	
});



$(".sendfl").click(function(){
var fname = $("form.flform").serialize();
$.post('sendfl.php',fname,function(){	
	});
alert("File Send Successfully");
	
});

$(".dlf").click(function(){
var fname = $(this).parent().parent("form").serialize();
$.post('dlfl.php',fname,function(){	
	});
$(this).parent().parent("form").fadeOut();
	
});
$(".klf").click(function(){
var fname = $(this).parent().parent("form").serialize();
$.post('movefile.php',fname,function(){	
	});
$(this).parent().parent("form").fadeOut();
alert("File Added To Your Directory");	
});



});

</script>

<?php
session_start('user');

if(isset($_FILES['file'])){
move_uploaded_file($_FILES['file']['tmp_name'],"userdata/".$_SESSION['username']."_".$_SESSION['userid']."/".$_FILES['file']['name']);	

}


 ?>

<?php
include("connect.php");
 ?>

<link href="style.css" rel="stylesheet" type="text/css" />

<body>
<img src="images/background.jpg" class="back" />
<div class="nav">




<h3>Welcome <?php echo $_SESSION['username']; ?></h3>
<a href="logout.php" class="logoutbutton">Logout</a>

</div>

<div class="wrapper">





<h2>File Manager</h2>
<?php



//echo $_SESSION['userid'];
//echo $_SESSION['username'];
if(@opendir("userdata/".$_SESSION['username']."_".$_SESSION['userid'])){
if($handle = opendir("userdata/".$_SESSION['username']."_".$_SESSION['userid'])){
while(false!==($file = readdir($handle))){
if($file=="." || $file==".." ){}
else{
?>
<form method="post" action="#" class="fileform">
<span class="filename"><?php echo $file; ?></span><span class="options"><a href="<?php echo "userdata/".$_SESSION['username']."_".$_SESSION['userid']."/".$file; ?>" download="<?php echo $file; ?>">Download</a>
<input type="hidden" value="<?php echo "userdata/".$_SESSION['username']."_".$_SESSION['userid']."/".$file; ?>" name="path"  />
<label class="delete">| Delete</label>
</span><br />
</form>
<?php	
}	
}
}
}else{
@mkdir("userdata/".$_SESSION['username']."_".$_SESSION['userid'],0777);	


}

?>




<h2>File Upload</h2>
<form method="post" action="#" enctype="multipart/form-data" class="upform">
<input type="file" name="file" class="upfile" />
<input type="submit" class="picup" value="UPLOAD"/>
</form>





<h2>Send Message</h2>
<form class="upform msgform" method="post" action="#">
<p style="font-family:Arial, Helvetica, sans-serif;"><strong>Select a User</strong></p>
<select name="userselect">
<?php 
$users = mysql_query("SELECT * FROM users");
while($user = mysql_fetch_array($users)){
if($user['uname']!=$_SESSION['username']){	
?>
<option value="<?php echo $user['id']; ?>"><?php echo $user['uname']; ?></option>

<?php	
}


}
?>

<textarea placeholder="Type Your Message Here" class="msgtext" name="umsg"></textarea>
<input type="hidden" name="uid" value="<?php echo $_SESSION['userid']; ?>"/>
<p class="picup sendmsg" style="float: right;margin-right: 48%;
margin-top: 2%;"/>Send</p>
</form>











<h2>Send Files</h2>
<form class="upform flform" method="post" action="#">
<p style="font-family:Arial, Helvetica, sans-serif;"><strong>Select a User&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select File</strong></p>
<select name="userselect">
<?php 
$users = mysql_query("SELECT * FROM users");
while($user = mysql_fetch_array($users)){
if($user['uname']!=$_SESSION['username']){	
?>
<option value="<?php echo $user['id']."_".$user['uname']; ?>"><?php echo $user['uname']; ?></option>

<?php	
}

}
?>
</select>
<select name="fselect" style="width: 193px;">
<?php
if(opendir("userdata/".$_SESSION['username']."_".$_SESSION['userid'])){
if($handle = opendir("userdata/".$_SESSION['username']."_".$_SESSION['userid'])){
while(false!==($file = readdir($handle))){
if($file=="." || $file==".." ){}
else{
?>

<option value="<?php echo $file; ?>"><?php echo $file; ?></option>
<?php	
	
}}}}

?>


</select>
<input type="hidden" name="recname" value="<?php echo $user['uname']; ?>" />
<input type="hidden" name="recid" value="<?php echo $user['id']; ?>" />
<input type="hidden" name="senid" value="<?php echo $_SESSION['userid']; ?>"/>
<input type="hidden" name="senname" value="<?php echo $_SESSION['username']; ?>"/>
<p class="picup sendfl" style="float: right;margin-right: 48%;margin-top: 1%;
"/>Send</p>
</form>






















<h2>Inbox</h2>

<?php

$umsg = mysql_query("SELECT * FROM messages WHERE `reciever_id`= '".$_SESSION['userid']."' ORDER BY `msg_id` DESC LIMIT 0,10");
while($row = mysql_fetch_array($umsg)) {
	$q = mysql_query("SELECT * FROM users WHERE `id`= '".$row['sender_id']."'");
	$d = mysql_fetch_array($q);	
	
	?>
<form method="post" action="#">	
<input type="hidden" value="<?php echo $row['msg_id']; ?>" name="mid"/>
<div class="mail">
	  <p><span class="filename"><?php echo $row['msg']?></span>
	  <span class="options"> <?php echo "  send by  ".$d['uname']."  on  ". $row['date_added']?><span class="dlb" style="margin: 0px 10px;
color: blue;
cursor: pointer;">Delete Message</span></span> </p>
</div></form>
<?php
  }
?>




<h2>Outbox</h2>

<?php

$umsg = mysql_query("SELECT * FROM messages WHERE `sender_id`= '".$_SESSION['userid']."' ORDER BY `msg_id` DESC LIMIT 0,10");
while($row = mysql_fetch_array($umsg)) {
	
	$q = mysql_query("SELECT * FROM users WHERE `id`= '".$row['reciever_id']."'");
	$d = mysql_fetch_array($q);
	
	?>
	
<form method="post" action="#">	
<input type="hidden" value="<?php echo $row['msg_id']; ?>" name="mid"/>
<div class="mail">
	  <p><span class="filename"><?php echo $row['msg']?></span>
	  <span class="options"> <?php echo "  send to  ".$d['uname']."  on  ". $row['date_added']?><span class="dlb" style="margin: 0px 10px;
color: blue;
cursor: pointer;">Delete Message</span></span> </p>
      </div></form>
<?php
  }
?>


<h2>Recieved Files</h2>

<?php

$ufl = mysql_query("SELECT * FROM sharing WHERE `reciever_id`= '".$_SESSION['userid']."' ORDER BY `file_id` DESC LIMIT 0,10");
while($row = mysql_fetch_array($ufl)) {	?>
<form method="post" action="#">	
<input type="hidden" name="fid" value="<?php echo $row['file_id']; ?>"  />

<input type="hidden" name="sid" value="<?php echo $row['sender_id']; ?>"  />
<input type="hidden" name="rid" value="<?php echo $row['reciever_id']; ?>"  />
<input type="hidden" name="sname" value="<?php echo $row['sender_name']; ?>"  />
<input type="hidden" name="rname" value="<?php echo $row['reciever_name']; ?>"  />
<input type="hidden" name="fname" value="<?php echo $row['file_name']; ?>"  />
<div class="mail">

<span class="dlf" style="margin: 0px 10px;
color: blue;
cursor: pointer;">Delete File</span>

<span class="klf" style="margin: 0px 10px;
color: blue;
cursor: pointer;">Keep File</span>


 <p><span class="filename"><?php echo $row['file_name']?></span>
 <span class="options"> <?php echo "  send by  ".$row['sender_name']; ?></span> </p>
</div></form>
<?php
  }
?>


</div>


