<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
		    "username" => $_POST['username'],
            "name" => $_POST['name'],
            "email"     => $_POST['email'],
            "password"       => $_POST['password'],
            "mobile"  => $_POST['mobile']
        );
		
		$x=0;
		if (preg_match("/^[a-zA_Z -]+$/", $_POST['username'])===0)
		{
			echo "username is not valid";
			$x++;
		}
		if (preg_match("/^[a-zA_Z -]+$/", $_POST['name'])===0)
		{
			echo "name is not valid";
			$x++;
		}
		$email=$_POST["email"];
		if(filter_var($email,FILTER_VALIDATE_EMAIL))
		{
		}
			
		else{
			echo("<br>$email is not a valid email address");
			$x++;
		}
		$password=$_POST['password'];
		if(!is_numeric($password))
		{
			echo"<br> password should be in digit";
			$x++;
		}
		else if (strlen($password)>6)
		{
			echo"not a valid password";
			$x++;
		}
	
		if(!is_numeric($_POST['mobile']))
		{
			echo"<br> mobile should be in digit";
			$x++;
		}
		else if(strlen($_POST['mobile'])>10)
		{
			echo"not a valid mobile";
			$x++;
		}
	
	
    
		$sql ="SELECT * FROM task1 WHERE username =:username";

        

        $statement = $connection->prepare($sql);
        $statement->bindValue(':username',$_POST["username"]);
        $statement->execute();
		if($row = $statement->fetch(PDO::PARAM_STR)){
			$usernameExists =1;
		}
	else{
			$usernameExists=0;
		}
		$statement->closeCursor();
		if($usernameExists){
			echo "exists";
			$x++;
		}
		$sql ="SELECT * FROM task1 WHERE email=:email";

        

        $statement = $connection->prepare($sql);
        $statement->bindValue(':email',$_POST["email"]);
        $statement->execute();
		if($row = $statement->fetch(PDO::PARAM_STR)){
			$usernameExists =1;
		}
	else{
			$usernameExists=0;
		}
		$statement->closeCursor();
		if($usernameExists){
			echo "exists";
			$x++;
		}
	
	
		
		if($x<1)
		{
			

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "task1",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    }
    else
	{
echo"error";
		}
		
			
	}catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['username']; ?> successfully added.</blockquote>
<?php } ?>
<h2>registration</h2>
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
	var name=document.forms["form"]["name"].value;
	if(name=="")
	{
		alert("enter a valid name");
		document.forms["form"]["name"].focus();
		return false;
	}
	var x=document.forms["form"]["email"].value;
	 var atposition=x.indexOf("@");
	 var dotposition=x.lastIndexOf(".");
	 if(atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length)
	 {
		  alert("enter the valid email");
           document.forms["form"]["email"].focus();
           return false;
     }
	 var pass=document.forms["form"]["password"].value;
	if(pass=="")
	{
		alert("enter a valid password");
		document.forms["form"]["password"].focus();
		return false;
	}
	
   var mob=document.forms["form"]["mobile"].value;
	if(mob=="")
	{
		alert("enter a valid mobile");
		document.forms["form"]["mobile"].focus();
		return false;
	}
	else{
	return true;
	}
}
	</script>
	<label for="username"> UserName</label>
    <input type="text" name="username" id="username">
    <label for="name"> Name</label>
    <input type="text" name="name" id="name">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="password">password</label>
    <input type="text" name="password" id="password">
    <label for="mobile">mobile</label>
    <input type="text" name="mobile" id="mobile">
    <input type="submit" name="submit" value="Submit">
</form>


<a href="login.php">login</a>

<?php require "templates/footer.php"; ?>
