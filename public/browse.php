<?php
    require "../config.php";
    require "../common.php";
    include "templates/header.php"; 
?>

<h3>Choose database table to browse</h3>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
    <div>
        <label for="table">Table:</label>
        <select name="table" id="table">
            <option value="">--- Choose a table ---</option>
            <option <?php if ($_POST['table'] == 'data') { ?>selected="true" <?php }; ?>value="data">Data</option>
            <option <?php if ($_POST['table'] == 'chambers') { ?>selected="true" <?php }; ?>value="chambers">Chambers</option>
            <option <?php if ($_POST['table'] == 'fish') { ?>selected="true" <?php }; ?>value="fish">Fish</option>
            <option <?php if ($_POST['table'] == 'users') { ?>selected="true" <?php }; ?>value="users">Users</option>
        </select>
    </div>
    <div class="button">
        <button type="submit">Load table</button>
    </div>
</form>

<?php
if(isset($_POST['table']) )
{
  if ($_POST['table']=='data') {?>
    <h3>Data</h3>
    <div class="tablediv">
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
  <?php
  }
  elseif ($_POST['table']=='chambers') { ?>
    <h3>Chambers</h3>
    <div class="tablediv">
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

  <?php
  }

  elseif ($_POST['table']=='fish') { ?>
    <h3>Fish</h3>
    <div class="tablediv">
      <table class="styled-table">
        <?php
          try {
              echo sprintf("<thead><tr><th>ID</th><th>dpf</th><th>genotype</th><th>Added by</th></tr></thead>");
              $connection = new PDO($dsn, $username, $password, $options);
          
              $sql = "SELECT fish_id, dpf, genotype, addedby from tracker.fish";
              
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

  <?php
  }


  elseif ($_POST['table']=='users') { ?>
    <h3>Users</h3>
    <div class="tablediv">
      <table class="styled-table">
        <?php
          try {
              echo sprintf("<thead><tr><th>ID</th><th>username</th><th>email</th><th>First Name</th><th>Last Name</th></tr></thead>");
              $connection = new PDO($dsn, $username, $password, $options);
          
              $sql = "SELECT id, username, email, firstname, lastname from tracker.users ORDER BY username";
              
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

  <?php
  }


}
?>


<?php include "templates/footer.php"; ?>