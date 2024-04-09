<?php include('partials-front/menu.php'); ?>

<?php
//check whether medicine id is set or not
if(isset($_GET['medicine_id']))
{
//get the medicine id and details of the selected medicine
$medicine_id = $_GET['medicine_id'];

//get the details of the selected medicine
$sql = "SELECT *FROM table_medicine WHERE id=$medicine_id";
// execute query
$res = mysqli_query($conn,$sql);
//count the row
$count = mysqli_num_rows($res);
// check whether the data is available or not
if($count==1)
{
    // we have data
    $row = mysqli_fetch_assoc($res);
    
   $tittle = $row['tittle'];
   $price = $row['price'];
   $image_name = $row['image_name'];
}

}
else{
    //redirect to home page
    header('location:'.SITEURL);

}
?>


<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Medicine</legend>

                    <div class="medicine-menu-img">
                    <?php 
                        
                        //CHeck whether the image is available or not
                        if($image_name=="")
                        {
                            //Image not Availabe
                            echo "<div class='error'>Image not Available.</div>";
                        }
                        else
                        {
                            //Image is Available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/medicine/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                            <?php
                        }
                    
                    ?>
                        
                    </div>
    
                    <div class="medicine-menu-desc">
                        <h3><?php echo $tittle; ?></h3>
                        <input type="hidden" name="medicine" value="<?php echo $tittle; ?>">
                        <p class="medicine-price"> $<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. MN Nahid" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 0191xxxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. nahid19@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php 

//CHeck whether submit button is clicked or not
if(isset($_POST['submit']))
{
    // Get all the details from the form

    $medicine = $_POST['medicine'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    $total = $price * $qty; // total = price x qty 

    $order_date = date("Y-m-d h:i:sa"); //Order DAte

    $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled

    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];


    //Save the Order in Databaase
    //Create SQL to save the data
    $sql2 = "INSERT INTO table_order SET 
        medicine = '$medicine',
        price = $price,
        qty = $qty,
        total = $total,
        order_date = '$order_date',
        status = '$status',
        customer_name = '$customer_name',
        customer_contact = '$customer_contact',
        customer_email = '$customer_email',
        customer_address = '$customer_address'
    ";

    //echo $sql2; die();

    //Execute the Query
    $res2 = mysqli_query($conn, $sql2);

    //Check whether query executed successfully or not
    if($res2==true)
    {
        //Query Executed and Order Saved
        $_SESSION['order'] = "<div class='success text-center'>Medicine Ordered Successfully.</div>";
        header('location:'.SITEURL);
    }
    else
    {
        //Failed to Save Order
        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Medicine.</div>";
        header('location:'.SITEURL);
    }

}

?>

        </div>
    </section>
    <!-- Medicine sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php');?>