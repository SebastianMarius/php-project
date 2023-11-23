const storedEventData = localStorage.getItem("eventDetails");

// Parse the JSON string back into an object
const selectedEvent = JSON.parse(storedEventData);

// Now you can access the event details
console.log("Retrieved event details from localStorage:", selectedEvent);

console.log(selectedEvent);

console.log(" jgieogqjoi");
// Call the function to get a specific speaker (replace 4 with the actual speaker_id)

document.addEventListener("DOMContentLoaded", function () {
  var fileName = location.href.split("/").slice(-1);

  console.log(fileName);

  if (fileName[0] == "speakeri.php") {
    // const speaker_id = document.getElementById('')
    getSpeaker(selectedEvent?.speaker_id);
  }

  if (fileName[0] == "BileteInregistrare.php") {
    // divu_mare.style.backgroundImage = ''
  }

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

function getSpeaker(speakerId) {
  console.log(speakerId);
  // Make a GET request to your server-side endpoint or API with the speaker_id parameter
  fetch(`getSpeakers.php?speaker_id=${speakerId}`)
    .then((response) => response.json())
    .then((data) => {
      // Process the speaker data (you can update your UI here)
      console.log(data);
      const photo = document.getElementById("speaker_photo");
      photo.src = `speakers/${data.photo_url}`;

      const speaker_name = document.getElementById("speaker_name");
      speaker_name.textContent = data.name;

      const speaker_description = document.getElementById("speakerDescription");
      speaker_description.textContent = data.bio;
      console.log(speaker_description);
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
