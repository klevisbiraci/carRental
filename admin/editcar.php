<?php 

session_start();
if(!isset($_SESSION["username"]))
{
    header("LOCATION: adminlogin.php");
}


include("DBconnection.php");




if(isset($_POST["carEditSubmission"]))
{
    
    
    $name_edit = mysqli_real_escape_string($conn,htmlspecialchars($_POST["nameedit"]));
    $brand_edit = mysqli_real_escape_string($conn,htmlspecialchars($_POST["brandedit"]));
    $category_edit = mysqli_real_escape_string($conn,htmlspecialchars($_POST["categoryedit"]));
    $seats_edit = $_POST["seatsedit"];
    $transmission_edit = mysqli_real_escape_string($conn,$_POST["transmissionedit"]);
    $image = $_FILES;
    $price_edit = filter_var($_POST["priceedit"], FILTER_SANITIZE_NUMBER_INT);
    $price_edit = intval($price_edit);
    
    
    //print_r($_FILES);
   
    // echo $_POST["nameedit"];
    $originalplate = $_POST["platetoedit"];
    
    editCar($conn, $originalplate, $name_edit, $brand_edit, $category_edit, $seats_edit, $transmission_edit, $price_edit, $image);
    

    unset($_POST["carEditSubmission"]);
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminpgstyles/carform.css" media="all">
    <title>Epoka Car Rental-Admin-Cars</title>
</head>
<body style="background-image: url('adminpgstyles/carform5-bg.jpg');">
   <div style="text-align: center;">
    <h1>Please be careful, you are in editing mode!</h1>
    <h3>Leave the field unchanged if you do not wish to edit it</h3>
    <h3>Pay attention to the license plate</h3>
   </div>

     <div class="page-wrapper p-t-45 p-b-50">
        <div class="wrapper wrapper--w790">
            <div class="card card-5">
                <div class="card-heading">
                    <h2 class="title">Please apply the changes below</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action = "editcar.php" enctype="multipart/form-data">
                        <div class="form-row m-b-55">
                            <div class="name">Vehicle Name</div>
                            <div class="value">
                                <div class="row row-space">
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="nameedit" value="<?php echo $_POST["nametoedit"] ?>">
                                            <label class="label--desc">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="brandedit" value="<?php echo $_POST["brandtoedit"] ?>";>
                                            <label class="label--desc">Brand</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row m-b-55">
                            <div class="name">Features</div>
                            <div class="value">
                                <div class="row row-space">
                                   
                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="number" name="seatsedit" min="1" max="100" value="<?php echo $_POST["seatstoedit"] ?>">
                                            <label class="label--desc">Seating capacity</label>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="input-group-desc">
                                            
                                            <br>
                                            <select class="input--style-5" name="transmissionedit">
                                                <?php

                                                if($_POST["transmissiontoedit"] == "Manual")
                                                {

                                                    echo '<option value="Manual" selected="true">Manual</option> 
                                                          <option value="Automatic">Automatic</option> ';
                                                }
                                                else
                                                {
                                                    echo '<option value="Manual" >Manual</option> 
                                                    <option value="Automatic" selected="true">Automatic</option> ';
                                                }
                                                                                                
                                                ?> 

                                            </select>  
                                            

                                            <label class="label--desc">Transmission type</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="name">Category</div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="categoryedit" value="<?php echo $_POST["categorytoedit"] ?>">
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-row m-b-55">
                            <div class="name">Reg.Info</div>
                            <div class="value">
                                <div class="row row-refine">
                                    <div class="col-3">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="text" name="platetoedit" readonly="true" value="<?php echo $_POST["platetoedit"] ?>">
                                            <label class="label--desc">License plate</label>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="input-group-desc">
                                            <input class="input--style-5" type="file" name="image" id="image" value="<?php echo $_POST["imgtoedit"] ?>">
                                            <label class="label--desc">New Image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                        <div class="form-row">
                        <div class="name"></div>
                            <div class="value">
                                <div class="input-group">
                                    <input class="input--style-5" type="text" name="priceedit" placeholder="enter a number here" value="<?php echo $_POST["pricetoedit"] ?>">
                                    <label class="label--desc">Price</label>
                                </div>
                            </div>
                        </div>
                       
                        <div>
                            <button class="btn btn--radius-2 btn--blue" type="submit" name="carEditSubmission"> SUBMIT</button>    
                        </div>
             </form>
             <br>
              
             <br>
             <div style="width: 26%">
             <?php  
          
             echo '<td><form action="editcar.php" method="POST"> <input hidden type="text" name="platetoedit" value='.$_POST["platetoedit"].'> 
             <input hidden type="text" name="nametoedit" value='.$_POST["nametoedit"].'>
             <input hidden type="text" name="brandtoedit" value='.$_POST["brandtoedit"].'>
             <input hidden type="text" name="categorytoedit" value='.$_POST["categorytoedit"].'>
             <input hidden type="number" name="seatstoedit" value='.$_POST["seatstoedit"].'>
             <input hidden type="text" name="transmissiontoedit" value='.$_POST["transmissiontoedit"].'>
             <input hidden type="text" name="pricetoedit" value='.$_POST["pricetoedit"].'>
             <input hidden type="text" name="imgtoedit" value='.$_POST["imgtoedit"].'>
             <input name="carediting" type="submit"  class="btn btn--radius-2 btn--red" value="RESET">  </form></td>'
             
             ?>
             </div>
            
             <br>
             <div>
             <a href="inspectcars.php?carpage=1"> <button class="btn btn--radius-2 btn--red"> CANCEL </button></a>
             </div>
             
                </div>
            </div>
        </div>
    </div>

<!--  
<div>
<a href="inspectcars.php?carpage=1"> <button class="btn btn-danger"> CANCEL </button></a>
</div>
--> 
</body>
</html>