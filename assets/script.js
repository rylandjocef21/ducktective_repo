document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus on input field
    const answerInput = document.getElementById('answer');
    if (answerInput) {
        answerInput.focus();
    }
});

// Prevent form resubmission on page refresh
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}