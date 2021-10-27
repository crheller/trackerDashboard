<?php 
  session_start();
  include "templates/header.php"; 
?>

<h2>Search for active experiments</h2>

<form method="post">
	<label for="username">Username:</label>
	<input type="text" name="username" id="username">	
	<label for="rig">Experiment rig:</label>
	<input type="text" name="rig" id="rig">						
	<input type="submit" name="submit" value="Submit">
</form>

<?php 

if (isset($_POST['submit'])) {
	require "../config.php";
	require "../common.php";
	try {
        $connection = new PDO($dsn, $username, $password, $options);
      
        $sql = sprintf("SELECT experiment_id,
                       experiment_rig,
                       experiment_class,
                       data.fish_id,
                       data.fish_idx,
                       fish.genotype,
                       fish.dpf,
                       imaging,
                       bad,
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

}?>

<?php if (isset($_POST['submit']) && $statement) { ?>
  <?php 
    $query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION["query_results"] = $query_results;?>
    <div>
      <h3> Active experiments...</h3>
      <?php
      $ii = 0;
      foreach ($query_results as $qr) {?>
        <a href=<?php echo sprintf("expt_active.php?id=%s", $ii)?>><?php echo sprintf("%s/%s/%s/fishID-%s/idx-%s", $qr["addedby"], $qr["experiment_rig"], $qr["experiment_class"], $qr["fish_id"], $qr["fish_idx"]); ?><br></a>
        <?php
        $ii = $ii + 1;
      }?>
    </div>
    
<?php } ?> 



<?php include "templates/footer.php"; ?>

