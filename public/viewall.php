<?php

require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT
                `title`,`year`,`rating`,`description`,`reviewer`,`datereviewed`
            FROM
                `reviews`
            ORDER BY
	            title ASC";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

    <h2>Viewing All Reviews</h2>

    <table>
        <thead>
        <tr>
            <th>Movie Title</th>
            <th>Year Released</th>
            <th>Rating</th>
            <th>Description</th>
            <th>Reviewer</th>
            <th>Date Reviewed</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td><?php echo escape($row["title"]); ?></td>
                <td><?php echo escape($row["year"]); ?></td>
                <td><?php echo escape($row["rating"]); ?></td>
                <td><?php echo escape($row["description"]); ?></td>
                <td><?php echo escape($row["reviewer"]); ?></td>
                <td><?php echo escape($row["datereviewed"]); ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require "templates/footer.php"; ?>