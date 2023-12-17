<?php

/**
 * List all users with a link to edit
 */

require "../config.php";
require "../common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM emailMessage";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<h2>All Mails</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>From </th>
            <th>To </th>
            <th>CC </th>
            <th>BCC </th>
            <th>Subject </th>
            <th>Message </th>
            <th>Date</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["sender"]); ?></td>
            <td><?php echo escape($row["receiver"]); ?></td>
            <td><?php echo escape($row["cc"]); ?></td>
            <td><?php echo escape($row["bcc"]); ?></td>
            <td><?php echo escape($row["subject"]); ?></td>
            <td><?php echo escape($row["email"]); ?></td>
            <td><?php echo escape($row["date"]); ?> </td>
            <td><a href="editMail.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<p></p>
<a href="index.php">Back to home</a>
<p></p>
<a href="createLabel.php">Back to Create label</a>
<?php require "templates/footer.php"; ?>