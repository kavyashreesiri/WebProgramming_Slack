<?php
require_once 'php_action/db_connect.php';
session_start();
$user_id=$_SESSION["userId"];
//echo $user_id;
$folder="uploads/images/";
$result=0;
//echo $user_id;
if ($_SERVER ['REQUEST_METHOD'] == "POST") {
    echo "In Post";
    // code to upload image to server and update or insert userpicpath
    if (isset ( $_FILES ['image'] )) {
        $errors = array ();
        $file_size = $_FILES ['image'] ['size'];
        $file_name = $_FILES ['image'] ['name'];
        $file_tmp = $_FILES ['image'] ['tmp_name'];
        $file_type = $_FILES ['image'] ['type'];
        //$file_ext = strtolower ( end ( explode ( '.', $_FILES ['image'] ['name'] ) ) );
        $file_ext='jpeg';
        $fileName=$_SESSION["userId"].".".$file_ext;
        $targetPath=$folder. $fileName;
        echo $targetPath;   
        $expensions = array (
                "jpeg",
                "jpg",
                "png" 
        );
        
        if (in_array ( $file_ext, $expensions ) === false) {
            $errors [] = "extension not allowed, please choose a JPEG or PNG file.";
        }
        
        //echo "<script>alert(".$file_size.");</script>";
        if ($file_size > 2097152) {
            $errors [] = 'File size must be exactly 2 MB';
            echo  "<script>alert('File size must be exactly 2MB!!".$sql."');</script>";
        }
        
    if (count ( $errors ) === 0) 
    {
            $status=move_uploaded_file ( $file_tmp, $targetPath );
            //echo  "<script>alert(".$status.");</script>";
            //echo "Status of file:".$status;
           
        
               $sql="INSERT INTO profile_pic (user_id,img_path) VALUES(".$user_id.",'./uploads/images/".$fileName."') ON DUPLICATE KEY UPDATE img_path='./uploads/images/".$fileName."',user_id=".$user_id."";
                //$sql="update profile_pic set img_path='".$fileName."' where user_id=".$_SESSION["userId"]."";
                
                if ($connect->query($sql) === TRUE) 
                {
                    $result=1;
                    echo $result;
                    //echo  "<script>alert("updated");</script>";
                    echo "<script type='text/javascript'>window.top.window.completeUpload('" . $result . "','" . $targetPath . "');</script> ";
                    
                }
                
                        else
                        {
                            
                            echo  "<script>alert('Error uploading profile pic!!".$sql."');</script>";
                        }
               // }
        }
        else {
            print_r ( $errors );
        }
    }
}
?>
