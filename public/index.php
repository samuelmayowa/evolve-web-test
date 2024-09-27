<?php
require_once 'controller.php';

// Initialize the controller and retrieve necessary data
$controller = new Controller();
$hospitals = $controller->getHospitals();
$purposes = $controller->getPurposes();
$currentLocation = "Montreal"; // Dummy user location for demonstration

// Get the minimum appointment time for the datetime-local input
$minDateTime = date('Y-m-d\TH:i');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evolve Hospital Appointment</title>
  <link rel="stylesheet" href="styles.css">
  <script src="script.js" defer></script> <!-- Link to the new JavaScript file -->
</head>

<body>
  <div class="container">
    <h1>Evolve Web Hospital Appointment Booking: A Test</h1>

    <h2>Check Appointment Availability</h2>
    <form id="appointment-form">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>

      <label for="address">Your Address/Location:</label>
      <input type="text" id="address" name="address" required>

      <label for="hospital">Select Hospital:</label>
      <select id="hospital" name="hospital_id" required onchange="updateDistance()">
        <?php foreach ($hospitals as $hospital): ?>
          <option value="<?php echo htmlspecialchars($hospital['id'], ENT_QUOTES); ?>" data-location="<?php echo htmlspecialchars($hospital['location'], ENT_QUOTES); ?>">
            <?php echo htmlspecialchars($hospital['name'], ENT_QUOTES); ?> - Estimated Wait Time: <?php echo htmlspecialchars($hospital['wait_time'], ENT_QUOTES); ?> mins
          </option>
        <?php endforeach; ?>
      </select>

      <label for="appointment_time">Appointment Time:</label>
      <input type="datetime-local" id="appointment_time" name="appointment_time" required min="<?php echo $minDateTime; ?>">

      <label for="patient_name">Patient Name:</label>
      <input type="text" id="patient_name" name="patient_name" required>

      <label for="purpose">Purpose of Visit:</label>
      <select id="purpose" name="purpose" required>
        <?php foreach ($purposes as $purpose): ?>
          <option value="<?php echo htmlspecialchars($purpose['id'], ENT_QUOTES); ?>"><?php echo htmlspecialchars($purpose['purpose'], ENT_QUOTES); ?></option>
        <?php endforeach; ?>
      </select>

      <label for="transport">Mode of Transport:</label>
      <select id="transport" name="transport" required>
        <option value="Driving">Driving</option>
        <option value="Bus">Bus</option>
        <option value="Train">Train</option>
      </select>

      <button type="button" onclick="if (validateForm()) confirmBooking()">Continue to Confirm</button>
    </form>

    <div id="successModal" class="modal">
      <div class="modal-content">
        <span onclick="document.getElementById('successModal').style.display='none'" style="cursor:pointer; float:right;">&times;</span>
        <h2>Confirm Your Appointment</h2>
        <p id="confirmMessage"></p>
        <p id="hospitalDetails"></p>
        <p id="distance"></p>
        <p id="trafficCondition"></p>
        <p id="weatherCondition"></p>
        <p id="waitTime"></p>
        <hr>
        <strong>Your printable appointment pass:</strong>
        <p id="appointmentPass" style="font-size: 20px; color: #0073e6;"></p>
        <button onclick="finalizeAndPrint()" style="margin-left: 10px;">Finalize/Print Confirmation</button>
      </div>
    </div>
  </div>
</body>

</html>