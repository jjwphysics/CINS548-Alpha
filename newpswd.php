<?php
session_start();
?>
 
<?php

include 'mysql_settings.php';
$index_file="index.php";
$thisusername = $_POST['user'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
if($_POST['security_answer']!='')
$sec=$_POST['security_answer'];
$error= 0;

$password = stripslashes($password);
$confirm_password = stripslashes($confirm_password);
$password = mysql_real_escape_string($password);
$confirm_password = mysql_real_escape_string($confirm_password);
$sec_ans=$_POST['sec_ans'];
$errors=0;

 
if($sec!=$sec_ans)
    echo "<p> <a href= resetpw.php> Wrong security answer, click to go to reset page</a></p>";

else{?>

<form action="" method="POST">
<input type="hidden" name="user" value="<?php echo $thisusername;?>"></input>
<p>Enter the new Password:<br />
<input type="password" name="password" value="" /></p>
<p>Confirm Password:<br />
<input type="password" name="confirm_password" value="" /></p>
<input type="submit" name="submit"/>   

<?php }

if($sec==$sec_ans && isset($_POST['submit'])){
    
  
    if($password=='') {
 echo "<p>password can't be blank</p>";
	$errors=1;		
    }
if($confirm_password=='') {
	echo "<p>confirm password can't be blank</p>";
	$errors=2;		
    }
if($password!=$confirm_password) {
    echo "<p>passwords don't match</p>";
    $errors=3;
    }
        $salt = hash('sha256',date('c'));	//date and time ISO format
        //encrypt using sha256 and an encrypted salt
        $password = hash('sha256',$password.$salt);
        if($errors==0) {
			//insert into database
			$sql = "update users set password='$password' , salt='$salt' where (users.username='$thisusername')";	
			$result = mysql_query($sql);
                        echo "done";
                  	if($result) {
				echo "<p>successfully changed password</p>";
                                echo "<p><a href='index.php'>Click, to go back Home</a></p>";
			}
			else die('Invalid query: '. $sql . mysql_error());//echo "failed to add user";
		}
    }



    
    ?>