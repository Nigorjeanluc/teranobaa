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
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
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
  	<link rel="stylesheet" type="text/css" media="screen" href="assets/manager/css/elfinder.min.css">
	<script type="text/javascript" src="assets/manager/js/elfinder.min.js"></script>	
  	
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
<body   style="background-image:url(../assets/img/bruno-abatti.jpg)">
    
<?php
include("../functions/conne.php");
if(isset($_POST["login_user_name"])){
      $login_user_name = $_POST["login_user_name"];
      $login_user_password = $_POST["login_user_password"];
      
      // To protect from MySQL injection

    $email = stripslashes($login_user_name);
    $password = stripslashes($login_user_password);
    $email = mysqli_real_escape_string($conn,$email);
    $password = mysqli_real_escape_string($conn, $password);
    $password = md5($password);
    $sql = "SELECT `userId` FROM `users` WHERE `email`='$email' and `password`='$password'";
    //echo $sql;
    $result = mysqli_query($conn,$sql);
    if($result){
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC); 
       //If username and password exist in our database then create a session.
       //Otherwise echo error.
       if(mysqli_num_rows($result) == 1)
       {
       $_SESSION['sellers'] = $row['userId'];
       $_SESSION['types'] = $row['type'];// Initializing Session
       }
       else $error_message = "Incorect username or password";
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
<div class="container">
   <?php
     $sql0 = "SELECT * FROM `users` WHERE `userId` = $userId";
     $res = mysqli_query($conn,$sql0);
     
     $shopId = mysqli_fetch_array($res)[7];
     
     $sql = "SELECT * FROM `shops` WHERE `shops`.`id` = '$shopId'";
     $res = mysqli_query($conn,$sql);
    
     
     $shopId = "";
     $shopName = "";
     
     while($row = mysqli_fetch_array($res)){
         $shopId = $row[0];
         $shopName = $row[1];
     }
     
     
     $sql1 = "SELECT `productId` FROM `products` WHERE `products`.`shop` = $shopId";
     $res = mysqli_query($conn,$sql1);
     
     
     $nums = mysqli_num_rows($res);
     $sql2 = "SELECT `userId` FROM `shopusers` WHERE `shopusers`.`shopId` = $shopId";
     
     $res = mysqli_query($conn,$sql2);
     $nums_of_same_shop = mysqli_num_rows($res);
     
     $sql3 = "SELECT * FROM `orders` WHERE `shop` = '$shopId'";
     $res = mysqli_query($conn,$sql3);
     $nums_of_order_shop = mysqli_num_rows($res);
     
     $sql4 = "SELECT * FROM `usermessages` WHERE `shop` = '$shopId' AND `seen1` = 0";
     $res = mysqli_query($conn,$sql4);
     $nums_of_mess_shop = mysqli_num_rows($res);
     
   ?>
    <div class="row">
        <div class="col-sm-4 col-lg-4">
            <a href="../" class="pipGrid">
      		<div class="dash-unit">
                <br/>
				<div style="background: none; border: none" class="thumbnail">
					<i class="fa fa-product-hunt" style="font-size:7em"></i>
				</div><!-- /thumbnail -->
				<h1><span class="badge" style="font-size:1.5em"><?php echo $nums ?></span> product(s)</h1>
				<h3 style="font-size:1.5em">from <?php echo ucfirst($shopName) ?></h3>
			</div>
            </a>
        </div>
        <div class="col-sm-4 col-lg-4">
            <a href="../settings/sellers.php" class="pipGrid">
      		<div class="dash-unit">
                <br/>
				<div style="background: none; border: none" class="thumbnail">
					<i class="fa fa-users" style="font-size:7em"></i>
				</div><!-- /thumbnail -->
				<h1><span class="badge" style="font-size:1.5em"><?php echo $nums_of_same_shop ?></span> seller(s)</h1>
				<h3 style="font-size:1.5em">from <?php echo ucfirst($shopName) ?></h3>
			</div>
            </a>
        </div>
        <div class="col-sm-4 col-lg-4">
            <a href="#" class="pipGrid">
      		<div class="dash-unit">
                <br/>
				<div style="background: none; border: none" class="thumbnail">
					<i class="fa fa-shopping-cart" style="font-size:7em"></i>
				</div><!-- /thumbnail -->
				<h1><span class="badge" style="font-size:1.5em"><?php echo $nums_of_order_shop ?></span> order(s)</h1>
				<h3 style="font-size:1.5em">for <?php echo ucfirst($shopName) ?></h3>
			</div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 col-lg-4">
            <a href="../page/?client=0&demo=0" class="pipGrid">
      		<div class="dash-unit">
                <br/>
				<div style="background: none; border: none" class="thumbnail">
					<i class="fa fa-envelope" style="font-size:7em"></i>
				</div><!-- /thumbnail -->
				<h1><span class="badge  realTMessage" style="font-size:1.2em"><?php echo $nums_of_mess_shop ?></span> new Message(s)</h1>
			</div>
            </a>
        </div>
        <div class="col-sm-4 col-lg-4">
            <a href="../page/?client=0&demo=0" class="pipGrid">
      		<div class="dash-unit">
                <br/>
				<div style="background: none; border: none" class="thumbnail">
					<i class="fa fa-bell" style="font-size:7em"></i>
				</div><!-- /thumbnail -->
				<h1><span class="badge realTNotific" style="font-size:1.5em"></span> new notification(s)</h1>
			</div>
            </a>
        </div>
        <div class="col-sm-4 col-lg-4">
            <a href="#" class="pipGrid">
      		<div class="dash-unit">
                <br/>
				<div style="background: none; border: none" class="thumbnail">
					<i class="fa fa-cart-arrow-down" style="font-size:7em"></i>
				</div><!-- /thumbnail -->
				<h1><span class="badge" style="font-size:1.5em"></span><br> total products sold</h1>
			</div>
            </a>
        </div>
        <div class="col-sm-4 col-lg-4">
            <a href="../settings/settings.php" class="pipGrid">
      		<div class="dash-unit">
                <br/>
				<div style="background: none; border: none" class="thumbnail">
					<i class="fa fa-cogs" style="font-size:7em"></i>
				</div><!-- /thumbnail -->
				<h1><span class="badge" style="font-size:1.5em"></span><br>My Account</h1>
			</div>
            </a>
        </div>
    </div>
</div><br>
<br><br>
<script>
            function realTime(){
                      $(".realTMessage").load("https://www.teranoba.com/sellers/adminfunctions/admini_number_of_messages.php");
                      $(".realTNotific").load("https://www.teranoba.com/sellers/adminfunctions/number_of_notification.php");
                      setTimeout(function(){ 
                            realTime();    
                                 },3000);
                    }
             //realTime();
             //realTime();
        </script>
<?php
   }
   else {
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 col-sm-offset-4 login_bg">
			<h2><?php echo $error_message; ?></h2>
			<form method="POST" action="https://www.teranoba.com/sellers/">
				<div class="form-group">
					<input type="text" placeholder="User Email" name="login_user_name" id="login_user_name" class="form-control" required>
				</div>
				<div class="form-group">
					<input type="password" placeholder="User Password" name="login_user_password" id="login_user_password" class="form-control" required>
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
