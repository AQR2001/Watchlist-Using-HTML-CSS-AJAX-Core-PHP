<?php
session_start();
require_once("require/database_connection.php");

if (isset($_REQUEST['login'])) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($connection, $query);
    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
        if ($data['email'] == $email && $data['password'] == $password) {
            $_SESSION['user'] = $data;
            header('location:indexx.php');
        }
    } else {
        header('location:login.php?msg="Invalid Email OR Password&color=Black"');
    }
}

if (isset($_GET['action']) && $_GET['action'] == "add_movie") {

    $user_id = $_SESSION['user']['user_id'];
    $genre_id = $_POST['genre'];
    $movie_name = $_POST['movie'];

    $query = "INSERT INTO movie(user_id,genre_id,movie_name) VALUES($user_id,$genre_id,'$movie_name')";
    $result = mysqli_query($connection, $query);
    if ($result) {
        echo "Movie Added Successfully.";
    } else {
        echo "Plz Add Movie Name First";
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "fetch_movies") {

    $genre_id = $_POST['genre'];
    $user_id = $_SESSION['user']['user_id'];

    if ($genre_id == "all") {
        $query = "SELECT * FROM movie,genre WHERE movie.genre_id =genre.genre_id && user_id = $user_id";
    } else if ($genre_id != "all") {
        $query = "SELECT * FROM movie,genre WHERE movie.genre_id = genre.genre_id && movie.genre_id = $genre_id && movie.user_id = $user_id ";
    }
    $result = mysqli_query($connection, $query);
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            ?>
            <div class="data">
                <span
                    class="<?= ($data['status'] == 'Watched') ? 'strike' : '' ?>"><?= $data['movie_name'] ?>(<?= $data['genre'] ?>)</span>
                <button onclick="watched(<?= $data['movie_id'] ?>,'<?= $data['status'] ?>')"
                    class="<?= ($data['status'] == 'Watched') ? 'strike' : '' ?>"><?= ($data['status'] == 'UnWatched') ? 'Mark Watched' : 'Mark UnWatched' ?></button>
            </div>
            <?php
        }
    } else {
        echo "No Movies Found.";
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "watched") {
    $movie_id = $_GET["movie_id"];
    $status = $_GET["status"];
    if ($status == "UnWatched") {
        $query = "UPDATE movie SET status='Watched' WHERE movie_id = $movie_id";
    } else if ($status == "Watched") {
        $query = "UPDATE movie SET status='UnWatched' WHERE movie_id = $movie_id";
    }

    $result = mysqli_query($connection, $query);
    if ($result) {
        echo "Updated Successfully.";
    } else {
        echo "Unsuccessfull Update.";
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "add_genre") {
    $genre_name = $_POST['genre_name'];

    $query = "INSERT INTO genre(genre) VALUES('$genre_name')";
    $result = mysqli_query($connection, $query);
    if ($result) {
        echo "Genre Added Successfully";
    } else {
        echo "Error In Adding Genre!.";
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "show_genre") {

    $query = "SELECT * FROM genre";
    $result = mysqli_query($connection, $query);
    ?>
    <option value="">SELECT GENRE</option>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <option value="<?= $row['genre_id'] ?>"><?= $row['genre'] ?></option>
        <?php
    }

}

if (isset($_GET['action']) && $_GET['action'] == 'filter_genre') {
    ?>
    <option value="all">Select All</option>
    <?php
    $query = 'SELECT * FROM genre';
    $result = mysqli_query($connection, $query);
    if ($result) {
        while ($data = mysqli_fetch_assoc($result)) {
            ?>
            <option value="<?= $data['genre_id'] ?>"><?= $data['genre'] ?></option>
            <?php
        }
    }
}
?>