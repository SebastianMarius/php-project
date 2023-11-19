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
// ... your existing code ...

// Fetch events from the backend
// ... your existing code ...

// Fetch events from the backend
// ... your existing code ...

// Fetch events from the backend
// ... your existing code ...

// Fetch events from the backend
fetch("getEvents.php")
  .then((response) => response.json())
  .then((data) => {
    // Generate cards based on the fetched data
    const eventCardsContainer = document.getElementById("eventCards");
    data.forEach((event) => {
      const card = document.createElement("div");
      card.className = "card";

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

// ... rest of your existing code ...

// ... rest of your existing code ...

// ... rest of your existing code ...

// ... rest of your existing code ...
