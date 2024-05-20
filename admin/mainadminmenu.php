<?php  
session_start();

if(!isset($_SESSION["username"]))
{
    header("LOCATION: adminlogin.php");
}

require_once("DBconnection.php");

$sql = "SELECT * FROM Orders";
$result = mysqli_query($conn,$sql);

$per_page = 8;
$total_results = mysqli_num_rows($result);
$num_pages = ceil($total_results / $per_page);

$carsql= "SELECT * FROM Cars";
$carresult = mysqli_query($conn,$carsql);

$per_cpage = 8;
$total_cresults = mysqli_num_rows($carresult);
$num_cpages = ceil($total_cresults / $per_cpage);

if(isset($_GET["orderpage"]) && is_numeric($_GET["orderpage"]))
{
   $current_page = $_GET["orderpage"];

   if($current_page > 0 && $current_page <= $num_pages)
   {
      $start = ($current_page - 1) * $per_page;
      $end = $start + $per_page;
   }
   else
   {
     $start = 0;
     $end = $per_page;
   }
}
else
{
    $start = 0;
    $end = $per_page;
}

if(isset($_GET["carpage"]) && is_numeric($_GET["carpage"]))
{
   $current_cpage = $_GET["carpage"];

   if($current_cpage > 0 && $current_cpage <= $num_cpages)
   {
      $cstart = ($current_cpage - 1) * $per_cpage;
      $cend = $cstart + $per_cpage;
   }
   else
   {
     $cstart = 0;
     $cend = $per_cpage;
   }
}
else
{
    $cstart = 0;
    $cend = $per_cpage;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka Car rental-Admin-Main menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="adminpgstyles/sbuttons.css">
    <link rel="stylesheet" href="adminpgstyles/adminmenulayout.css">
 
</head>
<body style="background-image: url('adminpgstyles/adminmenu2-bg.jpg');">
<div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<div class="flex-container">

<div class="flex-child">

<div style="text-align:center">

<h1>Orders table</h1>

</div> 

<div>
<?php


$sql2 = "SELECT * FROM Orders ORDER BY ID DESC LIMIT $start,$per_page";
$result2 = mysqli_query($conn,$sql2);

echo "<table class='table table-dark'>";
echo  "<tr><th>OrderID</th><th>License Plate</th><th>Date Rented</th><th>Date Released</th><th>Contact</th>";
while($row=mysqli_fetch_array($result2))
{
  echo "<tr>";
  echo "<td>".$row["ID"]."</td>";
  echo "<td>".$row["licencePlate"]."</td>";
  echo "<td>".$row["dateRented"]."</td>";
  echo "<td>".$row["dateReturned"]."</td>";
  //echo "<td>".$row["pickupLocation"]."</td>";
  //echo "<td>".$row["dropoffLocation"]."</td>";
  echo "<td>".$row["contact"]."</td>";
  echo "</tr>";
}
echo "</table>";

?>
</div>

<div style="text-align:center">
<?php
for($i = 1 ; $i <= $num_pages; $i++)
{
    echo "<a href=mainadminmenu.php?orderpage=$i&carpage=$current_cpage><button class='btn btn-sky'>$i</button></a>";
}
?>
</div>

<div>
<a href="inspectorders.php?orderpage=1"> <button class="btn btn-fresh"> INSPECT ORDERS </button></a>
</div> 

</div>

<div class="flex-child">

<div style="text-align:center">

<h1>Cars table</h1>

</div>  


<div>
<?php

$carsql2 = "SELECT * FROM Cars ORDER BY licencePlate DESC LIMIT $cstart,$per_cpage";
$carresult2 = mysqli_query($conn,$carsql2);

echo "<table class='table table-dark'>";
echo  "<tr><th>License Plate</th><th>Name</th><th>Brand</th><th>Price</th></tr>";
while($crow=mysqli_fetch_array($carresult2))
{
  echo "<tr>";
  echo "<td>".$crow["licencePlate"]."</td>";
  echo "<td>".$crow["name"]."</td>";
  echo "<td>".$crow["brand"]."</td>";
  //echo "<td>".$crow["seats"]."</td>";
  //echo "<td>".$crow["transmission"]."</td>";
  echo "<td>".$crow["price"]."</td>";
  echo "</tr>";
}
echo "</table>";

?>
</div>

<div style="text-align:center">
<?php 
for($i = 1 ; $i <= $num_cpages; $i++)
{
  echo "<a href=mainadminmenu.php?orderpage=$current_page&carpage=$i><button type='button' class='btn btn-sky'>$i</button></a>";
}
?>
</div>

<div>
<a href="inspectcars.php?carpage=1"> <button class="btn btn-fresh"> INSPECT CARS </button></a>
</div> 
</div>  

</div>

<form action="logout.php" method="post">
<div style="position:absolute; bottom:0; left:0; z-index:10;">

<input hidden type="text" name="tokenval" value=<?php  echo $_SESSION['token'];   ?>> 
<input type="submit" name="logoutReq" class="btn btn-hot" value = "Log Out">

</div>
</form>

</body>
</html>

