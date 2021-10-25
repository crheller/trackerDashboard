<?php
  /* load the chambers data table */
    require "../config.php";
    require "../common.php";
    include "templates/header.php";
?>

<div class="topnav">
            <h href="index.php">trackerdb</h>        
            <a href="create.php", id="end">Add</a>
            <a class="active" href="browse.php">Browse</a>
            <a href="analysis.php">Analysis</a>
            <a href="experiments.php">Active Experiments</a>
            <a href="index.php">Home</a>
</div> 

<h3>Choose database table to browse</h3>
<div class="dropdown">
  <button class="dropbtn">Table</button>
  <div class="dropdown-content">
    <a href="data.php">Data</a>
    <a href="chambers.php">Chambers</a>
    <a href="fish.php">Fish</a>
    <a href="users.php">Users</a>    
  </div>
</div> 

<div class="chambers">
  <table class="styled-table">
    <?php
      try {
          echo sprintf("<thead><tr><th>chamber_id</th><th>addedby</th><th>photo_path</th><th>comments</th></tr></thead>");
          $connection = new PDO($dsn, $username, $password, $options);
      
          $sql = "SELECT * from tracker.chambers";
          
          $statement = $connection->prepare($sql);
          $statement->execute();
          $result = $statement->setFetchMode(PDO::FETCH_ASSOC); 

          // set the resulting array to associative
          $result = $statement->setFetchMode(PDO::FETCH_ASSOC);

          //array_keys($statement.fetchAll());

          foreach(new TableRows(new RecursiveArrayIterator($statement->fetchAll())) as $k=>$v) {
              echo $v;
          }
          //die(print_r($statement->fetchAll()));
        } catch(PDOException $error) {
          echo $sql . "<br>" . $error->getMessage();
        }

        $connection = null;
      ?>
    
  </table>

</div>

<?php include "templates/footer.php"; ?>