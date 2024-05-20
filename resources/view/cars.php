<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/project/resources/css/styleCars.css">
        <title>Epoka Car Rental</title>
    </head>
    <body>
        <?php include_once __DIR__."/templates/header.html"; ?>
            <div class="cars-container">
                <?php
                    session_start();
                    foreach ($_SESSION["cars"] as $car) {
                        $car->carToHTML();
                    }
                ?>
            </div>
        <?php include_once __DIR__."/templates/footer.html"; ?>
    </body>
</html>