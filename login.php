<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

   session_start();
    $username=$_POST['username'];
   $_session['username']=$username;
if (isset($_POST['login'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        
        
		$sql = "SELECT * 
                        FROM task1
                        WHERE username = :username and password=:password";
    $username=$_POST['username'];
	$password=$_POST['password'];
	$statement= $connection -> prepare($sql);
    $statement-> bindParam(':username', $username, PDO::PARAM_STR);
    $statement-> bindParam(':password', $password, PDO::PARAM_STR);
    $statement-> execute();
	if($row = $statement->fetch(PDO::PARAM_STR)){
			$usernameExists =1;
		}
	else{
			$usernameExists=0;
		}
		$statement->closeCursor();
		if($usernameExists){
			echo $_session['username'];
			echo "login sucessfully";
			
			
		}
	else
	{
		echo "no result";
	}
    

	
		
	}
  catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

}
?>
<?php require "templates/header.php"; ?>

	

    
<h2>login</h2>
<form method="post"name="form"  onsubmit="return validate()";>
<script>
function validate()
{
	var uname=document.forms["form"]["username"].value;
	if(uname=="")
	{
		alert("enter a valid username");
		document.forms["form"]["username"].focus();
		return false;
	}
	var pass=document.forms["form"]["password"].value;
	if(pass=="")
	{
		alert("enter a valid password");
		document.forms["form"]["password"].focus();
		return false;
	}
	else{
		return true;
	}
	}
	</script>
	<label for="username"> UserName</label>
    <input type="text" name="username" id="username">
    <label for="password">password</label>
    <input type="text" name="password" id="password">
	<input type="submit" name="login" value="login">
	</form>
	


<?php require "templates/footer.php"; ?>

    
	


	
