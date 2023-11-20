<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events</title>
  <link rel="stylesheet" href="cards.css">
  <link rel="stylesheet" href="modal.css">
  <script src="script.js"></script>
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <h1>Events</h1>
      </div>
      <div class="nav-links">
        <button class="nav-button">Home</button>
        <button class="nav-button">Events</button>
        <button class="nav-button" onclick="window.location.href='about.html'">About</button>
        <button class="nav-button" onclick="window.location.href='contact.html'">Contact</button>
      </div>
      <div class="cart-icon">
        <img src="cart-icon.png" alt="Cart Icon">
      </div>
    </nav>
  </header>

  <h1>Events</h1>
  <button class="new-event-button" onclick="openModal()">New Event</button>

  <div class="cards" id="eventCards">
    <!-- Event cards will be dynamically generated here -->
  </div>

  <div id="eventModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h2>New Event</h2>
      <form id="eventForm" action="addEventToDb.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="startDate">Start Date:</label>
        <input type="date" id="startDate" name="startDate" required>

        <label for="startTime">Start Time:</label>
        <input type="time" id="startTime" name="startTime" required>

        <label for="endDate">End Date:</label>
        <input type="date" id="endDate" name="endDate" required>

        <label for="endTime">End Time:</label>
        <input type="time" id="endTime" name="endTime" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4"></textarea>

        <div style='display:flex'>
          <label for="ticketPrice" style='margin-top:16px; margin-right:5px'>Ticket Price:</label>

          <input type="text" id="ticketPrice" name="ticketPrice" required>
          <label id="priceLabel">lei</label>
        </div>


        <label>Speakers:</label>
        <?php printCheckboxOptions("speakers", "SELECT id, name FROM speakers"); ?>

        <label>Sponsors:</label>
        <?php printCheckboxOptions("sponsors", "SELECT id, name FROM sponsors"); ?>

        <label>Partners:</label>
        <?php printCheckboxOptions("partners", "SELECT id, name FROM partners"); ?>

        <label for="eventImage">Event Image:</label>
        <input type="file" id="eventImage" name="eventImage" accept="image/*">

        <button type="submit">Save Event</button>
      </form>
    </div>
  </div>

  <?php
  function printCheckboxOptions($name, $query)
  {
    $conn = new mysqli('localhost', 'root', '', 'evenimente_db');
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="checkbox-container"><input type="checkbox" id="' . $name . '_' . $row['id'] . '" name="' . $name . '[]" value="' . $row['id'] . '">';
        echo '<label for="' . $name . '_' . $row['id'] . '">' . $row['name'] . '</label></div>';
      }
    }

    $conn->close();
  }
  ?>
</body>

</html>