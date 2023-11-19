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

// Fetch events from the backend
fetch("getEvents.php")
  .then((response) => response.json())
  .then((data) => {
    // Generate cards based on the fetched data
    const eventCardsContainer = document.getElementById("eventCards");
    data.forEach((event) => {
      const card = document.createElement("div");
      card.className = "card";
      const cardHeader = document.createElement("div");
      cardHeader.className = "card-header";
      cardHeader.innerHTML = `
                        <h2>${event.title}</h2>
                        <p>Start Date: ${event.start_date}</p>
                        <p>Start Time: ${event.start_time}</p>
                        <p>End Time: ${event.end_time}</p>
                        <p>Location: ${event.location}</p>
                    `;
      card.appendChild(cardHeader);
      eventCardsContainer.appendChild(card);
    });
  })
  .catch((error) => console.error("Error fetching events:", error));
