<?php include('partials-front/menu.php'); ?>

<?php
    // check whether id is passed or not
    if(isset($_GET['category_id']))
    {
        // get category id
        $category_id = $_GET['category_id'];

        // get the category tittle based on id
        $sql = "SELECT tittle FROM table_categories WHERE id=$category_id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // get value from database
        $row=mysqli_fetch_assoc($res);

        // get the tittle
        $category_tittle = $row['tittle'];
    }
    else
    {
        //category not passed, redirect to homepage
        header('location:'.SITEURL);
    }
?>

<!-- Medicine search Section Starts Here -->
<section class="food-search text-center">
        <div class="container">
            
            <h2>Medicines on <a href="#" class="text-white">"<?php echo $category_tittle?>"</a></h2>

        </div>
    </section>
    <!-- Medicine search Section Ends Here -->



    <!-- Medicine Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Medicine Menu</h2>

            <?php
                // Display medicines that are active
                $sql2 = "SELECT * FROM table_medicine WHERE category_id=$category_id";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // count rows
                $count2 = mysqli_num_rows($res2);

                // check whether the medicine is available
                if($count2>0)
                {
                    // medicine available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        // get the values
                        $id = $row2['id'];
                        $tittle = $row2['tittle'];
                        $description = $row2['description'];
                        $price = $row2['price'];
                        $image_name = $row2['image_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                            <?php
                            // check whether image is available or not
                            if($image_name=="")
                            {
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/medicine/<?php echo $image_name; ?>" alt="Medicine" class="img-responsive img-curve">
                                <?php
                            }

                            ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $tittle; ?></h4>
                                <p class="food-price"><?php echo $price; ?></p>
                                <p class="food-detail">
                                <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?medicine_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    // medicine not available
                    echo "<div class='error'>Medicine not found</div>";
                }
            ?>

            <div class="clearfix"></div>           

        </div>

    </section>
    <!-- Medicine Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>