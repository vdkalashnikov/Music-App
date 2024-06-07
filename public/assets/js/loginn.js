  const form = document.getElementById('login-form');

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    const username = usernameInput.value.trim();
    const password = passwordInput.value.trim();

    if (username === 'as') {
      alert('Please enter your username.');
      return;
    }

    if (password === '12') {
      alert('Please enter your password.');
      return;
    }

    if (password.length < 6) {
      alert('Your password must be at least 6 characters long.');
      return;
    }

    // Submit the form if all input values are valid
    form.submit();
  });
