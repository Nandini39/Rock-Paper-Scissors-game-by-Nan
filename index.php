<?php 
include 'db.php';
session_start();

// Fun facts array
$facts = [
    "Rock is actually a type of solid mineral matter!",
    "Paper was invented in China over 2,000 years ago.",
    "The first pair of scissors was invented about 3,000 years ago!",
    "Sea otters hold hands while they sleep so they don't drift apart.",
    "A day on Venus is longer than a year on Venus!",
    "Octopuses have three hearts and blue blood!",
    "Bananas are actually berries, but strawberries aren't!",
    "Honeybees can flap their wings 200 times per second!",
    "One million Earths could fit inside the Sun!",
    "Apples float in water because they are 25% air!",
    "Ketchup was used as medicine back in the 1830s!"
];

if (isset($_POST['clear_history'])) {
    $sql_clear = "TRUNCATE TABLE game_log";
    $conn->query($sql_clear);
    header("Location: index.php"); 
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}

$choices = ["Rock", "Paper", "Scissors"];
$result = "";
$player_move = "";
$computer_move = "";
$random_fact = "";


if (isset($_POST['choice'])) {
    // Ensure name is captured before use
    if (!empty($_POST['player_name'])) {
        $_SESSION['player_name'] = htmlspecialchars($_POST['player_name']);
    }
    
    $player_name = $_SESSION['player_name'] ?? 'Unknown';
    $player_move = $_POST['choice'];
    $computer_move = $choices[array_rand($choices)];

    if ($player_move == $computer_move) {
        $result = "Draw";
    } elseif (
        ($player_move == "Rock" && $computer_move == "Scissors") ||
        ($player_move == "Paper" && $computer_move == "Rock") ||
        ($player_move == "Scissors" && $computer_move == "Paper")
    ) {
        $result = "You Win";
        $random_fact = $facts[array_rand($facts)];

    } else {
        $result = "Computer Wins";
    }

    // Best Practice: Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO game_log (player_name, player_move, computer_move, result) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $player_name, $player_move, $computer_move, $result);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Rock Paper Scissors</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="game">
    <h1>Rock Paper Scissors</h1>

    <form method="post" action="index.php">
        <?php if (empty($_SESSION['player_name'])): ?>
            <input type="text" name="player_name" placeholder="Enter Player Name" required 
                   style="padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-bottom: 10px;">
        <?php else: ?>
            <p style="margin-bottom: 10px;">
                Playing as: <strong><?php echo htmlspecialchars($_SESSION['player_name']); ?></strong> 
                <a href="index.php?action=logout" style="color: #e4ceddff; font-size: 0.8em; margin-left: 10px;">Change Name</a>
            </p>
            <input type="hidden" name="player_name" value="<?php echo htmlspecialchars($_SESSION['player_name']); ?>">
        <?php endif; ?>

        <div class="button-group">
            <button type="submit" name="choice" value="Rock">🪨 Rock</button>
            <button type="submit" name="choice" value="Paper">📄 Paper</button>
            <button type="submit" name="choice" value="Scissors">✂️ Scissors</button>
        </div>
    </form>

    <?php if ($result): ?>
        <div class="result">
            <?php if ($result == "You Win"): ?>
                <div class="animation-container">
                    <img src="excited.gif" alt="Winner!" class="win-gif">
                </div>
                <div class="fact-box">
        <p><strong>Did you know?</strong></p>
        <p><?= $random_fact ?></p>
    </div>
            <?php endif; ?>
            <p><strong>You chose:</strong> <?= $player_move ?></p>
            <p><strong>Computer chose:</strong> <?= $computer_move ?></p>
            <h2><?= $result ?></h2>
        </div>
    <?php endif; ?>
</div> <div class="history-section" style="max-width: 600px; margin: 20px auto; color: #333;">
    <form method="post" style="text-align: right; margin-bottom: 10px;">
        <button type="submit" name="clear_history" 
                onclick="return confirm('Delete all game history?')"
                style="background-color: #dd4231ff; color: white; padding: 4px 10px; font-size: 12px; border: none; border-radius: 4px; cursor: pointer;">
            🗑️ Clear History
        </button>
    </form>

    <h2>Recent Games History</h2>
    
    <div class="table-wrapper"> <table border="1" width="100%" cellpadding="10">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Your Move</th>
                    <th>Computer Move</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM game_log ORDER BY id DESC LIMIT 10";
                $history_result = $conn->query($sql);

                if ($history_result && $history_result->num_rows > 0) {
                    while($row = $history_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["player_name"]) . "</td>";
                        echo "<td>" . ucfirst($row["player_move"]) . "</td>";
                        echo "<td>" . ucfirst($row["computer_move"]) . "</td>";
                        echo "<td><strong>" . strtoupper($row["result"]) . "</strong></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No games recorded yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>