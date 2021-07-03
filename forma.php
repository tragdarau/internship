<?php

function db_update($name, $sirname, $AM, $department, $email, $password, $comment){
	$servername = "localhost";
	$dbusername = "root";
	$dbpassword = "1234";
	$dbname = "employees";

	$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

	mysqli_set_charset($conn,"utf8");

	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	/*$sql = "CREATE TABLE Employees (
	AM INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	name VARCHAR(30) NOT NULL,
	sirname VARCHAR(30) NOT NULL,
	email VARCHAR(50),
	department VARCHAR (20),
	password VARCHAR (30)
	reg_date TIMESTAMP
	)"; To create table το κανω στο phpmyadmin. 
	Για $dbname βαζω ονομα βασης απο το phpmyadmin
	Για $username βαζω root (οτι εχω φτιαξει στο phpmyadmin)
	Για $password βαζω 1234 (οτι εχω φτιαξει στο phpmyadmin)
	*/

	$sql = "INSERT INTO Employees (name, sirname, AM, email, department, password, comment)
	VALUES ('".$name."', '".$sirname."', '".$AM."','".$email."','".$department."','".$password."','".$comment."')";



	if ($conn->query($sql) === TRUE) {
		echo "Επιτυχής εισαγωγή δεδομένων";
	} else {
		echo "Σφάλμα εισαγωγής δεδομένων" . $sql. "<br>" .$conn->error;
	}

	$conn->close();
}
?>

<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
body {
    background-color: lightblue;
}
div {
    width: 7%;
border: 1px solid;}
.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}


</style>
  <meta charset="UTF-8">
</head>
<body>  
<div style="width:100%;height:400px;">
<img src="images/gennhmatas.jpg" alt="Paris" style="float:left;width:50%;height:100%;object-fit:cover;">
<img src="images/nosokomeio.jpg" alt="Paris" style="float:left;width:50%;height:100%;object-fit:cover;"> </div>
<?php
$nameErr = $sirnameErr =$AMErr = $departmentErr = $emailErr  = $passwordErr =  " ";
$name = $sirname = $AM = $department = $email = $password = $comment =  "";


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") 
  if (empty($_POST["name"])) {
    $nameErr = "Απαιτείται το όνομα";
  } else {
    $name = test_input($_POST["name"]);
	if (!preg_match("/^[A-Za-z0-9α-ωΑ-Ω ίϊΐόάέύϋΰήώ-]+$/u",$name)){
		$nameErr="Μόνο γράμματα και κενά επιτρέπονται";
  }
 }
  
  if (empty($_POST["sirname"])) {
    $sirnameErr = " ";
  } else {
    $sirname = test_input($_POST["sirname"]);
	if (!preg_match("/^[A-Za-z0-9α-ωΑ-Ω ίϊΐόάέύϋΰήώ-]+$/u",$sirname)){
		$sirnameErr="Μόνο γράμματα και κενά επιτρέπονται";
	}
  }
	

  if (empty($_POST["AM"])) {
    $AMErr = "";
  } else {
    $AM = test_input($_POST["AM"]);
  }
  
  if (empty($_POST["department"])) {
    $departmentErr = " ";
  } else {
    $department = test_input($_POST["department"]);
  }
  
  
  if (empty($_POST["email"])) {
    $emailErr = " ";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Μη έγκυρη μορφή email"; 
    }
  }

  if (empty($_POST["password"])) {
    $passwordErr = " ";
  } else {
    $password = test_input($_POST["password"]);
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }
  
if($emailErr==" " && $sirnameErr==" " && $nameErr==" ")
	db_update($name, $sirname, $AM, $department, $email, $password, $comment);


?>


<h2>Φόρμα Εγγραφής</h2>
<p><span class="error">Απαιτείται να συμπληρωθούν τα πεδία με *.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <div>'Ονομα:</div> <input type="text" name="name" value=" <?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  <div>Επώνυμο:</div> <input type="text" name="sirname" value=" <?php echo $sirname;?>">
  <span class="error">* <?php echo $sirnameErr;?></span>
  <br><br>
  <div> Α.Μ Υπαλλήλου:</div> <input type="text" name="AM">
  <span class="error">* <?php echo $AMErr;?></span>
  <br><br>
  <div>Τμήμα:</div> <input type="text" name="department">
  <span class="error">* <?php echo $departmentErr;?></span>
  <br><br>
 <div> E-mail: </div><input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  <div>Κωδικός:</div> <label><input type="password" id="pass" name="password" /></label>
  <span class="error">* <?php echo $passwordErr;?></span>
  <br><br>
 <div> Σχόλια:</div> <textarea name="comment" rows="5" cols="40"><?php echo $comment;?></textarea>
 <br><br> 
 <input type="submit" name="submit" value="Υποβολή">  
 
</form>
</body>
</html>