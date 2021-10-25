<?php include "templates/header.php"; ?>

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

<?php include "templates/footer.php"; ?>