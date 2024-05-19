

<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Handle the case where id is not set or not valid
    // You can redirect the user or show an error message
    exit('Invalid team ID');
}

$id = $_GET['id'];
$sql = "SELECT * FROM football_team WHERE id='$id'";
$result = mysqli_query($conn, $sql);

// Check if the query was successful and if a team was found
if (!$result || mysqli_num_rows($result) == 0) {
    // Handle the case where no team was found
    // You can redirect the user or show an error message
    exit('Team not found');
}

$team = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Edit Team</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #004080;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 40%;
            background-color: grey;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color:white;
        }
        form {
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Team</h1>
        <?php if(isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
        <label for="name">Team Name:</label>
<input type="text" id="name" name="name" value="<?php echo htmlspecialchars($team['name']); ?>">

            <label for="played">Played:</label>
            <input type="number" id="played" name="played" value="<?php echo $team['played']; ?>">

            <label for="won">Won:</label>
            <input type="number" id="won" name="won" value="<?php echo $team['won']; ?>">

            <label for="drawn">Drawn:</label>
            <input type="number" id="drawn" name="drawn" value="<?php echo $team['drawn']; ?>">

            <label for="lost">Lost:</label>
            <input type="number" id="lost" name="lost" value="<?php echo $team['lost']; ?>">

            <label for="goals_for">Goals For:</label>
            <input type="number" id="goals_for" name="goals_for" value="<?php echo $team['goals_for']; ?>">

            <label for="goals_against">Goals Against:</label>
            <input type="number" id="goals_against" name="goals_against" value="<?php echo $team['goals_against']; ?>">

            <label for="goal_difference">Goal Difference:</label>
            <input type="number" id="goal_difference" name="goal_difference" value="<?php echo $team['goal_difference']; ?>">

            <label for="points">Points:</label>
            <input type="number" id="points" name="points" value="<?php echo $team['points']; ?>">

            <label for="form">Form:</label>
            <input type="text" id="form" name="form" value="<?php echo $team['form']; ?>">

            <input type="submit" value="Update Team">
        </form>
    </div>
</body>
</html>
