
<?php  

session_start();
if(!isset($_SESSION["username"]))
{
    header("LOCATION: index.php");
}


require_once("DBconnection.php");
$sql = "SELECT * FROM Orders";
$result=mysqli_query($conn,$sql);

$per_page = 8;
$total_results = mysqli_num_rows($result);
$num_pages = ceil($total_results / $per_page);


if(isset($_POST['orderdeletion']))
{
  $todelete = $_POST["todelete"];
  deleteOrder($todelete,$conn);
  unset($_POST['orderdeletion']);
  
}


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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epoka car rental-Admin-Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <link rel="stylesheet" href="adminpgstyles/sbuttons.css">
   
 
</head>
<body style = "background-image: url('adminpgstyles/ordersinspect3-bg.jpg');">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<div>
<?php

$sql2 = "SELECT * FROM Orders ORDER BY ID DESC LIMIT $start,$per_page";
$result2 = mysqli_query($conn,$sql2);

echo "<table  class='table table-dark' ";
echo  "<thead class='thead-dark'><tr><th scope='col'>OrderID</th><th scope='col'>License Plate</th><th scope='col'>Date Rented</th><th scope='col'>Date Released</th><th>Pickup Location</th><th>Dropoff Location</th><th>Contact</th><th></th></tr></thead>";
while($row=mysqli_fetch_array($result2))
{
  echo "<tr>";
  echo "<td>".$row["ID"]."</td>";
  echo "<td>".$row["licencePlate"]."</td>";
  echo "<td>".$row["dateRented"]."</td>";
  echo "<td>".$row["dateReturned"]."</td>";
  echo "<td>".$row["pickupLocation"]."</td>";
  echo "<td>".$row["dropoffLocation"]."</td>";
  echo "<td>".$row["contact"]."</td>";
  echo '<td><form action="inspectorders.php?orderpage='.$current_page.'" method="POST"> <input hidden type="text" name="todelete" value='.$row["ID"].'> <input name="orderdeletion" type=submit class="btn btn-danger" value="DELETE">  </form></td>';
  
  echo "</tr>";
}
echo "</table>";

?>
</div>

<div style="text-align:center">
<?php
for($i = 1 ; $i <= $num_pages; $i++)
{
    echo "<a href=inspectorders.php?orderpage=$i><button class='btn btn-sky'>$i</button></a>";
}
?>
</div>

<div style="position:absolute; bottom:0; left:0; z-index:10;">
<a href="mainadminmenu.php?orderpage=1&carpage=1"> <button class="btn btn-fresh"> MAIN MENU </button></a>
</div>  

</body>
</html>

