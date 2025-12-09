<?php
class CodeCase {
    private $id;
    private $codeSnippet;
    private $missingPart;
    private $hint;
    
    public function __construct($id, $codeSnippet, $missingPart, $hint = "") {
        $this->id = $id;
        $this->codeSnippet = $codeSnippet;
        $this->missingPart = $missingPart;
        $this->hint = $hint;
    }
    
    public function getId() { return $this->id; }
    public function getCodeSnippet() { return $this->codeSnippet; }
    public function getMissingPart() { return $this->missingPart; }
    public function getHint() { return $this->hint; }
    
    public function checkAnswer($answer) {
        return strtolower(trim($answer)) === strtolower(trim($this->missingPart));
    }
    
    public function displayCode() {
        return str_replace($this->missingPart, "____", $this->codeSnippet);
    }
}
?>