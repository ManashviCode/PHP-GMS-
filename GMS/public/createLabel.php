<?php
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start a transaction
    $connection->beginTransaction();

    // Query emailMessage to populate email select options
    $sql = "SELECT id FROM emailMessage";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $emailSelectOptions = $statement->fetchAll(PDO::FETCH_COLUMN);

    if (isset($_POST['submit'])) {
        if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

        // Create a new label
        $new_label = [
            "labelname" => $_POST['labelname'],
            "desciption" => $_POST['desciption'] // corrected typo
        ];

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            "labels",
            implode(", ", array_keys($new_label)),
            ":" . implode(", :", array_keys($new_label))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_label);

        // Get the labelid of the newly created label
        $labelid = $connection->lastInsertId();

        // Associate selected emails with the label in the relationship table
        if (!empty($_POST['id'])) {
            foreach ($_POST['id'] as $id) {
                $sql = "INSERT INTO emailMessage_labels (id, labelid) VALUES (:id, :labelid)";
                $statement = $connection->prepare($sql);
                $statement->execute([':labelid' => $labelid, ':id' => $id]);
            }
        }

        // Commit the transaction if everything is successful
        $connection->commit();

        echo '<blockquote>' . escape($_POST['labelname']) . ' successfully added.</blockquote>';
    }
} catch (PDOException $error) {
    // Rollback the transaction if an error occurs
    $connection->rollBack();
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<h2>Create a Label</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label for="labelname">Title:</label>
    <input type="text" name="labelname" id="labelname">

    <label for="desciption">Description:</label>
    <input type="text" name="desciption" id="desciption">

    <label for="id">Select email id(s) for the Label (Hold Ctrl/cmd to select multiple emails):</label>
    <select name="id[]" id="id" multiple>
        <?php
        foreach ($emailSelectOptions as $ID) {
            echo '<option value="' . $ID . '">' . $ID . '</option>';
        }
        ?>
    </select>

    <input type="submit" name="submit" value="Submit">
</form>

<p></p>
<a href="labels.php">Back to Labels</a>
<p></p>
<a href="emails.php">Back to Emails</a>
<p></p>
<a href="index.php">Back to Main menu</a>

<?php require "templates/footer.php"; ?>
