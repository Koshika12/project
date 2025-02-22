document.querySelector('.contact-form').addEventListener('submit', function (e) {
    const name = document.querySelector('input[name="name"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const phone = document.querySelector('input[name="phone"]').value.trim();
    const message = document.querySelector('textarea[name="message"]').value.trim();

    // Check if any of the required fields are empty
    if (!name || !email || !phone || !message) {
        e.preventDefault();
        alert('All fields are required.');
        return;
    }

    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        return;
    }

    // Validate phone number format (assuming 10-digit phone numbers)
    const phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(phone)) {
        e.preventDefault();
        alert('Please enter a valid 10-digit phone number.');
        return;
    }
});
