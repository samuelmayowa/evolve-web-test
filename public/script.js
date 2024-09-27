// Form validation function for booking an appointment
function validateForm() {
    const email = document.getElementById('email').value.trim();
    const appointmentTime = new Date(document.getElementById('appointment_time').value);
    const currentDate = new Date();
    const address = document.getElementById('address').value.trim();
    const patientName = document.getElementById('patient_name').value.trim();

    // Validate email format with a robust regular expression
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address.');
        return false;
    }

    // Prevent appointment from being booked in the past (with a slight tolerance for milliseconds difference)
    if (appointmentTime.getTime() <= currentDate.getTime()) {
        alert('Appointment time cannot be in the past. Please select a valid future date.');
        return false;
    }

    // Validate address and patient name to prevent invalid characters
    const invalidChars = /[<>\/\\]/;
    if (invalidChars.test(address) || invalidChars.test(patientName)) {
        alert('Invalid characters detected in the address or patient name. Avoid using <, >, /, \\.');
        return false;
    }

    // All validations passed successfully
    return true;
}

// Function to update distance, traffic, and weather conditions based on user input
function updateDistance() {
    const selectedHospital = document.getElementById('hospital').selectedOptions[0];
    const hospitalLocation = selectedHospital.getAttribute('data-location');
    const userAddress = document.getElementById('address').value.trim();

    if (!userAddress) {
        alert('Please enter your address to calculate the distance.');
        return;
    }

    // Simulate distance calculation (a real system would involve geolocation APIs)
    const distance = Math.floor(Math.random() * 10) + 1; // Simulated distance in km
    document.getElementById('distance').innerText = `Distance from your location to ${selectedHospital.text}: ${distance} km`;

    // Simulate traffic and weather conditions (real-world APIs should be used here)
    document.getElementById('trafficCondition').innerText = 'Traffic Condition: Moderate';
    document.getElementById('weatherCondition').innerText = 'Weather Condition: Sunny, 22°C';

    // Simulate wait time calculation
    const waitTime = Math.floor(Math.random() * 60); // Simulated wait time in minutes
    document.getElementById('waitTime').innerText = `Expected Wait Time: ${waitTime} mins`;
}

// Function to confirm booking and display details in the success modal
function confirmBooking() {
    const selectedHospital = document.getElementById('hospital').selectedOptions[0];
    const hospitalName = selectedHospital.text;

    if (!validateForm()) {
        return; // Abort if form validation fails
    }

    // Update the hospital details in the modal and calculate distance/conditions
    document.getElementById('hospitalDetails').innerText = `You are about to book an appointment at ${hospitalName}.`;
    updateDistance();

    // Display the success modal
    document.getElementById('successModal').style.display = 'block';
}

// Function to finalize the booking and print the appointment confirmation
function finalizeAndPrint() {
    const printWindow = window.open('', '_blank');

    // Generate a unique appointment number
    const appointmentNumber = `APT-${Math.floor(Math.random() * 10000)}`;
    const status = "Confirmed";

    // Set the appointment pass number in the modal
    document.getElementById('appointmentPass').innerText = appointmentNumber;

    // Create printable content for the new window
    printWindow.document.write(`
        <html>
        <head>
            <title>Appointment Confirmation</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                h1 { color: #0073e6; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #0073e6; color: white; }
                strong { color: #0073e6; }
            </style>
        </head>
        <body>
            <h1>Appointment Confirmation</h1>
            <table>
                <tr><th>Detail</th><th>Information</th></tr>
                <tr><td>Status</td><td>${status}</td></tr>
                <tr><td>Hospital</td><td>${document.getElementById('hospitalDetails').innerText}</td></tr>
                <tr><td>Distance</td><td>${document.getElementById('distance').innerText}</td></tr>
                <tr><td>Traffic Condition</td><td>${document.getElementById('trafficCondition').innerText}</td></tr>
                <tr><td>Weather Condition</td><td>${document.getElementById('weatherCondition').innerText}</td></tr>
                <tr><td>Expected Wait Time</td><td>${document.getElementById('waitTime').innerText}</td></tr>
                <tr><td>Appointment Pass</td><td>${appointmentNumber}</td></tr>
            </table>
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.print(); // Trigger the browser's print dialog
}
