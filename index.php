<?php
// 1. Load Classes FIRST (Move these to the top!)
require_once 'classes/class-codecase.php';
require_once 'classes/class-game.php';


require_once 'config.php';

// 3. Initialize Game Logic
if (!isset($_SESSION['ducktective_game'])) {
    $_SESSION['ducktective_game'] = new Game();
}

$game = $_SESSION['ducktective_game'];
$message = "";
$showNextButton = false;

// 4. Handle POST Requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['answer']) && !empty(trim($_POST['answer']))) {
        if ($game->checkAnswer(trim($_POST['answer']))) {
            $message = "✅ You solved the case!";
            $showNextButton = true;
        } else {
            $message = "❌ Wrong guess! Try again.";
        }
    } elseif (isset($_POST['next_case'])) {
        $game->nextCase() ? $message = "🕵️‍♂️ New case loaded!" : $message = "🎉 Game Complete!";
    } elseif (isset($_POST['previous_case'])) {
        $game->previousCase();
        $message = "↩️ Previous case loaded!";
    } elseif (isset($_POST['reset'])) {
        $game->resetGame();
        $message = "🔄 Game reset!";
    }
}
$_SESSION['ducktective_game'] = $game;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duck-tective - Code Detective</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="game-container">
        <div class="game-header">
            <h1>Duck-tective</h1>
            <p>Find the missing parts in the code to solve the case!</p>
        </div>
        
        <div class="game-content">
            <?php if ($message): ?>
                <div class="message <?php echo (strpos($message, '✅') !== false) ? 'success' : ((strpos($message, '❌') !== false) ? 'error' : 'info'); ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!$game->isGameComplete()): ?>
                <?php $currentCase = $game->getCurrentCase(); ?>
                <div class="case-info">
                    <div class="case-number">Case #<?php echo $currentCase->getId(); ?></div>
                    <div class="code-snippet"><?php echo htmlspecialchars($currentCase->displayCode()); ?></div>
                    <div class="hint">💡 <?php echo $currentCase->getHint(); ?></div>
                </div>
                
                <form method="POST" class="game-form">
                    <input type="text" id="answer" name="answer" placeholder="Type answer here..." autocomplete="off">
                    <div class="buttons-row">
                        <button type="submit" class="btn btn-primary">🔍 Check Answer</button>
                        <?php if ($showNextButton): ?>
                            <button type="submit" name="next_case" value="1" class="btn btn-success">➡️ Next Case</button>
                        <?php endif; ?>

                        <?php if ($game->getCurrentCaseNumber() > 1): ?>
                            <button type="submit" name="previous_case" value="1" class="btn btn-warning">
                                ⬅️ Previous Case
                            </button>
                        <?php endif; ?>
                        <button type="submit" name="reset" value="1" class="btn btn-danger">🔄 Reset</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="game-complete">
                    <h2>🎉 Case Closed!</h2>
                    <p>Final Score: <?php echo $game->getScore(); ?>/<?php echo $game->getTotalCases(); ?></p>
                    <form method="POST"><button type="submit" name="reset" value="1" class="btn btn-success">🦆 Play Again</button></form>
                </div>
            <?php endif; ?>

            <?php if (!$game->isGameComplete()): ?>
                <div class="score-board">
                    <div>Score: <?php echo $game->getScore(); ?></div>
                    <div>Case: <?php echo $game->getCurrentCaseNumber(); ?>/<?php echo $game->getTotalCases(); ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>