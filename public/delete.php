<?php

require "../config.php";
require "../common.php";

if (isset($_GET["id"])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        $id = $_GET["id"];

        $sql = "DELETE FROM reviews WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $success = "Review successfully deleted";
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM reviews
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

    <div class="navline1 border-color text-center" >
        <a href="index.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Home</button></a>
        <a href="read.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Search</button></a>
        <a href="create.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Create</button></a>
        <a href="update.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Update</button></a>
        <a href="delete.php"><button class="navbtn btn-active ml-lg-2 mr-lg-2 text-white">Delete</button></a>
    </div>

    <h4 class="font-weight-light letterspace mt-3 mb-3">Delete a Review</h4>

<?php if ($success) echo $success; ?>

    <table class="w-100">
        <thead>
        <tr>
            <th class="mobile-hide">#</th>
            <th class="text-center">Movie Title</th>
            <th class="text-center mobile-hide">Year</th>
            <th class="text-center">Rating</th>
            <th class="text-center">Review Comments</th>
            <th class="text-center">Reviewer</th>
            <th class="text-center mobile-hide">Date Reviewed</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $row) : ?>
            <tr>
                <td class="mobile-hide"><?php echo escape($row["id"]); ?></td>
                <td class="movietitle text-center"><?php echo escape($row["title"]); ?><span class="large-hide"><br>(<?php echo escape($row["year"]); ?>)</span></td>
                <td class="text-center mobile-hide"><?php echo escape($row["year"]); ?></td>
                <td class="text-center moviescore"><?php echo escape($row["rating"]); ?></td>
                <td class="review-comment"><?php echo escape($row["description"]); ?></td>
                <td class="text-center"><?php echo escape($row["reviewer"]); ?></td>
                <td class="mobile-hide"><?php echo escape($row["datereviewed"]); ?> </td>
                <td><a href="delete.php?id=<?php echo escape($row["id"]); ?>" class="text-danger">Delete</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require "templates/footer.php"; ?>