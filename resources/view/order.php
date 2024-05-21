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
            ?>
            <div class="carSelected">
                <img src='<?php echo $car->getImgSrc(); ?>'>
                <div style="display: flex; flex-direction: row; justify-content: center; gap: 10px;"><h4>Licence Plate:</h4> <p><?php echo $car->getLicencePlate(); ?></p></div>
                <div style="display: flex; flex-direction: row; justify-content: center; gap: 10px;"><p><h4>Name:</h4> <?php echo $car->getName(); ?></p></div>
                <div style="display: flex; flex-direction: row; justify-content: center; gap: 10px;"><p><h4>Brand:</h4> <?php echo $car->getBrand(); ?></p></div>
                <div style="display: flex; flex-direction: row; justify-content: center; gap: 10px;"><p><h4>Category:</h4> <?php echo $car->getCategory(); ?></p></div>
                <div style="display: flex; flex-direction: row; justify-content: center; gap: 10px;"><p><h4>Seats:</h4> <?php echo $car->getSeats(); ?></p></div>
                <div style="display: flex; flex-direction: row; justify-content: center; gap: 10px;"><p><h4>Transmission:</h4> <?php echo $car->getTransmission(); ?></p></div>
                <div style="display: flex; flex-direction: row; justify-content: center; gap: 10px;"><p><h4>Price:</h4> <?php echo $car->getPrice(); ?>$</p></div>
            </div>
            <form action="/project/order" method="post">
                <?php if (isset($_GET["err"])) {
                    if ($_GET["err"] == "Contact") 
                        echo "<h3 style='color: red'> invalid contact </h3>";
                    else 
                        echo "<h3 style='color: red'> car is taken </h3>";
                } ?>
                <select name="pickupLocation">
                    <?php 
                        if ($req["pickupLocation"] == "Tirana International Airport") 
                            echo "<option value='Tirana International Airport' selected>Tirana International Airport</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Tirana International Airport</option>";
                        
                        if ($req["pickupLocation"] == "Epoka University") 
                            echo "<option value='Epoka University' selected>Epoka University</option>";
                        else 
                            echo "<option value='Epoka University'>Epoka University</option>";

                        if ($req["pickupLocation"] == "Other") 
                            echo "<option value='Other' selected>Other</option>";
                        else 
                            echo "<option value='Other'>Other</option>";
                    ?>
                </select>
                <select name="dropOffLocation">
                    <?php 
                        if ($req["dropOffLocation"] == "Tirana International Airport") 
                            echo "<option value='Tirana International Airport' selected>Tirana International Airport</option>";
                        else 
                            echo "<option value='Tirana International Airport'>Tirana International Airport</option>";
                        
                        if ($req["dropOffLocation"] == "Epoka University") 
                            echo "<option value='Epoka University' selected>Epoka University</option>";
                        else 
                            echo "<option value='Epoka University'>Epoka University</option>";

                        if ($req["dropOffLocation"] == "Other") 
                            echo "<option value='Other' selected>Other</option>";
                        else 
                            echo "<option value='Other'>Other</option>";
                    ?>
                </select>
                <input type="date" name="pickupDate" value="<?php echo $req["pickupDate"]; ?>">
                <input type="date" name="dropOffDate" value="<?php echo $req["dropOffDate"]; ?>">
                <input type="text" name="contact" placeholder="contact">
                <input type="submit" value="order">
                <input style="visibility: hidden;" type="text" name="plate" value="<?php echo $car->getLicencePlate(); ?>">
            </form>
        <?php include_once __DIR__."/templates/footer.html"; ?>
    </body>
</html>