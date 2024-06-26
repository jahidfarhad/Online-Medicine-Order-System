<?php include('partials-front/menu.php');?>

 <!-- CAtegories Section Starts Here -->

 <section class="categories">
        <div class="container">
            <h2 class="text-center">Medicine Category</h2>

            <?php
                // Display medicines that are active
                $sql = "SELECT * FROM table_categories WHERE active='Yes'";

                // Execute the query
                $res=mysqli_query($conn, $sql);

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
                    
                        $image_name = $row['image_name'];
                        ?>
                        <a href="<?php echo SITEURL; ?>category-medicine.php?category_id=<?php echo $id?>;">
                    <div class="box-3 float-container">
                        
                            <?php
                            // check whether image is available or not
                            if($image_name=="")
                            {
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Category" class="img-responsive img-curve">
                                <?php
                            }

                            ?>
                            <h3 class="float-text text-white"><?php echo $tittle; ?></h3>
                    </div>
                </a>    
                        <?php
                    }
                }
                else
                {
                    // catagory not available
                    echo "<div class='error'>Catagory not added</div>";
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>

    <!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php');?>