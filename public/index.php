<?php include "templates/header.php"; ?>

<div class="topnav">
            <h href="index.php">trackerdb</h>        
            <a href="create.php", id="end">Add</a>
            <a href="browse.php">Browse</a>
            <a href="analysis.php">Analysis</a>
            <a href="experiments.php">Active Experiments</a>
            <a class="active" href="index.php">Home</a>
</div> 

<div class="homepage">
  <p> 
    Welcome to the <em>trackerdb</em> dashboard! Use this page to browse existing datasets, take notes 
      for ongoing experiments, and add new entries to the RoLi database.
  </p>
  <img src="homepage.jpg" width="1000in"/><br>
</div>

<?php include "templates/footer.php"; ?>