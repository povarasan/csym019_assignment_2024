<?php
session_start();
include 'db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$ids = explode(',', $_GET['ids']);
$teams_sql = "SELECT * FROM football_team WHERE id IN (" . implode(',', $ids) . ")";
$teams_result = mysqli_query($conn, $teams_sql);
$teams_data = [];
while ($row = mysqli_fetch_assoc($teams_result)) {
    $teams_data[] = $row;
}

$colors = ['#3498DB', '#9B59B6', '#E74C3C', '#F39C12']; // Define colors here
$colorIndex = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Premier League Report</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:white;
            margin: 0;
            padding: 0;
            color: #ECF0F1;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            background-color: rgba(44, 62, 80, 0.95);
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 1200px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            color: #ECF0F1;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #34495E;
        }
        th {
            background-color: #1ABC9C;
        }
        tr:nth-child(even) {
            background-color: #34495E;
        }
        canvas {
            display:flex;
            width: 60%;
            max-width: 500px;
            margin-left: 20 auto ;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Premier League Report</h1>
        <table>
            <tr>
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
            </tr>
            <?php foreach ($teams_data as $team): ?>
            <tr>
                <td><?php echo htmlspecialchars($team['name']); ?></td>
                <td><?php echo htmlspecialchars($team['played']); ?></td>
                <td><?php echo htmlspecialchars($team['won']); ?></td>
                <td><?php echo htmlspecialchars($team['drawn']); ?></td>
                <td><?php echo htmlspecialchars($team['lost']); ?></td>
                <td><?php echo htmlspecialchars($team['goals_for']); ?></td>
                <td><?php echo htmlspecialchars($team['goals_against']); ?></td>
                <td><?php echo htmlspecialchars($team['goal_difference']); ?></td>
                <td><?php echo htmlspecialchars($team['points']); ?></td>
                <td><?php echo htmlspecialchars($team['form']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="charts">
            <canvas id="winLossPieChart"></canvas>
            <canvas id="teamComparisonBarChart"></canvas>
        </div>
        
        <script>
            const pieCtx = document.getElementById('winLossPieChart').getContext('2d');
            const pieData = {
                labels: ['Wins', 'Draws', 'Losses', 'Remaining'],
                datasets: [{
                    label: 'Matches',
                    data: [
                        <?php echo array_sum(array_column($teams_data, 'won')); ?>,
                        <?php echo array_sum(array_column($teams_data, 'drawn')); ?>,
                        <?php echo array_sum(array_column($teams_data, 'lost')); ?>,
                        <?php echo 38 - array_sum(array_column($teams_data, 'played')); ?>
                    ],
                    backgroundColor: ['#3498DB', '#9B59B6', '#E74C3C', '#F39C12']
                }]
            };

            new Chart(pieCtx, {
                type: 'pie',
                data: pieData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });

            <?php if (count($teams_data) > 1): ?>
            const barCtx = document.getElementById('teamComparisonBarChart').getContext('2d');
            const barData = {
                labels: ['Wins', 'Draws', 'Losses', 'Remaining'],
                datasets: [
                    <?php foreach ($teams_data as $team): ?>
                    {
                        label: '<?php echo htmlspecialchars($team['name']); ?>',
                        data: [
                            <?php echo $team['won']; ?>,
                            <?php echo $team['drawn']; ?>,
                            <?php echo $team['lost']; ?>,
                            <?php echo 38 - $team['played']; ?>
                        ],
                        backgroundColor: '<?php echo $colors[$colorIndex % count($colors)]; ?>'
                    },
                    <?php $colorIndex++; endforeach; ?>
                ]
            };

            new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
            <?php endif; ?>
        </script>
    </div>
</body>
</html>
