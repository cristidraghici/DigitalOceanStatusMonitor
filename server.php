<?php
// Success message
$error = "Server is up and running.";


// MySQL status check
#$link = @mysqli_connect('localhost', 'my_user', 'my_password', 'my_db');
#if (!$link)
#{
#	$error = 'Error';
#}

// Show the output
echo $error;
?>