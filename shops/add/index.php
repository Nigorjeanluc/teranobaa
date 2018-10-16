<?php
  session_start();
  $error_message = "fill this form to add a product";
   $error_message2 = "";
   $fileName = "dfdfd";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> teranoba sellers-add a page </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <!-- Le styles -->
    <link href="../../assetss/css/bootstrap.css" rel="stylesheet">
    <link href="../../assetss/css/main.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>

    <style type="text/css">
      body {
        padding-top: 60px;
      }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

    <!-- Google Fonts call. Font Used Open Sans -->
  	<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
  	
  	<!-- ElFinder File Manager CSS. https://github.com/Studio-42/elFinder/ -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/smoothness/jquery-ui.css">
  	<link rel="stylesheet" type="text/css" media="screen" href="../../assetss/manager/css/elfinder.min.css">
	<script type="text/javascript" src="../../assetss/manager/js/elfinder.min.js"></script>	
  	
  	<!-- elFinder web manager init -->
	<script type="text/javascript" charset="utf-8">
		$().ready(function() {
			var elf = $('#elfinder').elfinder({
				// lang: 'ru',             // language (OPTIONAL)
				url : 'assets/manager/php/connector.php'  // connector URL (REQUIRED)
			}).elfinder('instance');			
		});
	</script>
    <link href="../../assets/css/style.css" rel="stylesheet">
  <link href="../../assets/css/styles.css" rel="stylesheet">
  <link href="../../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <script src="../../assets/js/jquery-1.10.2.js"></script>
  <script src="../../assets/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
    a.pipGrid{
        text-decoration:none;
    }
  </style>
</head>
<body style="background-image:url(../../assets/img/bruno-abatti.jpg)">
    
<?php
include("../../functions/conne.php");
if(isset($_POST["shopName"])){
    $shopName = $_POST["shopName"];
    $icon = $imgUrls."shops.png";
    $sql = "INSERT INTO `shops` (`id`,
                                 `shopName`,
                                 `dateAdded`,
                                 `shopIcon`) 
                                 VALUES (NULL,
                                        '$shopName',
                                        CURRENT_TIMESTAMP,
                                        '$icon')";
            $res = mysqli_query($conn,$sql);
            if($res){
                ?>
                <script>
                    window.location = "../../shops/"
                </script>
                <?php
            }
    
    
}
   if(isset($_SESSION["sellers"]))
   {
       $userId = $_SESSION["sellers"];
       $sql = "SELECT * FROM `users` WHERE `userId` = $userId";
       $result = mysqli_query($conn,$sql);
       $SellerDets = mysqli_fetch_array($result,MYSQLI_ASSOC);
       include("menu.php");
?>

<div class="col-md-offset-1 col-md-10 panel panel-warning">

<div class="panel-body">
    <div class="alert alert-warning">
      <h1> add a shop </h1>
    </div>
    
   <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="email"> shop name :</label>
        <input type="text" class="form-control" name="shopName" id="" required>
      </div>
      <button type="submit" class="btn btn-info"> add </button>
    </form>
</div>
</div>
<br>
<br><br>
<?php
   }
?>

</body>
</html>
