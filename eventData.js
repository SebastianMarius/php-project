const storedEventData = localStorage.getItem("eventDetails");

// Parse the JSON string back into an object
const selectedEvent = JSON.parse(storedEventData);

// Now you can access the event details
console.log("Retrieved event details from localStorage:", selectedEvent);

console.log(selectedEvent);

document.addEventListener("DOMContentLoaded", function () {
  const despre_second_photo = document.getElementById("despre-second-div-img");
  if (despre_second_photo) {
    console.log(selectedEvent?.image_url);
    despre_second_photo.style.backgroundImage = `url(${selectedEvent?.image_url})`;
    despre_second_photo.style.backgroundSize = "cover";
    despre_second_photo.style.backgroundPosition = "center";
    // despre_second_photo.style.background = "red";
  } else {
    console.error("Element with ID 'despre-second-div-img' not found.");
  }

  const eventTitles = document.querySelectorAll(".event_title");
  for (const eventTitle of eventTitles) {
    eventTitle.textContent = selectedEvent.title;
  }

  const eventDescription = document.getElementById("descriere");
  eventDescription.textContent = selectedEvent.description;

  const eventDate = document.getElementById("event_date");
  eventDate.textContent = selectedEvent.start_date;

  const eventHour = document.getElementById("event_hour");
  eventHour.textContent = selectedEvent.start_time;
});
