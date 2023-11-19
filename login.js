  function test() {
              var errorMessage = "<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>";
 
  if (errorMessage !== '') {
    console.log('Error: ' + errorMessage);
    document.getElementById('error-message').textContent = errorMessage;
 
    // Clear the error message after displaying it
    <?php unset($_SESSION['error']); ?>
  }
}