<?php include("includes/admin_header.php"); ?>

<?php if(!$session->is_signed_in()) { redirect("login.php");  }          ?>

<?php 

$all_photo = Photo::find_all();  


?>


        <!-- Navigation -->
            
            <?php include("includes/admin_top_nav.php"); ?>


            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <?php include("includes/admin_side_nav.php"); ?>


            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            All 
                            <small>Photos</small>
                        </h1>
                        <p class="bg-success"><?php echo $message; ?></p>
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Id</th>
                                        <th>File Name</th>
                                        <th>Tittle</th>
                                        <th>Size</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($all_photo as $photo){  ?>

                                <tr>
                                    <td><img class="admin_photo_thumbnail" src='<?php echo $photo->picture_path(); ?>' alt='' />
                                        <div class="action_link">
                                            <a class='delete_link' href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
                                            <a class='btn' href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                                            <a class='btn' href="../photo.php?id=<?php echo $photo->id; ?>">View</a>
                                        </div>
                                    </td>
                                    <td><?php echo $photo->id; ?></td>
                                    <td><?php echo $photo->filename; ?></td>
                                    <td><?php echo $photo->title; ?></td>
                                    <td><?php echo $photo->size; ?></td>
                                    <td>
                                        <a href="comment_photo.php?id=<?php echo $photo->id; ?>">
                                        <?php 

                                        $photo_comments = Comment::find_the_comments($photo->id);
                                        echo count($photo_comments);

                                        ?>  
                                        </a>
                                        
                                    </td>
                                </tr>
                                
                                <?php 
                                } 

                                ?>


                                
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>

        <!-- /#page-wrapper -->

  <?php include("includes/admin_footer.php"); ?>