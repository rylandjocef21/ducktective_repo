<?php
// 1. Load Classes
require_once 'classes/class-codecase.php';
require_once 'classes/class-game.php';

// 2. Load Config (Optional)
if (file_exists('config.php')) {
    require_once 'config.php';
}

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Initialize Game Logic
if (!isset($_SESSION['ducktective_game'])) {
    $_SESSION['ducktective_game'] = new Game();
}

$game = $_SESSION['ducktective_game'];
$message = "";
$showNextButton = false;

// Initialize Screen State (Default to START)
if (!isset($_SESSION['screen_state'])) {
    $_SESSION['screen_state'] = 'START';
}

// 4. Handle POST Requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // ▶️ START BUTTON CLICKED
    if (isset($_POST['start_game'])) {
        $game->resetGame(); // Ensure fresh start
        $_SESSION['screen_state'] = 'GAME'; // Switch to Game Mode
    }
    
    // 🔄 RESET / TRY AGAIN CLICKED
    elseif (isset($_POST['reset'])) {
        $game->resetGame();
        $_SESSION['screen_state'] = 'START'; // Go back to Title Screen
        $message = "";
    }
    
    // 🔍 CHECK ANSWER CLICKED
    elseif (isset($_POST['answer']) && !empty(trim($_POST['answer']))) {
        if ($game->checkAnswer(trim($_POST['answer']))) {
            $message = "✅ Correct! Great job.";
            $showNextButton = true;
        } else {
            $message = "❌ Wrong guess! Try again.";
        }
    } 
    
    // ➡️ NEXT CASE CLICKED
    elseif (isset($_POST['next_case'])) {
        $game->nextCase();
        $message = ""; 
    } 
    
    // ⬅️ PREVIOUS CASE CLICKED
    elseif (isset($_POST['previous_case'])) {
        $game->previousCase();
        $message = "";
    } 
}

// Save state
$_SESSION['ducktective_game'] = $game;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duck-tective - Code Detective</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Orbitron:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Special Styles for Title & Victory */
        .center-screen {
            text-align: center;
            padding: 50px 20px;
            animation: fadeIn 0.8s ease-out;
        }
        .main-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 3.5rem;
            color: #3b82f6;
            text-shadow: 0 0 20px rgba(59, 130, 246, 0.6);
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 1.2rem;
            color: #94a3b8;
            margin-bottom: 40px;
        }
        .duck-logo {
            font-size: 5rem;
            display: block;
            margin-bottom: 20px;
            animation: float 3s infinite ease-in-out;
        }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-15px); } 100% { transform: translateY(0px); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <div class="game-container">
        
        <?php if ($_SESSION['screen_state'] === 'START'): ?>
            
            <div class="center-screen">
                <span class="duck-logo">🦆</span>
                <h1 class="main-title">DUCK-TECTIVE</h1>
                <p class="subtitle">The System is Broken. Only you can fix it.</p>
                
                <form method="POST">
                    <button type="submit" name="start_game" value="1" class="btn btn-primary big-btn" style="padding: 20px 50px; font-size: 1.5rem;">
                        ▶ START MISSION
                    </button>
                </form>
            </div>

        <?php elseif ($_SESSION['screen_state'] === 'GAME' && !$game->isGameComplete()): ?>
            
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
                            <?php if ($game->getCurrentCaseNumber() < $game->getTotalCases()): ?>
                                <button type="submit" name="next_case" value="1" class="btn btn-success">➡️ Next Case</button>
                            <?php else: ?>
                                <button type="submit" name="next_case" value="1" class="btn btn-primary">🏆 Finish Game</button>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($game->getCurrentCaseNumber() > 1): ?>
                            <button type="submit" name="previous_case" value="1" class="btn btn-warning">
                                ⬅️ Previous Case
                            </button>
                        <?php endif; ?>
                        
                        <button type="submit" name="reset" value="1" class="btn btn-danger">🔄 Reset</button>
                    </div>
                </form>

                <div class="score-board">
                    <div>Score: <?php echo $game->getScore(); ?></div>
                    <div>Case: <?php echo $game->getCurrentCaseNumber(); ?>/<?php echo $game->getTotalCases(); ?></div>
                </div>
            </div>

        <?php else: ?>
            
            <div class="center-screen">
                <div style="font-size: 5rem; margin-bottom: 20px;">🏆</div>
                
                <h1 class="main-title" style="color: #fbbf24;">CONGRATULATIONS!</h1>
                
                <p class="subtitle" style="color: #e2e8f0;">
                    You answered it all!<br>
                    You are a true PHP Master.
                </p>

                <div class="final-score" style="margin-bottom: 30px; font-size: 1.2rem; color: #a7f3d0;">
                    FINAL SCORE: <strong><?php echo $game->getScore(); ?> / <?php echo $game->getTotalCases(); ?></strong>
                </div>

                <form method="POST">
                    <button type="submit" name="reset" value="1" class="btn btn-success big-btn" style="padding: 15px 40px; font-size: 1.2rem;">
                        🔄 Play Again
                    </button>
                </form>
            </div>

        <?php endif; ?>
        
    </div>
    <script src="assets/script.js"></script>
</body>
</html>