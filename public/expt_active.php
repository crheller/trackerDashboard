<?php 
    session_start();
    include "templates/header.php";
?>

<div class="form">
      <label for="addedby">User:</label>
      <input id="addedby" type="text" value=<?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["addedby"])?>>

      <label for="experimnet_rig">Experiment rig:</label>
      <input id="experiment_rig" type="text" value=<?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["experiment_rig"])?>>

      <label for="experiment_class">Experiment class:</label>
      <input id="experiment_class" type="text" value=<?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["experiment_class"])?>>

      <label for="fish_id">Fish ID:</label>
      <input id="fish_id" type="text" value=<?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["fish_id"])?>>

      <label for="fish_idx">Fish idx:</label>
      <input id="fish_idx" type="text" value=<?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["fish_idx"])?>>

      <label for="genotype">Genotype:</label>
      <input id="genotype" type="text" value=<?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["genotype"])?>>

      <label for="dpf">dpf:</label>
      <input id="dpf" type="text" value=<?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["dpf"])?>>

      <label for="imaging">Imaging:</label>
      <input type="checkbox" id="imaging" <?php if ($_SESSION["query_results"][(int) $_GET["id"]]["imaging"] == 1) {echo "checked='true'";}?>>

      <label for="bad">Bad file:</label>
      <input type="checkbox" id="bad" <?php if ($_SESSION["query_results"][(int) $_GET["id"]]["bad"] == 1) {echo "checked='true'";}?>>

      <label for="comments" class="comments">Comments:</label>
      <textarea id="comments" class="comments", type="text"><?php echo sprintf("%s", $_SESSION["query_results"][(int) $_GET["id"]]["comments"])?></textarea>

      <button name="save", id="save", value="save" onclick="on_save('test')">Save</button>
      <button>Save and exit</button>
      <!-- more inputs -->
</div>

<script>
function on_save(str) {
    // get current field values and add them to the http message
    var html_msg = "ajax_scripts/ajax_dbupdate.php?";
    const ids = ["addedby", "experiment_rig", "experiment_class", "fish_id", "fish_idx", "genotype", "dpf", "imaging", "bad", "comments"];
    for (let key of ids) {
        console.log(key);
        if (key!="imaging" && key!="bad") {
            html_msg = html_msg + key + "=" + document.getElementById(key).value + "&";
        } else {
            html_msg = html_msg + key + "=" + document.getElementById(key).checked + "&";
        }
        

    }
    html_msg = html_msg + "experiment_id=" + <?php echo $_SESSION["query_results"][(int) $_GET["id"]]["experiment_id"]?>;

    console.log(html_msg);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        // success
        console.log("Success writing to db!");
        }
    };
    xmlhttp.open("GET", html_msg, true);
    xmlhttp.send();
  
}
</script>

<?php include "templates/footer.php" ?>