<?php

session_start();
if(!isset($_SESSION["username"]))
{
    header("LOCATION: index.php");
}

require_once("DBconnection.php");

$carsql= "SELECT * FROM Cars";
$carresult = mysqli_query($conn,$carsql);

$per_cpage = 8;
$total_cresults = mysqli_num_rows($carresult);
$num_cpages = ceil($total_cresults / $per_cpage);

if(isset($_POST['cardeletion']))
{
  $todelete = $_POST["cartodelete"];
  deleteCar($todelete,$conn);
  unset($_POST['cardeletion']);
  
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
    <title>Epoka car rental-Admin-Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="adminpgstyles/sbuttons.css">
</head>

<body style="background-image: url('adminpgstyles/carorders-bg.jpg'); ">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



<div>
<?php

$carsql2 = "SELECT * FROM Cars ORDER BY licencePlate DESC LIMIT $cstart,$per_cpage";
$carresult2 = mysqli_query($conn,$carsql2);

echo "<table class='table table-dark'>";
echo  "<tr><th>License Plate</th><th>Name</th><th>Brand</th><th>Seats</th><th>Transmission</th><th>Category</th><th>Price</th><th>Image Source</th><th></th><th></th><</tr>";
while($crow=mysqli_fetch_array($carresult2))
{
  echo "<tr>";
  echo "<td>".$crow["licencePlate"]."</td>";
  echo "<td>".$crow["name"]."</td>";
  echo "<td>".$crow["brand"]."</td>";
  echo "<td>".$crow["category"]."</td>";
  echo "<td>".$crow["seats"]."</td>";
  echo "<td>".$crow["transmission"]."</td>";
  echo "<td>".$crow["price"]."</td>";
  echo "<td>".$crow["imgSrc"]."</td>";
  echo '<td><form action="editcar.php" method="POST"> <input hidden type="text" name="platetoedit" value='.$crow["licencePlate"].'> 
                                                      <input hidden type="text" name="nametoedit" value='.$crow["name"].'>
                                                      <input hidden type="text" name="brandtoedit" value='.$crow["brand"].'>
                                                      <input hidden type="text" name="categorytoedit" value='.$crow["category"].'>
                                                      <input hidden type="number" name="seatstoedit" value='.$crow["seats"].'>
                                                      <input hidden type="text" name="transmissiontoedit" value='.$crow["transmission"].'>
                                                      <input hidden type="text" name="pricetoedit" value='.$crow["price"].'>
                                                      <input hidden type="text" name="imgtoedit" value='.$crow["imgSrc"].'>
                                                      <input name="carediting" type=submit class="btn btn-sunny" value="EDIT">  </form></td>';
  echo '<td><form action="inspectcars.php?carpage='.$current_cpage.'" method="POST"> <input hidden type="text" name="cartodelete" value='.$crow["licencePlate"].'> <input name="cardeletion" type=submit class="btn btn-danger" value="DELETE">  </form></td>';
  echo "</tr>";
}
echo "</table>";

?>
</div>

<div style="text-align:center">
<?php 
for($i = 1 ; $i <= $num_cpages; $i++)
{
  echo "<a href=inspectcars.php?carpage=$i><button type='button' class='btn btn-info'>$i</button></a>";
}
?>
</div>

<div style="position:absolute; bottom:0; left:0; z-index:10;">
<a href="mainadminmenu.php?orderpage=1&carpage=1"> <button class="btn btn-fresh"> MAIN MENU </button></a>
<a href="addcar.php"> <button class="btn btn-sunny"> ADD A NEW VEHICLE </button></a>
</div> 

</body>
</html>