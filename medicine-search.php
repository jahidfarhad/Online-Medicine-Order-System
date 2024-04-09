<?php include('partials-front/menu.php'); ?>

<!-- Medicine search Section Starts Here -->
<section class="food-search text-center">
        <div class="container">
            
        <?php
            // get the search keyword
            $search = $_POST['search'];
        ?>

        <h2>Medicines on Your Search <a href="#" class="text-white">"<?php echo $search?>"</a></h2>

        </div>
    </section>
    <!-- Medicine search Section Ends Here -->



    <!-- Medicine MEnu Section Starts Here -->
    <section class="medicine-menu">
        <div class="container">
            <h2 class="text-center">Medicine Menu</h2>

            <?php               

                // sql query to get searched medicines
                $sql = "SELECT * FROM table_medicine WHERE tittle LIKE '%$search%' OR description LIKE '%$search%'";

                // execute the query
                $res = mysqli_query($conn, $sql);

                $count = mysqli_num_rows($res);

                // check whether medicine is available or not
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

                            <div class="medicine-menu-desc">
                                <h4><?php echo $tittle; ?></h4>
                                <p class="medicine-price"><?php echo $price; ?></p>
                                <p class="medicine-detail">
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