# 🦆 Duck-tective: PHP Code Breaking Game

### 🌐 Live Demo
**Play the game online here:** 
https://duck-tective21.gamer.gd/


## 1. Project Overview
**Duck-tective** is an interactive, educational web-based game designed to help beginners identify common syntax errors in PHP programming. Players take on the role of a "Code Detective," analyzing snippets of buggy code to find missing symbols, keywords, or operators.

### Game Objectives
* **Win Condition:** Successfully solve all 7 cases to complete the game.
* **Lose Condition:** Incorrect guesses are tracked; the goal is to learn through trial and error.

## 2. Technology Stack
* **Language:** PHP (Object-Oriented Programming)
* **Frontend:** HTML5, CSS3, JavaScript
* **Environment:** Compatible with VS Code Local Server or XAMPP

## 3. Team Members
[Franco, Princess Jinky]: Lead Developer - Implemented Game Logic and OOP Classes.
[Remigio, Ryland Jocef]: UI/UX Designer - Designed the CSS interface, color scheme, and animations.
[Fortunato, Reimhel]: QA / Content - Created the code snippets (cases) and hints, testing.
## Other Members
Levita, Shreena
Bartolazo, Barry

## 4. How to Play
1.  **Start the Game:** The game loads the first case automatically.
2.  **Analyze the Code:** Look at the black code box. You will see a `____` blank space where code is missing.
3.  **Read the Hint:** If you are stuck, look at the yellow hint box below the code.
4.  **Submit Answer:** Type the missing symbol (e.g., `;`, `$`, `:`) into the input box and click "Check Answer".
5.  **Progress:**
    * ✅ **Correct:** You will see a success message and a "Next Case" button.
    * ❌ **Incorrect:** You will see an error message. Try again!
6.  **Reset:** You can reset the game progress at any time using the "Reset Game" button.

## 5. How to Run the Program

### Option A: Using Visual Studio Code (Recommended)
1.  Open this folder in **VS Code**.
2.  Open a Terminal (`Ctrl + ` `).
3.  Run the built-in PHP server command:
    ```bash
    php -S localhost:8000
    ```
4.  Open your browser to: `http://localhost:8000`

### Option B: Using XAMPP/WAMP
1.  Move this folder to your `htdocs` directory.
2.  Start Apache.
3.  Navigate to `http://localhost/duck-tective-repo/index.php`

## 6. Controls
* Type the missing character in the input box.
* Press **Enter** or click **Check Answer**.