<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Medicine</h1>
        <br><br>

      <?php 
            //check whether the id is set or not
            if(isset($_GET['id']))
            {
                //Get the id and all other details
                //echo "Getting the data";
                $id = $_GET['id'];
                //Create SQL Query to get all other details
                $sql = "SELECT * FROM table_medicine WHERE id=$id";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count the rows to check whether the id valid or not
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Get all the data
                    $row = mysqli_fetch_assoc($res);
                    $tittle = $row['tittle'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $current_category = $row['category_id'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    //Redirect to manage medicine with session message
                    
                    $_SESSION['no-medicine-found'] = "<div class='error'>Medicine Not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-medicine.php');
                }
            }
            else
            {
                //Redirect to Manage Medicine
                header('location:'.SITEURL.'admin/manage-medicine.php');
            }
      
      
      
      ?>




        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Tittle:</td>
                <td>
                    <input type="text" name="tittle" value="<?php echo $tittle; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image:</td>
                <td>
                    <?php 
                       if($current_image !="")
                       {
                         //Displaye the Image
                         ?>
                         <img src="<?php echo SITEURL; ?>images/medicine/<?php echo $current_image; ?>" width="140px" >
                         <?php
                       }
                       else
                       {
                         //Display Message
                         echo"<div class='error'>Image Not Added.</div>";
                       }
                    ?>
                </td>
            </tr>

            <tr>
                <td>New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description"  cols="30" rows="5" placeholder="Description of the Medicine."></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                        <?php
                        $sql = "SELECT *FROM table_categories WHERE active='YES'";
                        $res = mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($res);

                        if($count>0)
                        {
                            //category Available
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $category_tittle = $row['tittle'];
                                $category_id = $row['id'];
                                echo "<option value='$category_id'>$category_tittle</option>";
                            }
                        }
                        else
                        {
                            //Category Not Available
                            echo "<option value='0'>category Not Available.</option>";
                        }
                        ?>
                    
                    </select>
                </td>
            </tr>
           
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                    <input <?php if($featured=="No"){echo "checked";} ?>  type="radio" name="featured" value="No"> No

                </td>
            </tr>


            <tr>
                <td>Active:</td>
                <td>
                <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No 
                </td>
            </tr>

            <tr>
                <td>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <input type="submit" name="submit" value="Update Category" class="btn-secondary">

                </td>
            </tr>

        </table>
        </form>

        <?php 
           if(isset($_POST['submit']))
           {
             // echo "Clicked";
             //1.Get all the values from our form
             $id = $_POST['id'];
             $tittle = $_POST['tittle'];
             $description = $_POST['description'];
             $price = $_POST['price'];
             $current_category = $_POST['category_id'];
             $current_image = $_POST['current_image'];
             $featured = $_POST['featured'];
             $active = $_POST['active'];

             //2.Updating new image if selected
               //check whether the image is selected or not
               if(isset($_FILES['image']['name']))
               {
                    //Get the image details
                    $image_name = $_FILES['image']['name'];
                    //Check whether image is available or not
                    if($image_name !="")
                    {
                        //Image is Available
                        //A.Upload the new image

                        
                    //Auto rename our image
                    //get the extenssion of our image(jpg,png,gif,etc) e.g. "medicine1.jpg"
                    $ext = end(explode('.',$image_name));

                    //Rename the image
                    $image_name = "Medicine-Name-".rand(0000,9999).".".$ext;// e.g medicine_category_814.jpg

                    $source_path =$_FILES['image']['tmp_name'];

                    $destination_path="../images/medicine/".$image_name;

                    // finally upload the image
                    $upload = move_uploaded_file($source_path,$destination_path);
                    // check whether the image is uploaded or not
                    // and if the images is not uploaded then we will stop the process and redirect with error message.
                    if($upload==false)
                    {
                        // set message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        //redirect to add category page
                        header('location:'.SITEURL.'admin/manage-medicine.php');
                        //stop the process
                        die();
                    }

                        //B.Remove the current Image if available
                        if($current_image !="")
                        {
                            $remove_path = "../images/medicine/".$current_image;
                            $remove = unlink($remove_path);
    
                            //Check the whether image is remove or not
                            //If failed to remove then display message and stop the process
                            if($remove==false)
                            {
                                //Failed to remove image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-medicine.php');
                                die();//Stop the process
    
                            }
                            
                        }

                      
                    }
                
                    else
                    {
                        $image_name = $current_image;
                    }

               }
               else
               {
                 $image_name = $current_image;
               }


             //3.Update the Database
             $sql2 = "UPDATE table_medicine SET
               tittle = '$tittle',
               description ='$description',
               price = '$price',
               category_id = '$category',
               image_name = '$image_name',
               featured = '$featured',
               active = '$active'
               WHERE id=$id
             ";

             //Execute the query
             $res2 = mysqli_query($conn, $sql2);

             //4.Redirect to Manage medicine with message
             //Check whether executed or not
             if($res2==true)
             {
                //Medicine Updated
                $_SESSION['update'] = "<div class='success'>Medicine Updated Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-medicine.php');
             }
             else
             {
                //Failed to Update category
                $_SESSION['update'] = "<div class='error'>Failed to Update Medicine.</div>";
                header('location:'.SITEURL.'admin/manage-medicine.php');
             }

           }
        ?>
    </div>
</div>


<?php include('partials/footer.php');?>