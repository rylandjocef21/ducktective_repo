# Technical Documentation & OOP Implementation

## 1. OOP Implementation Guide
The *Duck-tective* application is built using Object-Oriented PHP.

### A. Encapsulation
We utilize `private` access modifiers for all class properties (`$id`, `$codeSnippet`, `$score`) to prevent direct modification from outside the class. Access is controlled via public Getter methods.

### B. Abstraction
The `Game` class acts as an abstraction layer. The frontend (HTML) does not need to know *how* cases are stored or how the score is calculated; it simply interfaces with `$game->checkAnswer()`.

### C. Composition
Instead of complex inheritance trees, this project relies on **Composition**. The `Game` class *has-a* collection of `CodeCase` objects, defined in the `initializeCases()` method.

## 2. Design Decisions
* **Statelessness:** We utilize PHP Sessions (`$_SESSION`) to persist the `Game` object state across HTTP requests, mimicking a stateful application without a database.
* **Development Environment:** Developed using Visual Studio Code to utilize the integrated terminal and lightweight testing server.