<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php
         if(isset($_SESSION['add']))
         {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
         }
         if(isset($_SESSION['upload']))
         {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
         }
        ?> 
        <br><br>

        

        <!----Add Category form starts---->

           <form action="" method="POST" enctype="multipart/form-data">
             <table class="tbl-30">
                <tr>
                   <td>Tittle:</td>
                   <td> 
                    <input type="text" name="tittle" placeholder="Category Tittle">
                   </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input  type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
             </table>

           </form>
           <?php
             // check whether the submit button is clicked or not
             if(isset($_POST['submit']))
             {
                //echo "Clicked";

                //1.get the value from category form
                $tittle = $_POST['tittle'];

                // for radio input type we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //set the default value
                    $featured = "No";
                }
                if(isset($_POST['active']))
                {
                   $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }
                //check whether the image is selected or not and set the value for image name accordingly
                //print_r($_FILES['image']);

                //die();// break the code here
                if(isset($_FILES['image']['name']))
                {
                    //upload the image
                    // to upload image we need image name, source path and destination path
                    $image_name =$_FILES['image']['name'];

                    //Upload Image only if image is selected
                    if($image_name !="")
                    {

                   

                   

                    //Auto rename our image
                    //get the extenssion of our image(jpg,png,gif,etc) e.g. "medicine1.jpg"
                    $ext = end(explode('.',$image_name));

                    //Rename the image
                    $image_name = "medicine_category_".rand(000,999).'.'.$ext;// e.g medicine_category_814.jpg

                    $source_path =$_FILES['image']['tmp_name'];

                    $destination_path="../images/category/".$image_name;

                    // finally upload the image
                    $upload = move_uploaded_file($source_path,$destination_path);
                    // check whether the image is uploaded or not
                    // and if the images is not uploaded then we will stop the process and redirect with error message.
                    if($upload==false)
                    {
                        // set message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        //redirect to add category page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //stop the process
                        die();
                    }
                 }
                }
                else
                {
                    //don't upload image and set the image_name value as blank
                    $image_name="";
                }

                //2. create sql query to insert category into database
                $sql = "INSERT INTO table_categories SET 
                    tittle = '$tittle',
                    image_name='$image_name',
                    featured = '$featured',
                    active = '$active'
                
                ";
                //3. execute the query and save in database
                $res = mysqli_query($conn, $sql);
                //4.check whether the query executed or not and data added or not
                if($res==true)
                {
                    //query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Fail to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    //redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
             }
           
           
           ?>

         <!----Add Category form Ends---->
    </div>
</div>

<?php include('partials/footer.php');?>