#!/usr/local/php5/bin/php-cgi
<?php include 'config.php';
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
$error = mysqli_connect_error();
if ($error != null) {
  $output = "<p>Unable to connect to database</p>" . $error;
  exit($output);
} ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>SERVICES</title>
		<link rel="stylesheet" type="text/css" href="reset.css">
		<link rel="stylesheet" type="text/css" href="project.css">
	</head>
	<p>Student Project - not a commercial site.</p>	
<?php include 'header.php' ?>
	<main>
		<h1>SERVICES</h1>
		
      <?php 
      $i = 0; //counter for left/right class logic
      global $conn;
      $sql = "SELECT Type, ThumbnailUrl FROM Services;";
         $result = mysqli_query($conn, $sql);
         if($result=mysqli_query($conn, $sql)) {
            while($rows=mysqli_fetch_assoc($result)) { ?>
         <article>
            <img class="<?php if($i%2 == 0) echo "left"; else echo "right"; ?>" src="<?php echo $rows["ThumbnailUrl"]; ?>" alt="<?php echo $rows["Type"]; ?> Services" />
            <h2 class="<?php if($i%2 == 0) echo "right"; else echo "left"; ?>"><?php echo strtoupper($rows["Type"]); ?></h2>
            <p class="<?php if($i%2 == 0) echo "right"; else echo "left"; ?>">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet lacus sit amet libero facilisis pulvinar. Cras fermentum commodo suscipit.
            </p>
            
            <?php //!
            global $conn;
            $pSql = "SELECT Name, Price, Locations, Outfits, Duration FROM Packages WHERE ServiceType = '" .$rows["Type"]."' ORDER BY Duration;";
            $pResult = mysqli_query($conn, $pSql);
            if($pResult=mysqli_query($conn, $pSql)) {
               while($pRows=mysqli_fetch_assoc($pResult)) { ?>
               <div class="package <?php if($i%2 == 0) echo "right"; else echo "left"; ?>">
                  <h3 class="<?php if($i%2 == 0) echo "right"; else echo "left"; ?>"><?php echo strtoupper($pRows["Name"]); ?> PACKAGE</h3>
                  <p class="<?php if($i%2 == 0) echo "right"; else echo "left"; ?>">$<?php echo $pRows["Price"]; ?>
                  <?php if ($pRows["Locations"] !== NULL) { ?>
                  <br /><?php echo $pRows["Locations"]; ?> Location<?php if($pRows["Locations"] > 1) echo "s"; } ?>
                  <?php if ($pRows["Outfits"] !== NULL) { ?>
                  <br /><?php echo $pRows["Outfits"]; ?> Outfit<?php if($pRows["Outfits"] > 1) echo "s"; } ?>
                  <br /><?php echo $pRows["Duration"]; ?> Hour<?php if($pRows["Duration"] > 1) echo "s"; ?></p>
               </div>
            <?php }
               mysqli_free_result($pResult);
            } else { echo "No packages results<br>"; }?>
            
         <?php 
               $i++;
           ?> 
         </article> <?php }
            mysqli_free_result($result);
         } else { echo "No services results<br>"; }
         mysqli_close($conn); ?>
		
		<div class="clear"></div>
	</main>
   <?php include 'footer.php' ?>
</html>