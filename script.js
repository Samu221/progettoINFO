
    // Inizializza mostrando solo il form di accesso
    document.getElementById('loginForm').classList.add('active');

    function showRegistrationForm() {
      document.getElementById('loginForm').classList.remove('active');
      document.getElementById('registrationForm').classList.add('active');
    }

    function showLoginForm() {
      document.getElementById('registrationForm').classList.remove('active');
      document.getElementById('loginForm').classList.add('active');
    }
