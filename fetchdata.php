<script type="text/javascript">
	$("#Imagedata").submit(function(e)
	{
	  var url = "process.php"; // the script where you handle the form input.
	 // Form Submit Ajax 	
	  $.ajax({
             type: "POST",
             url: url,
             dataType: 'json', 
             data: $("#Imagedata").serialize(), // serializes the form's elements.
             success: function(data)
             {
                if(data = jQuery.parseJSON( '{ "message": "success" }' ))
                {
                 	// if Insert Success then after show Image
                 	$.ajax
                 	({
			           type: "POST",
			           url: "fetchdata.php",
			           data:'' ,
			           success:function(data)
			           {
			           		$("#content").html(data);
			           }
			        });
				}
             }
           });

      e.preventDefault(); // avoid to execute the actual submit of the form.
  });	
</script>
<div>
	<div class="getdata"> 
		
		<!--  Insert User Detail -->
		<form id="Imagedata">
		  <h3>Please Insert Form Detail</h3>
		  <input type ="text" name="firstname" placeholder="First Name" required/> <br>
		  <input type ="text" name="lastname" placeholder="Last Name" required/><br>
		  <input type ="text" name="email" placeholder="Email" required/><br>
		  <input type = "submit" name="frmsubmit"value ="Submit">
		</form> 

	<?php 
 		
 		// Database Connection 
 		include('connection.php');
  		
  		// Fetch Image From database 
  		$get_filldata = "SELECT name,status,width,height,total_width FROM images where user_id = 1";
  		
  		$drawimage_s = $conn->query($get_filldata);
		$image_data_s = mysqli_fetch_array($drawimage_s);
		$i = 0;
  		
		if (mysqli_num_rows($drawimage_s) > 0) 
		{?>
		  	<style>
			.merge div{width:<?php echo $image_data_s['width']."px";?>;height:<?php echo $image_data_s['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
			.merge{width:<?php echo $image_data_s['total_width']."px";?>;}
			</style>
  			<?php $peices = mysqli_num_rows($drawimage_s) ; 
		  	// Number of peices of block
		  	if($peices == 25) {    $cut_width = 5;  $cut_height = 5; }
			elseif($peices == 50)  {   $cut_width = 10;   $cut_height = 5;  }
			elseif($peices == 75)  {   $cut_width = 15;   $cut_height = 5;  }
			else {   $cut_width = 10;  $cut_height = 10; }	
	  		
	  		$drawimage = $conn->query($get_filldata);?>
	  
     		<div class="merge" >
	    	
			     <?php 
			     // for blank image get 
			     while ($image_data = mysqli_fetch_array($drawimage))
			  	  	{
			  	  		
			  	  		// Get Image path 
			  	  		$path =  "http://".$_SERVER['HTTP_HOST']."/Puzzel/output/".$image_data['name'] ;
				    	$split = substr($image_data['name'], strrpos($image_data['name'], '_') + 1);
				        
				        if    ($split == "01.jpg")  { 	$block = "1";   }
					    elseif($split == "11.jpg")  { 	$block = "2";   }
					    elseif($split == "21.jpg")  {  	$block = "3";   }
					    elseif($split == "31.jpg")  {  	$block = "4";   }
					    elseif($split == "41.jpg")  {   $block = "5"; 	}
					    elseif($split == "51.jpg")  {   $block = "6";   }
					    elseif($split == "61.jpg")  {	$block = "7";   }
					    elseif($split == "71.jpg") 	{ 	$block = "8";   }
					    elseif($split == "81.jpg")  {  	$block = "9";   }
					    else  {  	$block = "10";  }
					    
					  
			  		    if($image_data['status'] == 0)
				  		{
				  			$class_image = "background:#ccc none repeat scroll 0 0;";
				  			$getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['name']);	
				  			$class_name = $getname	;
				  		}
				  		else
				  		{
				  			$getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['name']);	
				  			$class_name = $getname	;
				  			$class_image = "background:url('$path')";	
				  		}
						
						if($i%$cut_width == 0)
						{
							if($block == "1")	{?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }  
					  		if($block == "2")	{?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
					  		if($block == "3")	{?>	<div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
					   		if($block == "4")	{?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
						  	if($block == "5")	{?>	<div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
					  		if($block == "6")	{?>	<div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
					  		if($block == "7")	{?>	<div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
					  		if($block == "8")	{?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
					  		if($block == "9")	{?>	<div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
						  	if($block == "10")	{?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
						}
							 
					}
			echo "</div>";	
		}?>
	</div>
</div>	