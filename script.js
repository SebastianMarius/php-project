// Add this to your existing script.js file or include it in your HTML

function openModal() {
  document.getElementById("eventModal").style.display = "block";
}

function closeModal() {
  document.getElementById("eventModal").style.display = "none";
}

function saveEvent() {
  // Implement your logic to save the event data
  // For now, let's just close the modal
  document.getElementById("eventForm").submit();
  closeModal();
}

const cardClick = (event) => {
  const eventString = JSON.stringify(event);

  // Store the event data in localStorage
  localStorage.setItem("eventDetails", eventString);

  // Now you can access the details in other parts of your application
  window.location.replace(
    "http://localhost/laburi/pls/php-project/eventData.php"
  );
  console.log("Event data stored in localStorage:", event);
};

fetch("getEvents.php")
  .then((response) => response.json())
  .then((data) => {
    // Generate cards based on the fetched data
    const eventCardsContainer = document.getElementById("eventCards");
    data.forEach((event) => {
      const card = document.createElement("div");
      card.className = "card";
      card.onclick = function () {
        cardClick(event); // Assuming cardClick expects an event ID
      };
      // Create a container for the image with its own opacity
      const imageContainer = document.createElement("div");
      imageContainer.className = "card-image-container";
      imageContainer.style.backgroundImage = `url('${event.image_path}')`;
      imageContainer.style.backgroundSize = "cover"; // Adjust as needed
      imageContainer.style.opacity = 0.5;
      imageContainer.style.height = "200px"; // Set a fixed height, adjust as needed

      // Create a container for the text content
      const textContainer = document.createElement("div");
      textContainer.className = "card-text-container";

      const cardHeader = document.createElement("div");
      cardHeader.className = "card-header";
      cardHeader.innerHTML = `
        <h2>${event.title}</h2>
        <p>Start Date: ${event.start_date}</p>
        <p>Start Time: ${event.start_time}</p>
        <p>End Time: ${event.end_time}</p>
        <p>Location: ${event.location}</p>
        <div>
            <img class="action-icons" src='./assets/edit.svg'/ onclick='openEditModal(${event.id})'>
            <img class="action-icons trash" src='./assets/delete.svg' onclick='deleteEvent(${event.id})'/>
        </div>

      
      `;

      // Append the text container to the card
      textContainer.appendChild(cardHeader);

      // Append both the image and text containers to the card
      card.appendChild(imageContainer);
      card.appendChild(textContainer);

      // Append the card to the main container
      eventCardsContainer.appendChild(card);
    });
  })
  .catch((error) => console.error("Error fetching events:", error));

const eventCards = document.querySelectorAll(".card"); // Assuming CSS selector for event cards

function deleteEvent(eventId) {
  // Perform an asynchronous POST request to deleteEvent.php
  fetch("deleteEvent.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `eventId=${eventId}`,
  })
    .then((response) => response.text())
    .then((message) => {
      window.location.reload();
      // Optionally, you can update the UI to remove the deleted event card
    })
    .catch((error) => console.error("Error deleting event:", error));
}

function fetchEventDetails(eventId) {
  // Fetch details for the specified event
  fetch(`getEventDetails.php?eventId=${eventId}`)
    .then((response) => response.json())
    .then((eventDetails) => {
      // Populate the edit form with existing data
      document.getElementById("editTitle").value = eventDetails.title;
      // Populate other form fields with existing data

      // Open the edit modal
      openEditModal();
    })
    .catch((error) => console.error("Error fetching event details:", error));
}

function saveEditedEvent() {
  // Implement your logic to save the edited event data
  // For now, let's just close the modal
  document.getElementById("editEventForm").submit();
  closeEditModal();
}
