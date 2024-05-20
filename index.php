<?php
    session_start();

    include_once "./classes/Db.php";
    include_once "./classes/Car.php";

    $request = $_SERVER["REQUEST_URI"];
    $env = parse_ini_file(".env");
    $cars = array();
    
    $db = new Db($env["DB_HOST"], $env["DB_USERNAME"], $env["DB_PASSWORD"], $env["DB_DATABASE"]);

    foreach ($db->getCars() as $attribute) {
        $car = new Car();

        $car->setLicencePlate($attribute["licencePlate"]);
        $car->setName($attribute["name"]);
        $car->setBrand($attribute["brand"]);
        $car->setCategory($attribute["category"]);
        $car->setSeats($attribute["seats"]);
        $car->setTransmission($attribute["transmission"]);
        $car->setImgSrc($attribute["imgSrc"]);
        $car->setPrice($attribute["price"]);

        $dates = $db->getDateBusy($car->getLicencePlate());
        if ($dates != null) {
            $car->setDateReturned($dates[0]["dateReturned"]);
            $car->setDateRented($dates[0]["dateRented"]);
        }

        array_push($cars,$car);
    }

    switch ($request) {
        case "/project/":
            require __DIR__."/resources/view/home.php";
            break;
        
        case isset($_GET["pickupLocation"]): 
            $_SESSION["cars"] = array();
            $_SESSION["form"] = array("pickupLocation" => $_GET["pickupLocation"], "dropOffLocation" => $_GET["dropOffLocation"],
                "pickupDate" => $_GET["pickupDate"], "dropOffDate" => $_GET["dropOffDate"]);
            $pickupDate = strtotime($_GET["pickupDate"]);

            foreach ($cars as $car) {
                $lastReturned = strtotime($car->getDateReturned());
                if ($_GET["pickupDate"] != "") {
                    if ($pickupDate > $lastReturned || !$lastReturned) {
                        array_push($_SESSION["cars"], $car);
                    }
                } else {
                    array_push($_SESSION["cars"], $car);
                }
            }

            require __DIR__."/resources/view/cars.php";
            break;
        
        case isset($_GET["plate"]):
            $selectedCar = null;
            foreach ($cars as $car) {
                if ($_GET["plate"] == $car->getLicencePlate()) 
                    $selectedCar = $car; 
            }

            if ($selectedCar == null) {
                http_response_code(404);
                require __DIR__."/resources/view/notFound.php";
                break;
            }

            $_SESSION["selectedCar"] = $selectedCar;
            require __DIR__."/resources/view/order.php";

            break; 
        
        case "/project/order":
            $res = array("pickupLocation" => $_POST["pickupLocation"], "dropOffLocation" => $_POST["dropOffLocation"],
                "pickupDate" => $_POST["pickupDate"], "dropOffDate" => $_POST["dropOffDate"], "plate" => $_POST["plate"], "contact" => $_POST["contact"]);

            $pattern = '/^06\d{8}$/';
            if (!preg_match('/^06\d{8}$/', $res["contact"])) {
                header("Location: /project/car?plate=".$res["plate"]."&err=Contact");
                break;
            }

            foreach ($cars as $car) {
                if ($car->getLicencePlate() == $res["plate"]) 
                    $res["selectedCar"] = $car;
            }

            if (strtotime($res["pickupDate"]) > strtotime($res["selectedCar"]->getDateReturned()) && strtotime($res["dropOffDate"]) > strtotime($res["pickupDate"])) {
                $db->placeOrder($res["pickupDate"], $res["dropOffDate"], $res["pickupLocation"], $res["dropOffLocation"], $res["plate"], $res["contact"]);
            } else {
                header("Location: /project/car?plate=".$res["plate"]."&err=Taken");
                break;
            }
            session_reset();
            header("Location: /project/");
            break;
        case "/project/cars":
            $_SESSION["cars"] = $cars;
            require __DIR__."/resources/view/cars.php";
            break;
        default:
            http_response_code(404);
            require __DIR__."/resources/view/notFound.php";
            break;
    }
?>