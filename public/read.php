<?php

if (isset($_POST['submit'])) {
    try  {

        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT  `title`,`year`,`rating`,`description`,`reviewer`,`datereviewed`
                        FROM reviews
                        WHERE title LIKE :title";

        $title = '%' . $_POST['title'] . '%';
        $statement = $connection->prepare($sql);
        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->execute();


        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

?>

<?php include "templates/header.php"; ?>

    <div class="navline1 border-color text-center" >
        <a href="index.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Home</button></a>
        <a href="read.php"><button class="navbtn btn-active ml-lg-2 mr-lg-2 text-white">Search</button></a>
        <a href="create.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Create</button></a>
        <a href="update.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Update</button></a>
        <a href="delete.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Delete</button></a>
    </div>

    <h4 class="font-weight-light letterspace mt-3 mb-3">Find a Movie by its Title</h4>

    <form method="post">
        <div class="form-group">
            <label for="title">Movie Title</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
            <input type="submit" name="submit" value="View Results" class="btn text-white btn-active btn-submit">
    </form>

<?php
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h4 class="mt-3 text-center">Results</h4>

        <table class="mb-3 w-100">
            <thead>
            <tr>
                <th class="text-center">Movie Title</th>
                <th class="text-center mobile-hide">Year</th>
                <th class="text-center">Rating</th>
                <th class="text-center">Review Comments</th>
                <th class="text-center">Reviewer</th>
                <th class="text-center mobile-hide">Date Reviewed</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td class="movietitle text-center"><?php echo escape($row["title"]); ?><span class="large-hide"><br>(<?php echo escape($row["year"]); ?>)</span></td>
                    <td class="text-center mobile-hide"><?php echo escape($row["year"]); ?></td>
                    <td class="text-center moviescore"><?php echo escape($row["rating"]); ?></td>
                    <td class="review-comment"><?php echo escape($row["description"]); ?></td>
                    <td class="text-center"><?php echo escape($row["reviewer"]); ?></td>
                    <td class="mobile-hide"><?php echo escape($row["datereviewed"]); ?> </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_POST['title']); ?>.</blockquote>
    <?php }

} ?>

<?php include "templates/footer.php"; ?>