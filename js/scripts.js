
document.getElementById('loginForm').addEventListener('submit', function(event) {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

      if (username === '' || password === '') {
        alert('Please fill in all fields');
        event.preventDefault();
    } else {
        // Mostrar en consola los valores ingresados
        console.log('username:', username);
        console.log('password:', password);
    }
});
