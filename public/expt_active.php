<?php 
    session_start();
    include "templates/header.php";
    require "../config.php";
    require "../common.php";

    try {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $sql = sprintf("SELECT experiment_id, experiment_rig, experiment_class, data.fish_id, data.fish_idx, fish.genotype, fish.dpf, imaging, bad, date_added, data.addedby, data_path, comments FROM data INNER JOIN fish ON fish.fish_id=data.fish_id WHERE data.experiment_id=%s", (int) $_GET['id'] + 1);
        $statement = $connection->prepare($sql);
        $statement->execute();
        $query_results = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
?>


<div class="form">
      <label for="addedby">User:</label>
      <input id="addedby" type="text" value=<?php echo sprintf("%s", $query_results[0]["addedby"])?>>

      <label for="experimnet_rig">Experiment rig:</label>
      <input id="experiment_rig" type="text" value=<?php echo sprintf("%s", $query_results[0]["experiment_rig"])?>>

      <label for="experiment_class">Experiment class:</label>
      <input id="experiment_class" type="text" value=<?php echo sprintf("%s", $query_results[0]["experiment_class"])?>>

      <label for="fish_id">Fish ID:</label>
      <input id="fish_id" type="text" value=<?php echo sprintf("%s", $query_results[0]["fish_id"])?>>

      <label for="fish_idx">Fish idx:</label>
      <input id="fish_idx" type="text" value=<?php echo sprintf("%s", $query_results[0]["fish_idx"])?>>

      <label for="genotype">Genotype:</label>
      <input id="genotype" type="text" value=<?php echo sprintf("%s", $query_results[0]["genotype"])?>>

      <label for="dpf">dpf:</label>
      <input id="dpf" type="text" value=<?php echo sprintf("%s", $query_results[0]["dpf"])?>>

      <label for="imaging">Imaging:</label>
      <input type="checkbox" id="imaging" <?php if ($query_results[0]["imaging"] == 1) {echo "checked='true'";}?>>

      <label for="bad">Bad file:</label>
      <input type="checkbox" id="bad" <?php if ($query_results[0]["bad"] == 1) {echo "checked='true'";}?>>

      <label for="comments" class="comments">Comments:</label>
      <textarea id="comments" class="comments", type="text"><?php echo sprintf("%s", $query_results[0]["comments"])?></textarea>

      <button name="save", id="save", value="save" onclick="on_save('pass')">Save</button>
      <button name="save", id="save", value="save" onclick="on_save('quit')">Save and exit</button>
      <!-- more inputs -->
</div>

<script>
function on_save(str) {
    // get current field values and add them to the http message
    var html_msg = "ajax_scripts/ajax_dbupdate.php?";
    const ids = ["addedby", "experiment_rig", "experiment_class", "fish_id", "fish_idx", "genotype", "dpf", "imaging", "bad", "comments"];
    for (let key of ids) {
        if (key!="imaging" && key!="bad") {
            html_msg = html_msg + key + "=" + document.getElementById(key).value + "&";
        } else {
            html_msg = html_msg + key + "=" + document.getElementById(key).checked + "&";
        }
    }
    html_msg = html_msg + "experiment_id=" + <?php echo $query_results[0]["experiment_id"];?>;
    html_msg = html_msg.replaceAll("+", "plus");

    console.log(html_msg);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if (str=="quit") {
                window.location = "experiments.php";
            }
            console.log("Success writing to db!");
        }
    };
    xmlhttp.open("GET", html_msg, true);
    xmlhttp.send();
  
}
</script>


<?php include "templates/footer.php" ?>