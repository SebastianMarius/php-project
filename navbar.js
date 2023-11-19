document.getElementById("navbar-container").innerHTML = getNavbarHTML();

// Function to get the HTML for the navbar component
function getNavbarHTML() {
  // You may fetch the HTML content using AJAX or include it directly as a string
  return `
    <nav class="navbar">
      <div class="logo">
        <h1>Events</h1>
      </div>
      <div class="nav-links">
        <button class="nav-button">Home</button>
        <button class="nav-button">Events</button>
        <button class="nav-button">About</button>
        <button class="nav-button">Contact</button>
      </div>
      <div class="cart-icon">
        <img src="cart-icon.png" alt="Cart Icon">
      </div>
    </nav>
  `;
}
