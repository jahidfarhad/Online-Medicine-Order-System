<?php 
   // include constant.php for SITEURL
   include('../config/constants.php');
  // 1.destory the session
  session_destroy(); // unsets $SESSION_['user']

  // 2.redirect to login page
  header('location:'.SITEURL.'admin/login.php');
?>