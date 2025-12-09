<?php
class Game {
    private $cases = [];
    private $currentCaseIndex = 0;
    private $score = 0;
    // 🆕 NEW: Keep track of which cases are already solved
    private $solvedCases = []; 
    
    public function __construct() {
        $this->initializeCases();
    }
    
    private function initializeCases() {
        // Clear everything to be safe
        $this->cases = [];
        
        $this->cases[] = new CodeCase(1, "if (x == 5) { echo 'Hello'; }", ":", "Missing symbol after condition");
        $this->cases[] = new CodeCase(2, "\$result = array_sum(\$numbers);", "$", "Missing variable symbol");
        $this->cases[] = new CodeCase(3, "for (i = 0; i < 10; i++) { echo i; }", "$", "Variables in PHP need a special symbol");
        $this->cases[] = new CodeCase(4, "function calculateTotal(\$price, \$tax) { return \$price + \$tax; }", ";", "Missing statement terminator");
        $this->cases[] = new CodeCase(5, "\$name = 'John'; echo 'Hello ' . \$name", ";", "Line needs proper ending");
        $this->cases[] = new CodeCase(6, "\$colors = array('red', 'green', 'blue');", ")", "Missing closing bracket");
        $this->cases[] = new CodeCase(7, "if (\$age > 18) { echo 'Adult'; } else { echo 'Minor'; }", ")", "Missing parenthesis in condition");
    }
    
    public function getCurrentCase() {
        if ($this->currentCaseIndex >= count($this->cases)) {
            return null;
        }
        return $this->cases[$this->currentCaseIndex] ?? null;
    }
    
    public function checkAnswer($answer) {
        $currentCase = $this->getCurrentCase();
        
        // 1. Check if the answer is actually correct
        if ($currentCase && $currentCase->checkAnswer($answer)) {
            
            // 2. 🛡️ ANTI-CHEAT: Check if we ALREADY solved this specific case ID
            if (!in_array($currentCase->getId(), $this->solvedCases)) {
                $this->score++; // Add point only if it's new
                $this->solvedCases[] = $currentCase->getId(); // Mark as solved
            }
            
            return true; // Return true so the "Correct!" message still shows
        }
        
        return false;
    }
    
    public function nextCase() {
        if ($this->currentCaseIndex < count($this->cases)) {
            $this->currentCaseIndex++;
            return true;
        }
        return false;
    }
    
    public function previousCase() {
        if ($this->currentCaseIndex > 0) {
            $this->currentCaseIndex--;
            return true;
        }
        return false;
    }
    
    public function getScore() { return $this->score; }
    public function getTotalCases() { return count($this->cases); }
    public function getCurrentCaseNumber() { return $this->currentCaseIndex + 1; }
    public function isGameComplete() { return $this->currentCaseIndex >= count($this->cases); }
    
    public function resetGame() {
        $this->currentCaseIndex = 0;
        $this->score = 0;
        $this->solvedCases = []; // 🗑️ Clear the solved list on reset
        $this->initializeCases();
    }
}
?>