<?php

class Db {
    private string $servername; 
    private string $username; 
    private string $password; 
    private string $dbname; 
    private mysqli $connection;

    public function __construct(string $servername, string $username, string $password, string $dbname) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        $this->connection = new mysqli($servername, $username, $password, $dbname);
    }

    public function getCars(): array {
        return $this->connection->query("SELECT * FROM Cars")->fetch_all(MYSQLI_ASSOC);
    }

    public function getDateBusy(string $licencePlate): array {
        $statement = "SELECT dateRented, dateReturned FROM Orders WHERE ID = (SELECT MAX(ID) FROM Orders) AND licencePlate = '$licencePlate'";
        return $this->connection->query($statement)->fetch_all(MYSQLI_ASSOC);
    }

    public function placeOrder(string $dateRented, string $dateReturned, string $pickupLocation, string $dropoffLocation, string $licencePlate, string $contact): void {
        $statement = "INSERT INTO Orders(dateRented, dateReturned, pickupLocation, dropoffLocation, contact, licencePlate) 
            VALUES ('$dateRented', '$dateReturned', '$pickupLocation', '$dropoffLocation', '$contact', '$licencePlate')";
        $this->connection->query($statement);
    }
}

?>