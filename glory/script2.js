const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

// Toggle between Login and Register forms
registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});

// Client-side Validation for Registration Form
const registrationForm = document.querySelector('.form-box.register form');
registrationForm.addEventListener('submit', (event) => {
    const emailInput = registrationForm.querySelector('input[name="regEmail"]');
    const emailValue = emailInput.value;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|org|net|edu|gov|info)$/; // Extended email validation regex

    if (!emailRegex.test(emailValue)) {
        alert('Please enter a valid email address with a proper domain (e.g., .com, .org, .net).');
        event.preventDefault(); // Stop form submission
    }
});

