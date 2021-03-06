<?php 

if (isset($_POST['submit'])) {
	require "../config.php";
	require "../common.php";
	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_user = array(
		  "username"  => $_POST['username'],
		  "pass"      => $_POST["pass"],
		  "firstname" => $_POST['firstname'],
		  "lastname"  => $_POST['lastname'],
		  "email"     => $_POST['email']
		);
		
		$sql = sprintf(
			"INSERT INTO %s (%s) values (%s)",
			"users",
			implode(", ", array_keys($new_user)),
			":" . implode(", :", array_keys($new_user))
		);
		
		$statement = $connection->prepare($sql);
		$statement->execute($new_user);
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}

}

include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php echo escape($_POST['firstname']); ?> successfully added.
<?php } ?>

<h2>Add a user</h2>

<form method="post">
	<label for="username">Username</label>
	<input type="text" name="username" id="username">	
	<label for="pass">Password</label>
	<input type="text" name="pass" id="pass">						
	<label for="firstname">First Name</label>
	<input type="text" name="firstname" id="firstname">
	<label for="lastname">Last Name</label>
	<input type="text" name="lastname" id="lastname">
	<label for="email">Email Address</label>
	<input type="text" name="email" id="email">
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>