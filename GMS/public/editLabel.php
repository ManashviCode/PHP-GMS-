<?php
try {
    require "../config.php";
    require "../common.php";

    // Get the labelid from the query parameter
    $labelid = $_GET['labelid'];

    // Check if the form has been submitted for updating
    if (isset($_POST['submit'])) {
        // Retrieve and validate updated label information from the form
        $updatedLabel = array(
            "labelname" => $_POST['labelname'],
            "desciption" => $_POST['desciption'], // Fix the typo here
        );

        // Update the label in the database using the provided labelid
        $connection = new PDO($dsn, $username, $password, $options);
        $sql = "UPDATE labels SET labelname = :labelname, desciption = :desciption WHERE labelid = :labelid";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':labelname', $updatedLabel['labelname']);
        $statement->bindValue(':desciption', $updatedLabel['desciption']);
        $statement->bindValue(':labelid', $labelid);
        $statement->execute();

        // Redirect to the viewLabel.php page after the update
        header("Location: viewLabel.php?labelid=$labelid");
        exit();
    }

    // Fetch the label information for displaying in the edit form
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM labels WHERE labelid = :labelid";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':labelid', $labelid);
    $statement->execute();
    $label = $statement->fetch();

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<h2>Edit Label</h2>

<form method="post">
    <label for="labelname">Title:</label>
    <input type="text" name="labelname" id="labelname" value="<?php echo escape($label['labelname']); ?>">

    <label for="desciption">Description:</label>
    <input type="text" name="desciption" id="desciption" value="<?php echo escape($label['desciption']); ?>">

    <label for="id">Select email id for the Label(Hold Ctrl/cmd to select multiple emails)</label>
    <select name="id[]" id="id" multiple>
            <?php
            try{
                $connection=new PDO($dsn, $username, $password, $options);

                $sql = "SELECT id FROM emailMessage";
                $statement = $connection->prepare($sql);
                $statement->execute();

                $IDs = $statement->fetchAll(PDO::FETCH_COLUMN);

                foreach($IDs as $ID){
                echo '<option value="' . $ID .'">' .$ID . '</option>';
                }
        }catch(PDOException $error){
            echo $sql . "<br> " . $error-> getMessage();
        }
        ?>
    </select>

    <input type="submit" name="submit" value="Update">
</form>
<p></p>
<a href="viewLabel.php?labelid=<?php echo escape($label['labelid']); ?>">Back to Label Details</a>
<p></p>
<a href="emails.php">Back to Email Details</a>


<?php require "templates/footer.php"; ?>
