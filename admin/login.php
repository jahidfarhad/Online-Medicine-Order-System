  <?php include('../config/constants.php'); ?>




<html>
    <head>
        <title>Login- Medicine Order System</title>
        <link rel="stylesheet" href="css/admin.css">
    </head>
    <body>
       
         <div  class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            
            <?php 
              if(isset($_SESSION['login']))
              {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
              }
              if(isset( $_SESSION['no-login-message']))
              {
                echo $_SESSION['no-login-message'];
                unset ($_SESSION['no-login-message']);
              }
            ?>
            <br><br>


            <!----Login form starts here------->
                 <form action="" method="POST" class="text-center">

                 Username: <br>
                 <input type="text" name="username" placeholder="Enter Username"><br><br>

                 Password: <br>
                 <input type="password" name="password" placeholder="Enter Password"><br><br>


                 <input type="submit" name="submit" value="Login" class="btn-primary"> 
                 <br><br>
                 </form>

            <!----Login form Ends here------->

            <p class="text-center">Created By - <a href="">My Team</a></p>
         </div>

    </body>
</html>

<?php 
   // check whether the submit button is clicked or not
   if(isset($_POST['submit']))
   {
    // process for login
    // 1.get the data login form
       $username = $_POST['username'];
       $password = md5($_POST['password']);

       // sql to check whwether the user with username and password exsist or not
       $sql = "SELECT * FROM table_admin WHERE username='$username' AND password='$password'";
       
       // execute the query
       $res = mysqli_query($conn, $sql);
   //4. counts rows to check whether the user exsist or not
   $count = mysqli_num_rows($res);

   if($count==1)
   {
     //user available and login success
     $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
     $_SESSION['user'] = $username; // to check whether the user is logged in or not and logout will unset it.
     // redirect to admin page/dashboard
     header('location:'.SITEURL.'admin/index.php');

    
   }
   else
   {
    // user not available and login error
    $_SESSION['login'] = "<div class='error text-center'>Username or password did not match.</div>";
    // redirect to login page
    header('location:'.SITEURL.'admin/login.php');

     
   }


   }
?>