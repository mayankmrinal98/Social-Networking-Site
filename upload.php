<?php include('connect.php');?>	
<?php include('session.php');?>	

<html>
<script type="text/javascript">
<!--
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 
// -->
</script>
<head><title>Edit Picture</title></head>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="./js/jquery-1.4.2.min.js"></script>
	<link href="facebox1.2/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
			<link href="../css/example.css" media="screen" rel="stylesheet" type="text/css" />
			<script src="facebox1.2/src/facebox.js" type="text/javascript"></script>
			<script type="text/javascript">

jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox() 
  	closeImage   : " ../src/closelabel.png" 
})
</script>

<link href="home.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url(images/New%20Picture.jpg);
	background-repeat: repeat-x;
}
.style1 {font-weight: bold}
-->
</style>
<body>
<div class="main">
<div class="lefttop1">
  <div class="lefttopleft"><img src="img/logo.png" width="150" height="40" /></div>
   <div class="propic">
	<?php

$id= $_SESSION['SESS_MEMBER_ID'];	
$image=mysqli_query($connection,"SELECT * FROM members WHERE member_id='$id'");
			$row=mysqli_fetch_assoc($image);
			$_SESSION['image']= $row['profImage'];
			echo '<div id="pic">';
			echo "<a href=".$row['profImage']." rel=facebox;><img width=140 height=140 alt='Unable to View' src='" . $_SESSION['image'] . "'></a>";
			echo '</div>';

?>
</div>
<ul id="sddm1">
	<li><a href="editpic.php"><img src="img/pencil.png" width="17" height="17" border="0" /> &nbsp;Change Picture</a>
	</li>
	<li><a href="Home.php"><img src="img/wal.png" width="17" height="17" border="0" /> &nbsp;Wall</a>
	</li>
	<li><a href="info.php"><img src="img/message.png" width="16" height="12" border="0" /> &nbsp;Info</a>
	</li>
	<li><a href="photos.php"><img src="img/photos.png" width="16" height="12" border="0" /> &nbsp;Photos(<?php
$result = mysqli_query($connection,"SELECT * FROM photos WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");
	
	$numberOfRows = mysqli_num_rows($result);	
	
	echo '<font color="red">' . $numberOfRows . '</font>'; 
	?>)	</a>
	</li>
	<li><a href="request.php"><img src="img/friends.png" width="16" height="12" border="0" /> &nbsp;Friends Request
	(<?php 
					
					$member_id=$_SESSION['SESS_MEMBER_ID'];
					$seeall=mysqli_query($connection,"SELECT * FROM friends WHERE friends_with='$member_id' AND status='unconf'") or die(mysqli_error($connection));
					$numberOFRows=mysqli_num_rows($seeall);
					echo '<font color="red">'.$numberOFRows.'</font>';?>)
					</a>
	</li>
	<li><a href="message.php"><img src="img/m.png" width="16" height="12" border="0" /> &nbsp;Message(<?php 
$result = mysqli_query($connection,"SELECT * FROM messages WHERE recipient='".$_SESSION['SESS_MEMBER_ID'] ."'");
	
	$numberOfRows = mysqli_num_rows($result);	
	echo '<font color="red">' . $numberOfRows. '</font>';
	?>)
	</a>
	</li>
	
	<li><hr width="150"></li>
	<li>
	</ul>
	<div class="friend">
	<ul id="sddm1">
	<li><a href=""><img src="img/friends.png" width="16" height="12" border="0" /> &nbsp;Friends
	
	(<?php


		$id=$_SESSION['SESS_MEMBER_ID'];
	mysqli_query($connection,"CREATE TEMPORARY TABLE IF NOT EXISTS inbox AS (select member_id from friends where friends_with='$id' and status='conf')")or die(mysqli_error($connection));
	mysqli_query($connection,"insert into inbox select friends_with from friends where member_id='$id' and status='conf' ")or die(mysqli_error($connection));
	$result = mysqli_query($connection,"SELECT * FROM members where member_id in (select * from inbox) and member_id!='$id' ");
	$numberOfRows = mysqli_num_rows($result);	
	echo '<font color="Red">' . $numberOfRows. '</font>';
	?>)
	</a>
	</li>
	</ul>
	<ul id="sddm1">
  <?php
							
							
			if ($numberOfRows != 0 ){

								while($row = mysqli_fetch_array($result)){
				
								$myfriend = $row['member_id'];
								$id=$_SESSION['SESS_MEMBER_ID'];
								
																
										$friends = mysqli_query($connection,"SELECT * FROM members WHERE member_id = '$myfriend'")or die(mysqli_error($connection));
										$friendsa = mysqli_fetch_array($friends);
										
									echo '<li> <a href=friendprofile.php?id='.$row["member_id"].' style="text-decoration:none;"><img src="'. $row['profImage'].'" height="50" width="50"></li><br><li>'.$row['FirstName'].' '.$row['LastName'].' </a> </li>';
										
									}
					}else
					{
						echo 'You don\'t have friends </li>';
					}
					mysqli_query($connection,"drop table inbox");	
						
							
							?>
							</ul>
							<ul id="sddm1">
							<li><hr width="150"></li>
							</ul>
</div>							
  </div>
  <div class="righttop1">
       <div class="search">
      <form action="" method="GET">
        <input name="query" type="text" maxlength="30" class="textfield"  value="search"/>
      </form>
</div>
    <div class="nav">
      <ul id="sddm">
        <li><a href="profile.php" ><?php


$result = mysqli_query($connection,"SELECT * FROM members WHERE member_id='".$_SESSION['SESS_MEMBER_ID'] ."'");
while($row = mysqli_fetch_array($result))
  {
  echo "<img width=20 height=15 alt='Unable to View' src='" . $row["profImage"] . "'>";
echo"  ";
  echo $row["FirstName"];
  echo"  ";
  echo $row["LastName"];
  }

?></a></li>
      <li><a href="Home.php">Home</a></li>
               <li><a  href="#"onmouseover="mopen('m5')" onmouseout="mclosetime()">Account</a>
          <div id="m5" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
</a>
        
		<a href="logout.php"><font size="2" class="font1">Logout</font></a>
        </li>
      </ul>
      <div style="clear:both"></div>
      <div style="clear:both"></div>
    </div>
  </div>
  
  </div>
  
<div class="right">
	<div class="rightright">
	
	 </div>

	   <div class="shout">

<div class="information">

</div>
</div> 
<div class="shoutout">

		<div  class="back"><h4><class="p"><div></h4></div>
		</br>
       <form  method="post" enctype="multipart/form-data">
 <div class="color"><h2>Upload Photos:</h2></div>
  </br>
  Select Picture
 <input type="file" name="image" class="font"> 
  </br>
 	<input name="member_id" type="hidden"  value="<?php echo $_SESSION['SESS_MEMBER_ID'];?>"/>
    <input type="submit" value="Upload" class="greenButton">
        
</form>
</div>
</div>
	  
	 </div>
	</div>

<?php





	if (!isset($_FILES['image']['tmp_name'])) {
	echo "";
	}else{
	$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name= addslashes($_FILES['image']['name']);
	$image_size= getimagesize($_FILES['image']['tmp_name']);
	$size=$_FILES['image']['size'];

	
		if ($_FILES['image']['error']> 0){
				die("Error uploading file! Code $error.");
			}else{
				if($size > 10000000) //conditions for the file
				{
				die("Format is not allowed or file size is too big!");
				}
		else{
			
			move_uploaded_file($_FILES["image"]["tmp_name"],"upload/" . $_FILES["image"]["name"]);			
			$location="upload/" . $_FILES["image"]["name"];
			$by=$_POST['member_id'];
		

			$sql="INSERT INTO photos (location, member_id)
VALUES
('$location','$by')";

if (!mysqli_query($connection,$sql))
  {
  die('Error: ' . mysqli_error($connection));
  }
//header("location: photos.php");
exit();

			
			}
	}
}


?>

</body>