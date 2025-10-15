// Get event_id from URL and set hidden input
const urlParams = new URLSearchParams(window.location.search);
const eventId = urlParams.get('event_id');
document.getElementById('event_id').value = eventId;

// Handle form submission
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('php_files/event_register.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(msg => alert(msg))
    .catch(err => alert("Error registering."));
});
