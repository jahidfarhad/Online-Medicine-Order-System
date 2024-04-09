<?php
  //Include constants file
  include('../config/constants.php');
  //echo "Delete Page";
  //check whether the id and image_name value is set or not
  if(isset($_GET['id'])AND isset($_GET['image_name']))
  {
    //Get the value and delete
    //echo"Get value and Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Remove the physical image file is available
    if($image_name !="")
    {
        //Image is available.So Remove it
        $path = "../images/category/".$image_name;
        //Remove the image
        $remove =unlink($path);
        //If Failed to remove image then add an error message and stop the process.
        if($remove==false)
        {
            //Set the SESSION Message
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";

            //Redirect to Manage category page
            header('location:'.SITEURL.'admin/manage-category.php');

            //Stop The process
            die();
        }
    }

    //Delete data from database
    //SQL Query to delete data from database
    $sql = "DELETE FROM table_categories WHERE id=$id";
    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Check Whether the data is deleted from database or not
    if($res==true)
    {
        //Set the Success message and redirect
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
        //Redirect to Manage category
        header('location:'.SITEURL.'admin/manage-category.php');

    }
    else
    {
        //Set Failed Message and redirect
        $_SESSION['delete'] = "<div class='erroe'>Failed to Delete Category.</div>";
        //Redirect to Manage category
        header('location:'.SITEURL.'admin/manage-category.php');

    }

  }
  else
  {
    //redirect to manage category page
    header('location:'.SITEURL.'admin/manage-category.php');
  }

 ?>