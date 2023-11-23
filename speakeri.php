<!DOCTYPE html>
<html lang="en">

<head>
    <script src="eventData.js"> </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event</title>
    <link rel="stylesheet" href="eventData.css">
    <link rel="stylesheet" href="addSpeakerModal.css">

    <script>
        // Function to open the modal
        function openModal() {
            document.getElementById('addSpeakerModal').style.display = 'block';
            document.getElementById('container').style.display = 'none';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('addSpeakerModal').style.display = 'none';
            document.getElementById('container').style.display = 'flex';

        }

        // Function to add a new speaker
        function addSpeaker() {
            // You can implement the logic to add the speaker to your data structure here
            // For now, let's just close the modal
            closeModal();
            document.getElementById('container').style.display = 'flex';
            e.preventDefault();
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'addSpeaker.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log(xhr.responseText);
                    // Optionally, you can update the UI or perform other actions on success
                    closeModal();
                }
            };
            xhr.send(formData);

        }
    </script>

</head>

<body>

    <header>
        <h1 class="event_title" style="color: #fff;">
            La vanatoare de ursi
        </h1>
    </header>

    <nav>
        <a href="http://localhost/laburi/pls/php-project/despre.html" class="active">Despre</a>
        <a href="http://localhost/laburi/pls/php-project/Agenda.html">Agenda</a>
        <a href="http://localhost/laburi/pls/php-project/speakeri.html">Speakers</a>
        <a href="http://localhost/laburi/pls/php-project/parteneriSiSponsori.html">Parteneri & Sponsori</a>
        <a href="http://localhost/laburi/pls/php-project/contactEvent.html">Contact</a>
        <a href="http://localhost/laburi/pls/php-project/BileteInregistrare.php">Bilete-inregistrare</a>
    </nav>

    <!-- Your page content goes here -->

    <div style="display: flex; justify-content: center; margin-top:20px">
        <button style="margin-left: auto; margin-right: auto;" onclick="openModal()">Add speaker</button>
    </div>

    <div id="addSpeakerModal" class="modal">
        <form>
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Add Speaker</h2>
                <form id="speakerForm">
                    <label for="speakerName">Speaker Name:</label>
                    <input type="text" id="speakerName" name="speakerName" required>

                    <label for="speakerDescription">Speaker Description:</label>
                    <textarea id="speakerDescription" name="speakerDescription" rows="4" required></textarea>

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
                <img src="assets/calendar.png" width="80px">
                <p>Popescu Ion</p>

            </div>
            <p class="doi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti iure voluptate blanditiis.
                Minus eaque
                nostrum soluta cum, autem atque laborum exercitationem deleniti velit debitis dignissimos eius. Modi id
                nihil quo!</p>
            <div class="socialLinks">
                <a href="">facebook</a>
                <a href="">instagram</a>
            </div>
        </div>


        <div class="div1">
            <div class="details">
                <img src="assets/calendar.png" width="80px">
                <p>Popescu Ion</p>

            </div>
            <p class="doi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti iure voluptate blanditiis.
                Minus eaque
                nostrum soluta cum, autem atque laborum exercitationem deleniti velit debitis dignissimos eius. Modi id
                nihil quo!</p>
            <div class="socialLinks">
                <a href="">facebook</a>
                <a href="">instagram</a>
            </div>
        </div>



        <div class="div1">
            <div class="details">
                <img src="assets/calendar.png" width="80px">
                <p>Popescu Ion</p>

            </div>
            <p class="doi">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti iure voluptate blanditiis.
                Minus eaque
                nostrum soluta cum, autem atque laborum exercitationem deleniti velit debitis dignissimos eius. Modi id
                nihil quo!</p>
            <div class="socialLinks">
                <a href="">facebook</a>
                <a href="">instagram</a>
            </div>
        </div>
    </div>


</body>

</html>