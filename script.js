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
  closeModal();
}
