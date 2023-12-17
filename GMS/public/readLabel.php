<?php

/**
 * Function to query information based on
 * a parameter: in this case, labelname.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM labels
            WHERE labelname = :labelname"; // Corrected the SQL query here

    $location = $_POST['labelname'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':labelname', $location, PDO::PARAM_STR);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <h2>Results</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Title </th>
                <th>Description</th>
                <th>Creation Date</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["labelid"]); ?></td>
                <td><?php echo escape($row["labelname"]); ?></td>
                <td><?php echo escape($row["desciption"]); ?></td>
                <td><?php echo escape($row["date"]); ?> </td>
                <td><a href="editLabel.php?id=<?php echo escape($row["labelid"]); ?>">Edit</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php } else { ?>
      <blockquote>No results found for this label.</blockquote>
    <?php }
} ?>

<h3>Find label based on labelname</h3>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="labelname">Label Name</label>
  <input type="text" id="labelname" name="labelname">
<input type="submit" name="submit" value="View Results">
</form>
<p></p>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
