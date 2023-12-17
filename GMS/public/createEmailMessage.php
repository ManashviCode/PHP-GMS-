<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "sender" => $_POST['sender'],
      "receiver"  => $_POST['receiver'],
      "cc"     => $_POST['cc'],
      "bcc"     => $_POST['bcc'],
      "subject"     => $_POST['subject'],
      "email"     => $_POST['email']
    );

    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "emailMessage",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user))
    );
    
    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['sender']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Create a mail</h2>

  <form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">

    <label for="sender">From :</label>
    <input type="text" name="sender" id="sender">

    <label for="receiver">To :</label>
    <input type="text" name="receiver" id="receiver">

    <label for="cc">CC :</label>
    <input type="text" name="cc" id="cc">

    <label for="bcc">BCC :</label>
    <input type="text" name="bcc" id="bcc">

    <label for="subject">Subject :</label>
    <input type="text" name="subject" id="subject">

    <label for="email">Compose email :</label>
    <input type="text" name="email" id="email">

    <input type="submit" name="submit" value="Submit">
  </form>

<p></p>
  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
