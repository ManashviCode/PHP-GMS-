<?php


try {
    require "../config.php";
    require "../common.php";

    // Get the user_id from the query parameter
    $labelid = $_GET['labelid'];

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM labels
            WHERE labelid = :labelid";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':labelid', $labelid);
    $statement->execute();

    $labels = $statement->fetch(); // Fetch the single row for the user_id

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<h2>Label Details</h2>
<table>
    <tr>
        <th>Attribute</th>
        <th>Value</th>
    </tr>
    <tr>
        <td>Title :</td>
        <td><?php echo escape($labels["labelname"]); ?></td>
    </tr>
    <tr>
        <td>Description :</td>
        <td><?php echo escape($labels["desciption"]); ?></td>
    </tr>
   	<tr>
        <td>Creation Date :</td>
        <td><?php echo escape($labels["date"]); ?></td>
    </tr>

</table>
  </br>


<a href="editLabel.php?labelid=<?php echo escape($labels["labelid"]); ?>">Edit</a>
<p></p>
<a href="index.php">Back to home</a>


	<?php require "templates/footer.php"; ?>