<?php


try {
    require "../config.php";
    require "../common.php";

    // Get the user_id from the query parameter
    $id = $_GET['id'];

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM emailMessage
            WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $emails = $statement->fetch(); // Fetch the single row for the user_id

} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<h2>Email Details</h2>

<table>
    <tr>
        <th>Attribute</th>
        <th>Value</th>
    </tr>
    <tr>
        <td>Sender :</td>
        <td><?php echo escape($emails["sender"]); ?></td>
    </tr>
    <tr>
        <td>Receiver :</td>
        <td><?php echo escape($emails["receiver"]); ?></td>
    </tr>
    <tr>
        <td>CC :</td>
        <td><?php echo escape($emails["cc"]); ?></td>
    </tr>
    <tr>
        <td>BCC :</td>
        <td><?php echo escape($emails["bcc"]); ?></td>
    </tr>
    <tr>
        <td>Subject :</td>
        <td><?php echo escape($emails["subject"]); ?></td>
    </tr>
	<tr>
        <td>Email :</td>
        <td><?php echo escape($emails["email"]); ?></td>
    </tr>
	<tr>
        <td>Creation Date :</td>
        <td><?php echo escape($emails["date"]); ?></td>
    </tr>



</table>
  </br>


<a href="editMail.php?id=<?php echo escape($emails["id"]); ?>">Edit</a>



	<?php require "templates/footer.php"; ?>