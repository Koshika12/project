document.querySelector('.contact-form').addEventListener('submit', function (e) {
    const name = document.querySelector('input[name="name"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const phone = document.querySelector('input[name="phone"]').value.trim();
    const eventType = document.querySelector('select[name="event_type"]').value;
    const eventDate = document.querySelector('input[name="event_date"]').value;
    const message = document.querySelector('textarea[name="message"]').value.trim();

    if (!name || !email || !phone || !eventType || !eventDate || !message) {
        e.preventDefault();
        alert('All fields are required.');
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Please enter a valid email address.');
        return;
    }

    const phoneRegex = /^[0-9]{10}$/; // Assuming 10-digit phone numbers
    if (!phoneRegex.test(phone)) {
        e.preventDefault();
        alert('Please enter a valid 10-digit phone number.');
        return;
    }
});
