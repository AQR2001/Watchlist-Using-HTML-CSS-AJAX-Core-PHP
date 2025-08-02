<?php
session_start();
require_once("require/database_connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: teal;
            background-color: #465C88;
            color: #2C2C2C;
        }

        h1 {
            text-align: center;
        }

        form {
            display: grid;
            gap: 1em;
            max-width: 25rem;
            padding: 3em 2em;
            margin-inline: auto;
            border-radius: 5px;
            box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.3);

        }

        .genre {
            /* display: ; */
            display: grid;
            grid-auto-flow: column;
            grid-template-columns: 2fr 1fr;

        }

        input {
            padding: 1em;
            border-radius: 5px;
        }

        button,
        select {
            padding: 1em;
        }


        .btn {
            display: flex;
            justify-content: space-between;
            align-items: center;

        }

        a {
            text-decoration: none;
            color: #2C2C2C;
        }

        .btn button {
            padding: 8px;
            border-radius: 5px;
            background-color: #4FE0C2;
        }

        .display_box {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .display_box>select {
            width: auto;
            padding: 10px;
            margin-top: 20px;
            border-radius: 10px;
        }

        .display_box>button {
            padding: 10px;
            margin-top: 20px;
            border-radius: 10px;
        }

        .data {
            border: black solid;
            display: flex;
            justify-content: space-between;
            padding: 10px;
            margin-top: 10px;
            min-width: 30rem;
            background-color: aliceblue;
            border-radius: 10px;
        }

        .table {
            display: grid;
            justify-content: center;
        }

        .data>button {
            background-color: #4FE0C2;
            padding: 5px;
            border-radius: 10px;
            cursor: pointer;
        }

        .strike {
            text-decoration: line-through;
        }

        .popup-container {
            display: none;
            place-content: center;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.3);
        }

        .popup form {
            box-shadow: none;
        }

        .popup {
            position: relative;
            min-width: 30rem;
            margin-inline: auto;
            padding: 2em;
            border-radius: 5px;
            background-color: rgba(250, 250, 250, 1);
        }

        .popup img {
            display: block;
            max-width: 10rem;
            margin-inline: auto;
            margin-bottom: 1em;
        }

        .popup .cross {
            position: absolute;
            top: 0;
            right: 0;
            max-width: 1.7rem;
            padding: 5px;
            margin-top: .2rem;
            margin-right: .2rem;
            border: 1px solid black;
            border-radius: 50%;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="btn">
        <h3>Welcome <?= $_SESSION['user']['name'] ?></h3>

        <button><a href="logout.php">Logout</a></button>
    </div>

    <h1>Movie Watchlist</h1>

    <form class="movie-form" onsubmit="addMovie(event,this)">

        <input type="text" name="movie" placeholder="Movie Name...">

        <div class="genre">
            <select name="genre" id="form_genre">

            </select>

            <button type="button" onclick="openGenre()">Add Genre</button>
        </div>


        <input type="submit" name="add_movie" value="Add Movie">
    </form>


    <div class="popup-container">
        <div class="popup">
            <h2>New Genre</h2>
            <img src="images/undraw_ai-code-generation_imyw.svg" alt="">
            <img class="cross" onclick="closePop()" src="images/twitter.png" alt="">

            <form onsubmit="addGenre(event,this)">
                <input type="text" name="genre_name">

                <button>Add</button>
            </form>
        </div>
    </div>

    <div class="display_box">
        <select name="select_genre" id="select_genre">

        </select>
        <button onclick="movieFilter()">Filter</button>
    </div>

    <div class="table"></div>
</body>

</html>
<script>
    var xhr = new XMLHttpRequest();
    function showGenre() {
        let xhr1 = new XMLHttpRequest()
        xhr1.open('GET', 'process.php?action=show_genre')
        xhr1.onreadystatechange = function () {
            if (xhr1.readyState == 4 && xhr1.status == 200) {
                document.getElementById('form_genre').innerHTML = xhr1.responseText
            }
        }
        xhr1.send()
    }
    showGenre()
    function filterGenre() {
        let xhr2 = new XMLHttpRequest()
        xhr2.open('GET', 'process.php?action=filter_genre')
        xhr2.onreadystatechange = function () {
            if (xhr2.readyState == 4 && xhr2.status == 200) {
                document.getElementById('select_genre').innerHTML = xhr2.responseText
            }
        }
        xhr2.send()
    }
    filterGenre()
    function movieFilter() {
        var genre = document.getElementById('select_genre').value
        if (genre == "") {
            genre = "all";
        }
        xhr.open('POST', 'process.php?action=fetch_movies')
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.querySelector('.table').innerHTML = xhr.responseText
            }
        }
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        xhr.send(`genre=${genre}`)
    }
    movieFilter()
    function addMovie(e, form) {
        e.preventDefault()
        xhr.open("POST", "process.php?action=add_movie")
        var formData = new FormData(form)
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText)
                form.reset()
            }
        }
        xhr.send(formData)
    }

    function addGenre(e, form) {
        e.preventDefault()
        var formData = new FormData(form)
        xhr.open('POST', 'process.php?action=add_genre')
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText)
                form.reset()
                showGenre()
                filterGenre()
            }
        }
        xhr.send(formData)
    }

    function watched(movie_id, status) {
        xhr.open('GET', 'process.php?action=watched&movie_id=' + movie_id + '&status=' + status)
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText)
                movieFilter()
            }
        }
        xhr.send()
    }

    function closePop() {
        document.querySelector('.popup-container').style.display = 'none'
    }

    function openGenre() {
        document.querySelector('.popup-container').style.display = 'Grid'
    }
</script>