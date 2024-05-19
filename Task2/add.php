<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $played = $_POST['played'];
    $won = $_POST['won'];
    $drawn = $_POST['drawn'];
    $lost = $_POST['lost'];
    $goals_for = $_POST['goals_for'];
    $goals_against = $_POST['goals_against'];
    $goal_difference = $_POST['goal_difference'];
    $points = $_POST['points'];
    $form = $_POST['form'];

    $sql = "INSERT INTO teams (name, played, won, drawn, lost, goals_for, goals_against, goal_difference, points, form) VALUES ('$name', '$played', '$won', '$drawn', '$lost', '$goals_for', '$goals_against', '$goal_difference', '$points', '$form')";
    if (mysqli_query($conn, $sql)) {
        echo "Team added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Team</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #004080;
            background-size: cover; 
            color: #000000;
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
        }
        .container {
            background-color:grey;
            padding: 70px;
            border-radius: 8px;
            margin: 20px;
            width: 400px; /* Set width of the container */
            margin: auto; /* Center align the container */
        }
        label {
            display: block; /* Display labels as block elements */
            margin-bottom: 5px; /* Add margin bottom to separate labels */
        }
        input[type="text"],
        input[type="number"] {
            width: 100%; /* Set input fields to full width */
            padding: 15px; /* Add padding to input fields */
            margin-bottom: 10px; /* Add margin bottom to separate input fields */
            box-sizing: border-box;
            border-radius:5px; /* Include padding and border in the element's total width and height */
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: block; /* Display submit button as block element */
            width: 100%; /* Set submit button to full width */
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Team</h2>
        <form method="POST" action="">
            <label for="name">Team Name:</label>
            <input type="text" id="name" name="name">

            <label for="played">Played:</label>
            <input type="number" id="played" name="played">

            <label for="won">Won:</label>
            <input type="number" id="won" name="won">

            <label for="drawn">Drawn:</label>
            <input type="number" id="drawn" name="drawn">

            <label for="lost">Lost:</label>
            <input type="number" id="lost" name="lost">

            <label for="goals_for">Goals For:</label>
            <input type="number" id="goals_for" name="goals_for">

            <label for="goals_against">Goals Against:</label>
            <input type="number" id="goals_against" name="goals_against">

            <label for="goal_difference">Goal Difference:</label>
            <input type="number" id="goal_difference" name="goal_difference">

            <label for="points">Points:</label>
            <input type="number" id="points" name="points">

            <label for="form">Form:</label>
            <input type="text" id="form" name="form">

            <input type="submit" value="Add Team">
        </form>
    </div>
</body>
</html>