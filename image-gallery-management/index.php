<?php
// Include and initialize DB class
require_once 'DB.class.php';
$db = new DB();

// Fetch the images data
$condition = array('where' => array('status' => 1));
$images = $db->getRows('images', $condition);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Image Gallery Management by BiswaBijaya</title>
<meta charset="utf-8">
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
<meta name="viewport" content="width=device-width" />
<meta name="title" content="Image Gallery Management">
<!-- Fancybox CSS library -->
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css">

<!-- Stylesheet file -->
<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css">

<!-- jQuery library -->
<script src="js/jquery.min.js"></script>
<script src="bootstrap/bootstrap.min.js"></script>

<!-- Fancybox JS library -->
<script src="fancybox/jquery.fancybox.js"></script>

<!-- Initialize fancybox -->
<script>
	$("[data-fancybox]").fancybox();
</script>

</head>
<body class="main">
<div class="container pt-4">
	<h1>Dynamic Images Gallery</h1>
	<hr>
	<div class="head" align="right">
		<a href="manage.php" class="glink">Manage Images</a>
	</div>
	<br>
    <div class="gallery row text-center">
        <?php
        if(!empty($images)){
            foreach($images as $row){
				$uploadDir = 'uploads/images/';
                $imageURL = $uploadDir.$row["file_name"];
        ?>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <a href="<?php echo $imageURL; ?>" data-fancybox="gallery" data-caption="<?php echo $row["title"]; ?>" >
                <img width="100%" src="<?php echo $imageURL; ?>" alt="" />
				<p><?php echo $row["title"]; ?></p>
            </a>
		</div>
        <?php }
        } ?>
    </div>
</div>
</body>
</html>
