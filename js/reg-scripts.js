
document.getElementById('registerForm').addEventListener('submit', function(event) {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var username = document.getElementById('username').value;

    // Simple validation for email format and password length
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        event.preventDefault();
    }

    if (password.length < 6) {
        alert('Password must be at least 6 characters long.');
        event.preventDefault();
    }

    // Username must not be empty
    if (username.trim() === '') {
        alert('Please enter a username.');
        event.preventDefault();
    }
});
