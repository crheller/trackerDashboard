<!DOCTYPE html>
<?php
  $page = basename($_SERVER['PHP_SELF']);
?>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>trackerdb</title>

    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>

  <div class="topnav">
            <h href="index.php" <?php if($page == 'index.php'){ echo ' class="active"';}?>>trackerdb</h>        
            <a href="create.php" id="end"<?php if($page == 'create.php'){ echo ' class="active"';}?>>Add</a>
            <a href="browse.php"<?php if($page == 'browse.php'){ echo ' class="active"';}?>>Browse</a>
            <a href="analysis.php"<?php if($page == 'analysis.php'){ echo ' class="active"';}?>>Analysis</a>
            <a href="experiments.php"<?php if($page == 'experiments.php' | $page == 'expt_active.php'){ echo ' class="active"';}?>>Active Experiments</a>
            <a href="index.php"<?php if($page == 'index.php'){ echo ' class="active"';}?>>Home</a>
  </div>