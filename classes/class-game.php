<?php
class Game {
    private $cases = [];
    private $currentCaseIndex = 0;
    private $score = 0;
    private $solvedCases = []; 
    
    public function __construct() {
        $this->initializeCases();
    }
    
    private function initializeCases() {
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
        
        if ($currentCase && $currentCase->checkAnswer($answer)) {
            
            if (!in_array($currentCase->getId(), $this->solvedCases)) {
                $this->score++;
                $this->solvedCases[] = $currentCase->getId();
            }
            
            return true;
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
        $this->solvedCases = [];
        $this->initializeCases();
    }
}
?>