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
                         INNER JOIN fish ON fish.fish_id=data.fish_id WHERE hardware_test=%s
                         ORDER BY experiment_id", 0);
          echo sprintf("<thead><tr><th>ID</th>
                                   <th>Experiment Class</th>
                                   <th>Fish</th>
                                   <th>Genotype</th>
                                   <th>dpf</th>
                                   <th>Imaging</th>
                                   <th>Date</th>
                                   <th>User</th>
                                   <th>Data file</th>
                                   <th>Comments</th>
                                   </tr></thead>");
          
          $statement = $connection->prepare($sql);
          $statement->execute();
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