<?php
session_start();
include 'db.php';

// Fetch teams data
$sql = "SELECT * FROM football_team"; 
$teams_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team Management</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: black;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 1200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            color:black;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        th { 
           background-color: #004080;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .button {
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
            display: inline-block;
        }
        .button:hover {
            background-color: #003366;
        }
        .button-delete{
            background-color:black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
            display: inline-block;
        }
        .header {
            background-color: rgba(0, 64, 128, 0.9);
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
        }
        .footer {
            background-color: rgba(0, 64, 128, 0.9);
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .table-actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="header container">
        <h1>Premier League</h1>
        <div class="actions">
            <a href="add.php" class="button">Add New Team</a>
            <a href="#" class="button" onclick="logout()">Logout</a>
        </div>
    </div>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Played</th>
                    <th>Won</th>
                    <th>Drawn</th>
                    <th>Lost</th>
                    <th>Goals For</th>
                    <th>Goals Against</th>
                    <th>Goal Difference</th>
                    <th>Points</th>
                    <th>Form</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($teams_result && mysqli_num_rows($teams_result) > 0) {
                    while ($row = mysqli_fetch_assoc($teams_result)) {
                ?>
                <tr>
                    <td><input type="checkbox" name="select_team" value="<?php echo $row['id']; ?>"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['played']; ?></td>
                    <td><?php echo $row['won']; ?></td>
                    <td><?php echo $row['drawn']; ?></td>
                    <td><?php echo $row['lost']; ?></td>
                    <td><?php echo $row['goals_for']; ?></td>
                    <td><?php echo $row['goals_against']; ?></td>
                    <td><?php echo $row['goal_difference']; ?></td>
                    <td><?php echo $row['points']; ?></td>
                    <td><?php echo $row['form']; ?></td>
                    <td class="table-actions">
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="button">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="button-delete" onclick="return confirm('Are you sure you want to delete this team?');">Delete</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='12'>No teams found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <button class="button" onclick="generateReport()">Generate Report</button>
    </div>
    <div class="footer container">
        <p>&copy; <?php echo date("Y"); ?> Premier League</p>
    </div>
    <script>
        function generateReport() {
            const checkbox = document.querySelectorAll('input[name="select_team"]:checked');
            const Id = Array.from(checkbox).map(data=>data.value);
            if (Id.length > 0) {
                window.location.href = `charts.php?ids=${Id.join(',')}`;
            } else {
                alert("Please select at least one team to generate a report.");
            }
        }

        function logout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = 'login.php';
            }
        }
    </script>
</body>
</html>
