<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM emailMessage
            WHERE sender = :sender";

    $location = $_POST['sender'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':sender', $location, PDO::PARAM_STR);
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
                <th>From </th>
                <th>To </th>
                <th>CC </th>
                <th>BCC </th>
                <th>Subject </th>
                <th>Message </th>
                <th>Date</th>

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

            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['sender']); ?>.</blockquote>
    <?php } 
} ?> 

<h2>Find Mail based on Sender Details</h2>

<form method="post">
  <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
  <label for="sender">Sender mail</label>
  <input type="text" id="sender" name="sender">
  <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>