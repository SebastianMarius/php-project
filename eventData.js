const storedEventData = localStorage.getItem("eventDetails");

// Parse the JSON string back into an object
const selectedEvent = JSON.parse(storedEventData);

// Now you can access the event details
console.log("Retrieved event details from localStorage:", selectedEvent);

// document.getElementById("eventName").textContent = selectedEvent.title;
