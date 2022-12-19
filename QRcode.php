<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRcode</title>
    <script src="./node_modules/qrious/dist/qrious.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&amp;display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    include "header.html"
    ?>
    <div class="headerblock"></div>
    <h1>QR code vragenlijst</h1>
    <p>Op deze pagina staat de QR code die dynamisch gelinkt is aan de vragenlijst voor het geselecteerde team. Door het getal in de URL aan te passen kan de locatie van de QR code ook aangepast worden.</p>
    <main>
        <img id="qrious">
    </main>
    <button id=questionaire>Ga naar de vragenlijst</button>

    <script type="text/javascript">
        const currentUrl = window.location.href
        const idIndex = currentUrl.indexOf("=") + 1
        teamid = currentUrl.slice(idIndex)

        const urlbase = 'http://localhost/JGM/questionaire.php?team='; 
        let questionaireURL = urlbase.concat(teamid);

        let qr = window.qr = new QRious({
        element: document.getElementById('qrious'),
        size: 250,
        value: questionaireURL
        });

        document.getElementById("questionaire").onclick = function(questionareURL) {
            location.href = questionaireURL;
        };
    </script>
    <?php include "footer.html";?>
</body>
</html>