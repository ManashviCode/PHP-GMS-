<?php

/**
 * Use an HTML form to edit an entry in the
 * emailMessage table.
 */

require "../config.php";
require "../common.php";

if (isset($_GET['id'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['id'];

    $sql = "SELECT * FROM emailMessage WHERE id = :id";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $user =[
      "id" => $_POST['id'],
      "sender" => $_POST['sender'],
      "receiver"  => $_POST['receiver'],
      "cc"  => $_POST['cc'],
      "bcc"  => $_POST['bcc'],
      "subject"  => $_POST['subject'],
      "email"  => $_POST['email'],
      "date" => $_POST['date']
    ];

    $sql = "UPDATE emailMessage
            SET sender = :sender,
              receiver = :receiver,
              cc = :cc,
              bcc = :bcc,
              subject = :subject,
              email = :email,
              date = :date
            WHERE id = :id";

    $statement = $connection->prepare($sql);
    $statement->execute($user);
    header("Location: viewMail.php?id=" . $_POST['id']);
    exit();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit'])) : ?>
	<blockquote><?php echo escape($_POST['sender']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit Emails</h2>

<form method="post">
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>">
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>
<p></p>
<a href="index.php">Back to home</a>
<?php require "templates/footer.php"; ?>
