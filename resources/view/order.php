<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/project/resources/css/styleOrder.css"">
        <title>Epoka Car Rental</title>
    </head>
    <body>
        <?php include_once __DIR__."/templates/header.html"; ?>
            <?php 
                session_start();
                $car = $_SESSION["selectedCar"];
                $req = $_SESSION["form"];

                if (isset($_GET["err"])) {
                    if ($_GET["err"] == "Contact") 
                        echo "<h3> invalid contact </h3>";
                    else 
                        echo "<h3> car is taken </h3>";
                } 
            ?>
            <div>
                <img src='<?php echo $car->getImgSrc(); ?>'>
                <p><?php echo $car->getLicencePlate(); ?></p>
                <p><?php echo $car->getName(); ?></p>
                <p><?php echo $car->getBrand(); ?></p>
                <p><?php echo $car->getCategory(); ?></p>
                <p><?php echo $car->getSeats(); ?></p>
                <p><?php echo $car->getTransmission(); ?></p>
                <p><?php echo $car->getPrice(); ?></p>
            </div>
            <form action="/project/order" method="post">
                <select name="pickupLocation">
                    <?php 
                        if ($req["pickupLocation"] == "Tirana International Airport") 
                            echo "<option value='Tirana International Airport' selected>Tirana International Airport</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Tirana International Airport</option>";
                        
                        if ($req["pickupLocation"] == "Epoka University") 
                            echo "<option value='Tirana International Airport' selected>Epoka University</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Epoka University</option>";

                        if ($req["pickupLocation"] == "Other") 
                            echo "<option value='Tirana International Airport' selected>Other</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Other</option>";
                    ?>
                </select>
                <select name="dropOffLocation">
                    <?php 
                        if ($req["dropOffLocation"] == "Tirana International Airport") 
                            echo "<option value='Tirana International Airport' selected>Tirana International Airport</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Tirana International Airport</option>";
                        
                        if ($req["dropOffLocation"] == "Epoka University") 
                            echo "<option value='Tirana International Airport' selected>Epoka University</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Epoka University</option>";

                        if ($req["dropOffLocation"] == "Other") 
                            echo "<option value='Tirana International Airport' selected>Other</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Other</option>";
                    ?>
                </select>
                <input type="date" name="pickupDate" value="<?php echo $req["pickupDate"]; ?>">
                <input type="date" name="dropOffDate" value="<?php echo $req["dropOffDate"]; ?>">
                <input type="text" name="contact">
                <input type="submit" value="order">
                <input style="visibility: hidden;" type="text" name="plate" value="<?php echo $car->getLicencePlate(); ?>">
            </form>
        <?php include_once __DIR__."/templates/footer.html"; ?>
    </body>
</html>