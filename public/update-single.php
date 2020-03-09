<?php

require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $review =[
            "id"                => $_POST['id'],
            "title"             => $_POST['title'],
            "year"              => $_POST['year'],
            "rating"            => $_POST['rating'],
            "description"       => $_POST['description'],
            "reviewer"          => $_POST['reviewer'],
            "datereviewed"      => $_POST['datereviewed']
        ];

        $sql = "UPDATE reviews
            SET id = :id,
              title = :title,
              year = :year,
              rating = :rating,
              description = :description,
              reviewer = :reviewer,
              datereviewed = :datereviewed
            WHERE id = :id";

        $statement = $connection->prepare($sql);
        $statement->execute($review);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}

if (isset($_GET['id'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['id'];
        $sql = "SELECT * FROM reviews WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();

        $review = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

    <div class="navline1 border-color text-center" >
        <a href="index.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Home</button></a>
        <a href="read.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Search</button></a>
        <a href="create.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Create</button></a>
        <a href="update.php"><button class="navbtn btn-active ml-lg-2 mr-lg-2 text-white">Update</button></a>
        <a href="delete.php"><button class="navbtn btn-inactive ml-lg-2 mr-lg-2 text-white">Delete</button></a>
    </div>

    <h4 class="font-weight-light letterspace mt-3 mb-3">Edit a Review</h4>

<?php if (isset($_POST['submit']) && $statement) : ?>
    <?php echo escape($_POST['title']); ?> successfully updated.
<?php endif; ?>

    <form method="post">
        <div class="form-group">
        <?php foreach ($review as $key => $value) : ?>
            <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
            <input class="form-control" type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>"
                <?php echo ($key === 'id' ? 'readonly' : null); ?>
                <?php echo ($key === 'datereviewed' ? 'readonly' : null); ?>>
        <?php endforeach; ?>
        </div>
        <input type="submit" name="submit" value="Submit" class="btn btn-active btn-submit text-white mb-3">
    </form>

<?php require "templates/footer.php"; ?>