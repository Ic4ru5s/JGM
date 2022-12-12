<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRcode</title>
    <script src="./node_modules/qrious/dist/qrious.js"></script>
</head>
<body>
    <main>
        <img id="qrious">
    </main>
    <button id=questionaire>Ga naar de vragenlijst</button>

    <script type="text/javascript">
        function getCurrentURL () {
            return window.location.href
        }

        const currentUrl = getCurrentURL()
        const idIndex = currentUrl.indexOf("=") + 1
        teamid = currentUrl.slice(idIndex)

        const urlbase = 'http://localhost/JGM/questionaire.php?team='; // change this when uploading or make dynamic
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
</body>
</html>