<?php include('partials/menu.php');?>

 <div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>
     
        <?php
            if(isset($_SESSION['add'])) // cheacking whether the session is set or not
            {
                echo $_SESSION['add']; // display session message if set
                unset($_SESSION['add']); // remove session message
            }
         ?>




        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="username">
                    </td>
                </tr>
                <tr>
                   <td>Password:</td>
                   <td>
                      <input type="password" name="password" placeholder="password">
                   </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
 </div>

<?php include('partials/footer.php'); ?>

<?php
// process the value form and save it in Database

// cheack whether the submit button is clicked or not

if(isset($_POST['submit']))
{
    // Button clicked
    //echo "Button Clicked";
    //1.Get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // password Encryption with md5

    // 2. SQL Query to save the data into database
    $sql ="INSERT INTO table_admin SET
     full_name='$full_name',
     username='$username',
     password='$password'
    ";
 // 3. Executin Query and saving data into database
   $res = mysqli_query($conn, $sql) or die(mysqli_error());

   // 4.Check whether the(query is executed) data is inserted or not display appropriate message
   if($res==TRUE)
   {
    // Data Inserted
    //echo "Data Inserted";
    // create a sessoin veriable
    $_SESSION['add'] =" <div class='success'>Admin Added Successfully.</div>";
    //Redirect page to manage admin
    header("location:".SITEURL.'admin/manage-admin.php');
   }
   else
   {
    //Failled to insert data
    //echo "Faile to Insert Data";
     // create a sessoin veriable
     $_SESSION['add'] ="<div class='error'>Failed to Add Admin.</div>";
     //Redirect page to Add admin
     header("location:".SITEURL.'admin/add-admin.php');
   }
}

 ?>