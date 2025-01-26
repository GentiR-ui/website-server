document.getElementById('register').addEventListener('submit', function(event) {
    let valid = true;
    const password = document.getElementById('register-password').value;
    const retypePassword = document.getElementById('register-retype-password').value;
    const passwordError = document.createElement('div');
    const retypePasswordError = document.createElement('div');

    passwordError.style.color = 'red';
    retypePasswordError.style.color = 'red';

    // Remove previous error messages
    const previousPasswordError = document.getElementById('password-error');
    const previousRetypePasswordError = document.getElementById('retype-password-error');
    if (previousPasswordError) previousPasswordError.remove();
    if (previousRetypePasswordError) previousRetypePasswordError.remove();

    // Validate password
    const passwordPattern = /^(?=.*[A-Z])(?=.*\W)(?=.*\d).{8,16}$/;
    if (!passwordPattern.test(password)) {
        passwordError.id = 'password-error';
        passwordError.innerText = 'Password must be 8-16 characters, include a symbol, number and a capital letter';
        document.getElementById('register-password').parentNode.appendChild(passwordError);
        valid = false;
    }

    // Validate retype password
    if (password !== retypePassword) {
        retypePasswordError.id = 'retype-password-error';
        retypePasswordError.innerText = 'Passwords do not match';
        document.getElementById('register-retype-password').parentNode.appendChild(retypePasswordError);
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }


});