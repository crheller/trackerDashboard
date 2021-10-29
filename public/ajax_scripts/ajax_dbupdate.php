
<?php
    //open a database connection
    require "../../config.php";
    $connection = new PDO($dsn, $username, $password, $options);

    $fields = array("experiment_id", "addedby", "experiment_rig", "experiment_class", 
                        "fish_id", "fish_idx", "genotype", "dpf", "imaging", "bad", "comments");
    // for experiment_rig/class and imaging/bad/user/comments, we can just directly update table "data" where exp_id matches
    $expt_id = $_REQUEST["experiment_id"];
    $expt_fields = array("addedby", "experiment_rig", "experiment_class", "imaging", "bad", "comments");
    $sql = "UPDATE data SET ";
    for ($i=0; $i<count($expt_fields); $i+=1) {
        $f = $expt_fields[$i];
        $v = $_REQUEST[$f];
        if ($f=="imaging" || $f=="bad") {
            if ($v=="true") {
                $v = 1;
            } else {
                $v = 0;
            }
            $sql = $sql . sprintf("%s=%s, ", $f, $v);
        } else {
            $sql = $sql . sprintf("%s=\"%s\", ", $f, $v);
        }
    }
    
    $sql = rtrim($sql, ", ");
    $sql = sprintf($sql . " WHERE experiment_id=%s", $expt_id);
    echo "<script>console.log('Updating data table: " . $sql . "' );</script>";
    $statement = $connection->prepare($sql);
    $statement->execute();

    // for fish stuff (name / idx / genotype / dpf), first need to make sure the fish exists in the db.
    $sql = sprintf("SELECT count(*) FROM fish WHERE fish_id=\"%s\"", $_REQUEST["fish_id"]);
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchColumn(); 
    $genotype = str_replace("plus", "+", $_REQUEST["genotype"]);
    $dpf = $_REQUEST['dpf'];

    // if the fish does not exist, add a new fish with the specified genotype / dpf and force idx to 1
    // then, go back and update the data table where id=expt_id with the new fish info
    if ($result > 0) {
        $sql = sprintf("UPDATE fish SET genotype=\"%s\", dpf=%s WHERE fish_id=\"%s\"", $genotype, $dpf, $_REQUEST['fish_id']);
        $statement = $connection->prepare($sql);
        $statement->execute();
        echo "<script>console.log('sql: " . $sql . "');</script>";
    } else {
        $sql = sprintf("INSERT into fish (fish_id, genotype, dpf, addedby) VALUE (\"%s\", \"%s\", %s, \"%s\")", 
                        $_REQUEST['fish_id'], $genotype, $dpf, $_REQUEST['addedby']);
        $statement = $connection->prepare($sql);
        $statement->execute();
        echo "<script>console.log('sql: " . $sql . "');</script>";
        
        $sql = sprintf("UPDATE data SET fish_id=\"%s\", fish_idx=1 WHERE experiment_id=%s", $_REQUEST['fish_id'], $expt_id);
        $statement = $connection->prepare($sql);
        $statement->execute();
        echo "<script>console.log('sql: " . $sql . "');</script>";

    }

    // finally, need to do same thing with chambers as we just did with fish

    
?>