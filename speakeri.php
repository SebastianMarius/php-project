<!DOCTYPE html>
<html lang="en">

<head>
    <script src="eventData.js"> </script>
    <script src="getSpeakers.js"> </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event</title>
    <link rel="stylesheet" href="eventData.css">
    <link rel="stylesheet" href="addSpeakerModal.css">


</head>

<body>

    <header>
        <h1 class="event_title" style="color: #fff;">
            La vanatoare de ursi
        </h1>
    </header>

    <nav>
        <a href="http://localhost/laburi/pls/php-project/despre.html" class="active">Despre</a>
        <a href="http://localhost/laburi/pls/php-project/speakeri.php">Speakers</a>
        <a href="http://localhost/laburi/pls/php-project/parteneriSiSponsori.html">Parteneri & Sponsori</a>
        <a href="http://localhost/laburi/pls/php-project/BileteInregistrare.php">Bilete-inregistrare</a>
    </nav>

    <!-- Your page content goes here -->


    <div id="addSpeakerModal" class="modal">
        <form>
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Add Speaker</h2>
                <form id="speakerForm">
                    <label for="speakerName">Speaker Name:</label>
                    <input type="text" id="speakerName" name="speakerName" required>

                    <label for="speakerDescription">Speaker Description:</label>
                    <textarea id="" name="speakerDescription" rows="4" required></textarea>

                    <label for="speakerPhoto">Speaker Photo:</label>
                    <input type="file" id="speakerPhoto" name="speakerPhoto" accept="image/*" required>

                    <button type="submit" onclick="addSpeaker()">Add Speaker</button>
                </form>
            </div>
        </form>
    </div>

    <div class="container" id="container">

        <div class="div1">
            <div class="details">
                <img id="speaker_photo" src="assets/calendar.png" width="80px">
                <p id='speaker_name'>Popescu Ion</p>

            </div>
            <p class="doi" id='speakerDescription'>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti
            </p>

        </div>

    </div>


</body>

</html>