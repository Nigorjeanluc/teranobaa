<?php
  session_start();
  $error_message = "login first";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> teranoba sellers page </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="../assets/img/newLogo.png"/>
  <!-- Le styles -->
    <link href="../assetss/css/bootstrap.css" rel="stylesheet">
    <link href="../assetss/css/main.css" rel="stylesheet">
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
  	<link rel="stylesheet" type="text/css" media="screen" href="../assetss/manager/css/elfinder.min.css">
	<script type="text/javascript" src="../assetss/manager/js/elfinder.min.js"></script>	
  	
  	<!-- elFinder web manager init -->
	<script type="text/javascript" charset="utf-8">
		$().ready(function() {
			var elf = $('#elfinder').elfinder({
				// lang: 'ru',             // language (OPTIONAL)
				url : 'assets/manager/php/connector.php'  // connector URL (REQUIRED)
			}).elfinder('instance');			
		});
	</script>
    <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/styles.css" rel="stylesheet">
  <link href="../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <script src="../assets/js/jquery-1.10.2.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
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
<body style="background-image:url(../assets/img/bruno-abatti.jpg)">
    
<?php
include("../functions/conne.php");
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
   <?php
     $sql = "SELECT * FROM `shops` WHERE `shops`.`admin` = '$userId'";
     $res = mysqli_query($conn,$sql);
     $shopId = mysqli_fetch_array($res,MYSQLI_BOTH)[0];
     $sql = "SELECT * FROM `shops`";
     $res = mysqli_query($conn,$sql);
     $nums = mysqli_num_rows($res);
     $status = array("NO","YES");
     $status_class = array("alert-danger","alert-success");
   ?>
   <div class="alert alert-info">
      <strong><?php echo $nums ?>(s) total shop found </strong>
    </div>
   <a href="add/" type="button" class="btn btn-info"><i class="fa fa-plus"></i> add more shops </a>
    <table class="table">
      <thead>
      <tr>
        <th> # </th>
        <th> name </th>
        <th> Icon </th>
        <th> edit </th>
        <th> delete </th>
      </tr>
    </thead>
      <?php
      $numbering = 1;
      while($rows = mysqli_fetch_array($res,MYSQLI_BOTH))
      {
      ?>
      <tr>
        <td><?php echo $numbering ?></td>
        <td><?php echo $rows['shopName'] ?></td>
        <td><img src="<?php echo $rows['shopIcon'] ?>" class="img-circle" width="50" alt="<?php echo $rows['shopName'] ?>"></td>
        <td><a class="btn btn-info ?> " href="details/?us=<?php echo $rows["id"]?>&action=edit"> <i class="fa fa-pencil"></i></a></td>
        <td><a class="btn btn-danger" href="details/?us=<?php echo $rows["id"]?>&action=remo"> <i class="fa fa-trash"></i></a></td>
      </tr>
    <?php
    $numbering++;
      }
    ?>
    </table>
    <a href="add/" type="button" class="btn btn-info"><i class="fa fa-plus"></i> add more shops </a>
</div>
</div>
<br>
<br><br>
<?php
   }
   else {
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 login_bg">
			<h2><?php echo $error_message; ?></h2>
			<form method="POST" action="">
				<div class="form-group">
					<input type="text" placeholder="User Email" name="login_user_name" id="login_user_name" class="form-control" required>
				</div>
				<div class="form-group">
					<input type="text" placeholder="User Password" name="login_user_password" id="login_user_password" class="form-control" required>
				</div> 
				<input type="submit" name="login_btn" id="login_btn" class="btn btn-block login_btn btn-warning" value="Login"/>
			</form>
		</div>
	</div>
</div>
<?php
}

?>

</body>
</html>
