<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Medicine</h1>

        <br><br>

        <?php
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
            <tr>
                <td>Tittle:</td>
                <td>
                    <input type="text" name="tittle" placeholder="Tittle of the Medicine">
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
                <td>Select Image:</td>
                <td>
                    <input type="file" name=image>
                </td>
            </tr>

            <tr>
                <td>Category:</td>
                <td>
                    <select name="category" >

                    <?php 
                       //Create PHP Code to display catagories from database
                       //1.Create SQL Query to get all active categories from database
                        $sql = "SELECT * FROM table_categories WHERE active='Yes'";
                        //Executing Query
                        $res = mysqli_query($conn, $sql);

                        //Count rows to check whether we have categories or not
                        $count = mysqli_num_rows($res);
                        //If Count is greater then zero,we have categories else we don't have categories
                        if($count>0) 
                        {
                            //We have categories
                            while($row= mysqli_fetch_assoc($res))
                            {
                                //Get the details of categories
                                $id =$row['id'];
                                $tittle = $row['tittle'];
                                ?>

                                <option value="<?php echo $id; ?>"><?php echo $tittle; ?></option>

                                <?php

                            }
                        

                        }
                        else
                        {
                            //We do not have categories
                            ?>
                             <option value="0">No Category Found</option>
                            <?php
                        }


                       //2.Display on Dropdown
                     ?>


                    </select>
                </td>
            </tr>

            <tr>
                <td>Featured:</td>
                <td>
                    <input type="radio" name="featured" value="Yes" > Yes
                    <input type="radio" name="featured" value="No" > No
                </td>
            </tr>
            <tr>
                <td>Active:</td>
                <td>
                <input type="radio" name="active" value="Yes" > Yes
                <input type="radio" name="active" value="No" > No
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="submit" value="Add Medicine" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <?php

        //check whether the button is clicked or not
        if(isset($_POST['submit']))
        {
               //add the medicine in database
               //echo "clicked"
               //1. get the data from form
               $tittle = $_POST['tittle'];
               $description = $_POST['description'];
               $price = $_POST['price'];
               $category = $_POST['category'];

               //check whether radio button for feature and active are checked
               if(isset($_POST['featured']))
               {
                $featured = $_POST['featured'];
            
               }
               else
               {
                $featured = "NO"; //setting the deafult value
               }
               if(isset($_POST['active']))
               {
                $active = $_POST['active'];
               }
               else
               {
                $active = "NO"; // setting deafult value
               }
                
               if(isset($_FILES['image']['name']))
               {
                $image_name = $_FILES['image']['name'];

                if($image_name!="")
                {
                    $ext = end(explode('.', $image_name));
                    $image_name = "Medicine-Name-".rand(0000,9999).".".$ext;
                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../images/medicine/".$image_name;

                    $upload = move_uploaded_file($src, $dst);

                    if($upload == false)
                    {
                        $_SESSION['upload'] = "<div class ='error'>Failed to Upload Image.</dive>";
                        header('location:'.SITEURL.'admin/add-medicine.php');
                        die();
                    }
                }

               }
               else
               {
                $image_name = "";
               }
               $sql2 = "INSERT INTO table_medicine SET 
               tittle = '$tittle',
               description = '$description',
               price = '$price',
               image_name = '$image_name',
               category_id = '$category',
               featured = '$featured',
               active = '$active'";

               $res2 = mysqli_query($conn, $sql2);
               if($res2 == true)
               {
                $_SESSION['add'] = "<div class = 'success'> Medicine Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-medicine.php');
               }
            else
            {
                $_SESSION['add'] = "<div class = 'error'> Failed to Add Medicine..</div>";
                header('location:'.SITEURL.'admin/manage-medicine.php'); 
            }


            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>