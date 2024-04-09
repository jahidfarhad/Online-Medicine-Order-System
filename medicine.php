<?php include('partials-front/menu.php'); ?>

<!-- Medicine search Section Starts Here -->

<section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>medicine-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Medicine.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Medicine search Section Ends Here -->

    <!-- Medicine Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Medicine Menu</h2>

            <?php
                // Display medicines that are active
                $sql = "SELECT * FROM table_medicine WHERE active='Yes'";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // count rows
                $count = mysqli_num_rows($res);

                // check whether the medicine is available
                if($count>0)
                {
                    // medicine available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        // get the values
                        $id = $row['id'];
                        $tittle = $row['tittle'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
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