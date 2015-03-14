<?php


session_start('user');

unset($_SESSION['userid']);
unset($_SESSION['username']);


session_destroy();
?>

<script type="text/javascript">
window.location = "index.php";


</script>














