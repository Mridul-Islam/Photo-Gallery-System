<?php include("includes/admin_header.php"); ?>

<?php if(!$session->is_signed_in()) { redirect("login.php");  }          ?>

<?php

if(isset($_GET['id'])){
    $edit_id = $database->escape_string($_GET['id']);

    $photo = Photo::find_by_id($edit_id);

    if(isset($_POST['update'])){
        if($photo){
            $photo->title          = $_POST['title'];
            $photo->caption        = $_POST['caption'];
            $photo->description    = $_POST['description'];
            $photo->alternate_text = $_POST['alternate_text'];
            
            $photo->save();
            redirect("edit_photo.php?id=$photo->id");
            $session->message("The Photo -- {$photo->filename} -- has been updated");
        }
    }
} 
else{
    redirect("photos.php");
}




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
                        <h1 class="page-header text-center">
                            Edit
                            <small>Photo</small>
                        </h1>
                        <p class="bg-success"><?php echo $message; ?></p>
                        <form action="" method="post">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" name="title" class="form-control" value="<?php echo $photo->title; ?>">
                                </div>
                                <div class="form-group">
                                    <a class="thumbnail" href=""><img src="<?php echo $photo->picture_path(); ?>"></a>
                                </div>
                                <div class="form-group">
                                    <label for="caption">Caption</label>
                                    <input type="text" id="caption" name="caption" class="form-control" value="<?php echo $photo->caption; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="alternet">Alternate text</label>
                                    <input type="text" id="alternet" name="alternate_text" class="form-control" value="<?php echo $photo->alternate_text; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="10"><?php echo $photo->description; ?></textarea>
                                </div>
                            </div>


                            <div class="col-md-4" >
                                <div  class="photo-info-box">
                                    <div class="info-box-header">
                                       <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                    </div>
                                    <div class="inside">
                                        <div class="box-inner">
                                            <p class="text">
                                            <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                            </p>
                                            <p class="text ">
                                                Photo Id: <span class="data photo_id_box"><?php echo $photo->id; ?></span>
                                            </p>
                                            <p class="text">
                                                Filename: <span class="data"><?php echo $photo->filename; ?></span>
                                            </p>
                                            <p class="text">
                                                File Type: <span class="data"><?php echo $photo->type; ?></span>
                                            </p>
                                            <p class="text">
                                                File Size: <span class="data"><?php echo $photo->size; ?></span>
                                            </p>
                                        </div>
                                        <div class="info-box-footer clearfix">
                                            <div class="info-box-delete pull-left">
                                                <a  href="delete_photo.php?delete_id=<?php echo $photo->id; ?>" class="btn btn-danger btn-lg ">Delete</a>   
                                            </div>
                                            <div class="info-box-update pull-right ">
                                                <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                            </div>   
                                        </div>
                                    </div>          
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>

        <!-- /#page-wrapper -->

  <?php include("includes/admin_footer.php"); ?>