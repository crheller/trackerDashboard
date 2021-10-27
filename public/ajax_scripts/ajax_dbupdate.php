
<?php
    //open a database connection
    require "../../config.php";
    $connection = new PDO($dsn, $username, $password, $options);

    $fields = array("experiment_id", "addedby", "experiment_rig", "experiment_class", "fish_id", "genotype", "dpf", "imaging", "bad", "comments");

    for ($x=0; $x<count($fields); $x+=1) {
        echo "<script>console.log('Debug Objects: " . $_REQUEST[$fields[$x]] . "' );</script>";
    }

    // for experiment_rig/class and imaging/bad/user/comments, we can just directly update table "data" where exp_id matches
    $expt_id = $_REQUEST["experiment_id"];
    $expt_fields = array("addedby", "experiment_rig", "experiment_class", "imaging", "bad", "comments");
    for ($i=0; $i<count($expt_fields); $i+=1) {
        $f = $expt_fields[$i];
        $v = $_REQUEST[$f];
        if ($f=="imaging" || $f=="bad") {
            if ($v=="true") {
                $v = 1;
            } else {
                $v = 0;
            }
            $sql = sprintf("UPDATE data SET %s=%s WHERE experiment_id=%s", $f, $v, $expt_id);
            echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
        } else {
            $sql = sprintf("UPDATE data SET %s=\"%s\" WHERE experiment_id=%s", $f, $v, $expt_id);
            echo "<script>console.log('Debug Objects: " . $sql . "' );</script>";
        }
        $statement = $connection->prepare($sql);
        $statement->execute();
    }

    // for fish stuff (name / idx / genotype / dpf), first need to make sure the fish exists in the db.

    // if the fish does not exist, add a new fish with the specified genotype / dpf and force idx to 1

    // then, go back and update the data table where id=expt_id with the new fish info

    // finally, need to do same thing with chambers as we just did with fish
        
    //     $sql = sprintf(
    //         "INSERT INTO %s (%s) values (%s)",
    //         "users",
    //         implode(", ", array_keys($new_user)),
    //         ":" . implode(", :", array_keys($new_user))
    //     );
        
    //     $statement = $connection->prepare($sql);
    //     $statement->execute($new_user);
    
?>