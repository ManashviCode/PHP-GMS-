<?php
/**
 * Home page to show the last 3 created entries from the primary table.
 */

require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
            FROM emailMessage
            ORDER BY date DESC
            LIMIT 3";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $recentEntries = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Welcome to Email Management System</h2>

<p>This is the home page of the Email Management System. You can see the lastest updated 3 emails details below.</p>

<?php if ($recentEntries && $statement->rowCount() > 0) : ?>
    <h3>Recent Email Entries</h3>

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
            <?php foreach ($recentEntries as $row) : ?>
                <tr>
                    <td><?php echo escape($row["id"]); ?></td>
                    <td><?php echo escape($row["sender"]); ?></td>
                    <td><?php echo escape($row["receiver"]); ?></td>
                    <td><?php echo escape($row["cc"]); ?></td>
                    <td><?php echo escape($row["bcc"]); ?></td>
                    <td><?php echo escape($row["subject"]); ?></td>
                    <td><?php echo escape($row["email"]); ?></td>
                    <td><?php echo escape($row["date"]); ?> </td>
                    <td><a href="viewMail.php?id=<?php echo escape($row["id"]); ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <blockquote>No recent entries found.</blockquote>
<?php endif; ?>

<p><a href="createEmailMessage.php">Create a new mail</a></p>
<p><a href="readMail.php">Read Mails</a></p>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
