<?php

class Car {
    private string $licencePlate;
    private string $name;
    private string $brand;
    private string $category;
    private int $seats;
    private string $transmission;
    private string $imgSrc;
    private int $price;
    private string $dateRented;
    private string $dateReturned;

    public function __construct() {
        $this->setLicencePlate("");
        $this->setName("");
        $this->setBrand("");
        $this->setCategory("");
        $this->SetSeats(0);
        $this->SetTransmission("");
        $this->setImgSrc("");
        $this->setPrice(0);
        $this->setDateRented("");
        $this->setDateReturned("");
    }

    public function setLicencePlate(string $licencePlate): void {
        $this->licencePlate = $licencePlate;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setBrand(string $brand): void {
        $this->brand = $brand;
    }

    public function setCategory(string $category): void {
        $this->category = $category;
    }
    
    public function setSeats(int $seats): void {
        $this->seats = $seats;
    }

    public function setTransmission(string $transmission): void {
        $this->transmission = $transmission;
    }

    public function setImgSrc(string $imgSrc): void {
        $this->imgSrc = $imgSrc;
    }

    public function setPrice(int $price): void {
        $this->price = $price;
    }

    public function setDateRented(string $date) : void {
        $this->dateRented = $date;
    }

    public function setDateReturned(string $date) : void {
        $this->dateReturned = $date;
    }
    
    public function getLicencePlate(): string {
        return $this->licencePlate;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getBrand(): string {
        return $this->brand;
    }

    public function getCategory(): string {
        return $this->category;
    }
    
    public function getSeats(): int {
        return $this->seats;
    }

    public function getTransmission(): string {
        return $this->transmission;
    }

    public function getImgSrc(): string {
        return $this->imgSrc;
    }
    
    public function getPrice(): int {
        return $this->price;
    }

    public function getDateRented() : string {
        return $this->dateRented;
    }

    public function getDateReturned() : string {
        return $this->dateReturned;
    }

    public function carToHTML() : void {
        echo "<div class='car'>";
        echo "<img src='".$this->getImgSrc()."'>";
        echo "<p>".$this->getName()."</p>";
        echo "<p>".$this->getBrand()."</p>";
        echo "<p>".$this->getCategory()."</p>";
        echo "<p>".$this->getTransmission()."</p>";
        echo "<p>".$this->getPrice()."</p>";
        echo "<input type='button' value='select' id='".$this->getLicencePlate()."'>";
        echo "<script> document.getElementById('".$this->getLicencePlate()."').addEventListener('click', function() { window.location.href = './car?plate=".$this->getLicencePlate()."'}) </script>";
        echo "</div>";
    }
}

?>