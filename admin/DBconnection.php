<?php 

$env = parse_ini_file("../.env");

$db_server = $env["DB_HOST"];
$db_user = $env["DB_USERNAME"];
$db_password = $env["DB_PASSWORD"];
$db_name = $env["DB_DATABASE"];

$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);

function deleteOrder($todelete,$conn)
{
       
        $deletion = "DELETE FROM Orders WHERE ID=$todelete";
        $result = mysqli_query($conn, $deletion);    

}

function deleteCar($todelete,$conn)
{
    $check = "SELECT * FROM Cars WHERE licencePlate='$todelete'";
    $res = mysqli_query($conn,$check);
    $res2 = mysqli_fetch_array($res);
    $imgtodelete = $res2["imgSrc"];
    
    $absolutePath = "/var/www/html";
    unlink($absolutePath.$imgtodelete);
    
    $deletion = "DELETE FROM Cars WHERE licencePlate='$todelete'";
    $result = mysqli_query($conn, $deletion);    
    var_dump($todelete);

}


function uploadFile($file)
{
    if(empty($file))
    {
        echo '<script>alert("no file was uploaded - is file_uploads enabled in your php.ini?")</script>';
        return false;
    }
    
    if($file["image"]["error"] !== UPLOAD_ERR_OK)
    {
        switch($file["image"]["error"])
        {
            case UPLOAD_ERR_PARTIAL:
                echo '<script>alert("file only partially uploaded")</script>';
                return false;
                break;
            case UPLOAD_ERR_NO_FILE:
                echo '<script>alert("No file was uploaded")</script>';
                return false;
                break;
            case UPLOAD_ERR_EXTENSION:
                echo '<script>alert("file stopped by a php extension")</script>';
                return false;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo '<script>alert("file exceeds maximum size")</script>';
                return false;
                break;
             case UPLOAD_ERR_INI_SIZE:
                echo '<script>alert("file exceeds maximum size in php.ini")</script>';
                return false;
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo '<script>alert("file exceeds maximum size")</script>';
                return false;
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                exit("Temporary folder not found");
                echo '<script>alert("Temporary folder not found")</script>';
                return false;
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo '<script>alert("failed to write file")</script>';
                return false;
                break;                             
            default:
                echo '<script>alert("unknown file error")</script>';
                return false;
                break;
    
        }
    }
    
    
    
    $mime_types = ["image/gif","image/png","image/jpeg"];
    
    if(!in_array($file["image"]["type"], $mime_types))
    {
        echo '<script>alert("Invalid file ype entered")</script>';
        return false;
    }
    
    $pathinfo = pathinfo($file["image"]["name"]);
    $base = $pathinfo["filename"];
    $base = preg_replace("/[^\w-]/","_",$base);
    
    $filename = $base.".".$pathinfo["extension"];
    
    $destination = __DIR__ . "/uploads/" . $filename;
    
    $i = 1;
    
    while(file_exists($destination))
    {
        $filename = $base . "($i)." . $pathinfo["extension"];
        $destination = __DIR__ . "/uploads/" . $filename;
        $i++;
    }
    
    if(!move_uploaded_file($file["image"]["tmp_name"],$destination))
    {
       echo '<script>alert("could not upload file")</script>';
       return false;
    }
    
    $destination = str_replace('\\' ,"/",$destination);
    return $destination;
}

function addCar($conn, $licencePlate, $name, $brand, $category, $seats, $transmission, $imgSrc, $price )
{

if( $licencePlate == "" || $name == "" || $brand == "" || $category == "" || $transmission == "" || $imgSrc == "" || $price == 0)
{
    echo '<script>alert("Please fill out all the fields properly!")</script>';
    return;
}

$upload = uploadFile($imgSrc);
if(!$upload)
{
    return;
}
$pathForDb = explode("project", $upload)[1];
$sql = "INSERT Cars SET licencePlate='$licencePlate', name = '$name', brand = '$brand', category = '$category', seats = $seats, transmission = '$transmission', imgSrc = '/project$pathForDb', price = $price ";

if(mysqli_query($conn,$sql))
{
    echo '<script>alert("Vehicle inserted successfully!")</script>';
    header("LOCATION: inspectcars.php?carpage=1");
}
else
{
    echo '<script>alert("Error entering data in database.")</script>';
}


}
function editCar($conn, $platetoedit, $name_edit, $brand_edit, $category_edit , $seats_edit, $transmission_edit, $price_edit, $image)
{


if( $name_edit == "" || $brand_edit == "" || $category_edit == "" || $transmission_edit == "" || $price_edit == 0)
{
    echo '<script>alert("Please fill out all the fields properly!")</script>';
    return;
}


    $sqln= "UPDATE Cars SET name='$name_edit', brand='$brand_edit', category='$category_edit', seats=$seats_edit, transmission='$transmission_edit', price=$price_edit  WHERE licencePlate='$platetoedit'";
    mysqli_query($conn,$sqln);

    
   

    if($image["image"]["size"] != 0)
    {
        $check = "SELECT * FROM Cars WHERE licencePlate='$platetoedit'";
        $res = mysqli_query($conn,$check);
        $res2 = mysqli_fetch_array($res);
        $imgtodelete = $res2["imgSrc"];
        
        $absolutePath = "/var/www/html";
         unlink($absolutePath.$imgtodelete);

        //  echo $absolutePath.$imgtodelete;


        $newimg = uploadFile($image);
        $pathForDb = explode("project", $newimg)[1];
        $sqli= "UPDATE Cars SET imgSrc='$pathForDb' WHERE licencePlate='$platetoedit'";
        mysqli_query($conn,$sqli);

        
       
    }


   header("LOCATION: inspectcars.php?carpage=1");

    
}
?>