<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm RPG - AUTOFARM</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>

</body>

</html>

<script>
$(document).ready(function() {
    function autoFarm() {
        request = $.ajax({
            type: "GET",
            url: "farmrpg.php",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                setTimeout(autoFarm, 61000);
                console.log(data);
            }
        });
    }

    function autoFish() {
        request = $.ajax({
            type: "GET",
            url: "farmrpg.php",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                console.log(data);
            }
        });
    }

    function explore() {
        request = $.ajax({
            type: "GET",
            url: "farmrpg.php",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            success: function(data) {
                console.log(data);
            }
        });
    }

    // autoFarm();
    // autoFish();
    explore();
})
</script>