<?php

if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_review = array(
            "title"       => $_POST['title'],
            "year"        => $_POST['year'],
            "rating"      => $_POST['rating'],
            "description" => $_POST['description'],
            "reviewer"    => $_POST['reviewer']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "reviews",
            implode(", ", array_keys($new_review)),
            ":" . implode(", :", array_keys($new_review))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_review);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php include "templates/header.php"; ?>

    <div class="navline1 border-color text-center" >
        <a href="index.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Home</button></a>
        <a href="read.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Search</button></a>
        <a href="create.php"><button class="navbtn btn-active ml-lg-2 mr-lg-2 text-white">Create</button></a>
        <a href="update.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Update</button></a>
        <a href="delete.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Delete</button></a>
    </div>

    <h4 class="font-weight-light letterspace mt-3 mb-3">Create Your Own Review</h4>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['title']; ?> successfully added.</blockquote>
<?php } ?>

    <form method="post">
        <div class="form-group">
            <label for="title">Movie Title</label>
            <input type="text" name="title" id="title" class="form-control" required>

            <label for="year">Year Released</label>
            <input type="text" name="year" id="year" class="form-control" required>

            <label for="rating">Rating 0 out of 10 (10 being the best)</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>

            <label for="description">Review Comments</label>
            <textarea name="description" id="description" cols="30" rows="5" class="form-control" required></textarea>

            <label for="reviewer">Name of Reviewer</label>
            <input type="text" name="reviewer" id="reviewer" class="form-control" required>
        </div>
        <input class="btn text-white btn-active btn-submit mb-3" type="submit" name="submit" value="Submit">
    </form>

<?php include "templates/footer.php"; ?>