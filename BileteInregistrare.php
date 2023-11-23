<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event</title>
    <link rel="stylesheet" href="eventData.css">
    <link rel="stylesheet" href="eventNavbar.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <!-- ... (your existing HTML code) -->

    <script>
        const storedEventData = localStorage.getItem("eventDetails");



        // This function initializes Stripe and creates a Checkout Session
        function handleCheckout() {
            // Initialize Stripe with your publishable key
            var stripe = Stripe('pk_test_51OFNsJIkmtRoILPulA6StKx1HkDgKUUXYNQAW0dCKZer11AozWXC1WJhdznW9iRH3yROp00cvNXNSZNcgyOZKLCc00CK6ZYNH8');

            // Get the quantity from the input field
            var quantity = document.getElementById('quantity').value;

            var price_id = localStorage.getItem('eventDetails');

            var priceInfo = JSON.parse(price_id);

            const priceId = priceInfo.stripe_price_id;
            console.log(priceId, ' ', quantity)

            // Make an AJAX request to create a Checkout Session
            fetch('create-checkout-session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ quantity: quantity, priceId: priceId }),
            })
                .then(response => {
                    if (!response.ok) {
                        console.error('HTTP error! Status:', response.status, ' ', priceId, 'quantity', quantity);
                        return response.text().then(text => {
                            console.error('Response body:', text);
                            throw new Error('HTTP error');
                        });
                    }
                    return response.json();
                })
                .then(session => {
                    // Redirect to Stripe Checkout if a valid session ID is received
                    if (session.id) {
                        stripe.redirectToCheckout({ sessionId: session.id });
                    } else {
                        console.error('Invalid session ID received from the server:', session);
                        alert('An error occurred. Please try again later.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again later.');
                });
        }
    </script>

</head>

<body>

    <header>
        <h1 class="event_title" style="color:#fff">
            La vanatoare de ursi
        </h1>
    </header>

    <nav>
        <a href="http://localhost/laburi/pls/php-project/despre.html" class="active">Despre</a>
        <a href="http://localhost/laburi/pls/php-project/speakeri.php">Speakers</a>
        <a href="http://localhost/laburi/pls/php-project/parteneriSiSponsori.html">Parteneri & Sponsori</a>
        <a href="http://localhost/laburi/pls/php-project/BileteInregistrare.php">Bilete-inregistrare</a>
    </nav>
    <div class="container">
        <div class="div1" id='div1' style="background-color: aqua;">
            <img src="assets/hour.png" alt="Product Image">
            <div class="product-details">
                <h2>Product Name</h2>
                <p>Product Description</p>
                <form method="post">

                    <input type="number" id="quantity" name="quantity" min="1" max="10" value="1">
                    <input type="button" value="Buy" onclick="handleCheckout()">

                </form>
            </div>
        </div>
    </div>
</body>

</html>