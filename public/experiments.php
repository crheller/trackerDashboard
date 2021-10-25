<?php 

if (isset($_POST['submit'])) {
	require "../config.php";
	require "../common.php";
	try {
        $connection = new PDO($dsn, $username, $password, $options);
      
        $sql = sprintf("SELECT experiment_id,
                       experiment_class,
                       data.fish_id,
                       fish.genotype,
                       fish.dpf,
                       imaging,
                       date_added,
                       data.addedby,
                       data_path,
                       comments FROM data 
                       INNER JOIN fish ON fish.fish_id=data.fish_id WHERE data.addedby=\"%s\" and data.experiment_rig=\"%s\"
                       ORDER BY experiment_id", $_POST['username'], $_POST['rig']);

        // $new_user = array(
        //     "username"  => $_POST['username'],
        //     "pass"      => $_POST["pass"],
        //     "firstname" => $_POST['firstname'],
        //     "lastname"  => $_POST['lastname'],
        //     "email"     => $_POST['email']
        // );
        
        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->setFetchMode(PDO::FETCH_ASSOC); 
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}

}

include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php 
    echo escape($_POST['username']); 
    die(print_r($statement->fetchAll()));
    // display the results
    ?>
<?php } ?>

<div class="topnav">
            <h href="index.php">trackerdb</h>        
            <a href="create.php", id="end">Add</a>
            <a href="browse.php">Browse</a>
            <a href="analysis.php">Analysis</a>
            <a class="active" href="experiments.php">Active Experiments</a>
            <a href="index.php">Home</a>
</div> 

<?php include "templates/footer.php"; ?>

<h2>Search for active experiments</h2>

<form method="post">
	<label for="username">Username</label>
	<input type="text" name="username" id="username">	
	<label for="rig">Experiment rig</label>
	<input type="text" name="rig" id="rig">						
	<input type="submit" name="submit" value="Submit">
</form>

<?php include "templates/footer.php"; ?>