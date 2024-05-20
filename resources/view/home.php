<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/project/resources/css/styleHome.css">
        <title>Epoka Car Rental</title>
    </head>
    <body>
        <?php include_once __DIR__."/templates/header.html"; ?>
            <form action="filter" method="get" class="form">
                <select name="pickupLocation">
                    <option value="Tirana International Airport">Tirana International Airport</option>
                    <option value="Epoka University">Epoka University</option>
                    <option value="Other">Other</option>
                </select>
                <select name="dropOffLocation">
                    <option value="Tirana International Airport">Tirana International Airport</option>
                    <option value="Epoka University">Epoka University</option>
                    <option value="Other">Other</option>
                </select>
                <input type="date" name="pickupDate">
                <input type="date" name="dropOffDate">
                <select name="transmission">
                    <option value="Automatic">Automatic</option>
                    <option value="Manual">Manual</option>
                </select>
                <select name="category">
                    <option value="Sedan">Sedan</option>
                    <option value="SUV">SUV</option>
                    <option value="Hatchback">Hatchback</option>
                    <option value="Wagon">Wagon</option>
                </select>
                <input type="submit" value="search">
            </form>
            <div class="white-banner">
                <h2>EPOKA car rental</h2>
                <p>anywere and anytime you want</p>
                <p>open 24/7</p>
                <p>every type of vehicle you need</p>
            </div>
        <?php include_once __DIR__."/templates/footer.html"; ?>
    </body>
</html>