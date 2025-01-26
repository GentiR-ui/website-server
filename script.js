// Elements
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const showRegister = document.getElementById('show-register');
const showLogin = document.getElementById('show-login');

// Form Switch
showRegister.addEventListener('click', () => {
    loginForm.classList.add('hidden');
    registerForm.classList.remove('hidden');
});

showLogin.addEventListener('click', () => {
    registerForm.classList.add('hidden');
    loginForm.classList.remove('hidden');
});

// Validation for Register Form
document.getElementById('register').addEventListener('submit', (e) => {
    e.preventDefault();

    const name = document.getElementById('register-name').value;
    const surname = document.getElementById('register-surname').value;
    const country = document.getElementById('register-country').value;
    const phone = document.getElementById('register-phone').value;
    const email = document.getElementById('register-email').value;
    const password = document.getElementById('register-password').value;
    const retypePassword = document.getElementById('register-retype-password').value;

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.{8,16})/;
    const phoneRegex = /^[0-9]{10}$/; // Phone number validation (10 digits)

    // Validation
    if (!name || !surname || !country || !phone || !email || !password || !retypePassword) {
        alert('Please fill all the fields.');
        return;
    }

    if (!emailRegex.test(email)) {
        alert('Please enter a valid email.');
        return;
    }

    if (!passwordRegex.test(password)) {
        alert('Password must be 8-16 characters, include a symbol, and a capital letter.');
        return;
    }

    if (password !== retypePassword) {
        alert('Passwords do not match.');
        return;
    }

    if (!phoneRegex.test(phone)) {
        alert('Please enter a valid phone number (10 digits).');
        return;
    }

    alert('Registration successful!');
});
