document.getElementById('loginForm')?.addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('loginUsername').value;
    const password = document.getElementById('loginPassword').value;
    
    fetch('index.php?action=login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            username: username,
            password: password,
            action: 'login'
        })
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes('Bienvenido Administrador')) {
            window.location.href = 'data.php'; // Redirigir a data.php para administradores
        } else {
            alert(data);
        }
    });
});
