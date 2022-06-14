<?php 
include("../../../models/catalogs.php");
$conn=superConn();

if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') {
    
}

if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
}elseif (isset($_FILES['uploadedFile2']) && $_FILES['uploadedFile2']['error'] === UPLOAD_ERR_OK) {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile2']['tmp_name'];
    $fileName = $_FILES['uploadedFile2']['name'];
    $fileSize = $_FILES['uploadedFile2']['size'];
    $fileType = $_FILES['uploadedFile2']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    
}

// directory in which the uploaded file will be moved
$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
$newFileName2 = md5(time() . $fileName);
$path= '../../../resources/storage/shcp_files/';

if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

$dest_path = $path . $newFileName;


if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {

    if(move_uploaded_file($fileTmpPath, $dest_path))
    {

        $query = "UPDATE empresa SET archivo_cer='$newFileName'";
        $res=mysqli_query($conn,$query);
        if(!$res ){
            //die(json_encode($query));
            return;
        }else{
            header("Location: ../view/", TRUE, 301);
            exit();
        }
    }
    else
    {
    header("Location: ../view/", TRUE, 301);
    exit();
    }


}elseif (isset($_FILES['uploadedFile2']) && $_FILES['uploadedFile2']['error'] === UPLOAD_ERR_OK){
    if(move_uploaded_file($fileTmpPath, $dest_path))
    {

        $query = "UPDATE empresa SET archivo_key='$newFileName'";
        $res=mysqli_query($conn,$query);
        if(!$res ){
            //die(json_encode($query));
            return;
        }else{
            header("Location: ../view/", TRUE, 301);
            exit();
        }
    }
    else
    {
        header("Location: ../view/", TRUE, 301);
        exit();
    }
}


?>