<?php

/**
 * List all users with a link to edit
 */

require "../config.php";
require "../common.php";

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql ="SELECT * FROM labels ORDER BY date";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>
        
<ul>
    <li><a href="createLabel.php"><strong>Create Label </strong></a> - create a label</li>
	<li><a href="readLabel.php"><strong>Read Label</strong></a> - find a label</li>
</ul>

<h2>Labels</h2>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Title </th>
            <th>Description</th>
            <th>Creation Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo escape($row["labelid"]); ?></td>
            <td><?php echo escape($row["labelname"]); ?></td>
            <td><?php echo escape($row["desciption"]); ?></td>
            <td><?php echo escape($row["date"]); ?> </td>
            <td><a href="viewLabel.php?labelid=<?php echo escape($row["labelid"]); ?>">View</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p></p>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>