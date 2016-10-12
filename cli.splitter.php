<?php
###############################################################################
#
#   Script Name: cli.splitter.php
#   Description: split large pictures into small pieces
#   Copyright (C) 2007 Jiang Kuan
#   
#   Usage: php -q ./cli.splitter.php [source image] [target folder]
#       [source image] -- image to be splitted
#       [target folder] -- path where you wish to store the splitted files
#   
#   This program is free software: you can redistribute it and/or modify
#   it under the terms of the GNU General Public License as published by
#   the Free Software Foundation, either version 3 of the License, or
#   (at your option) any later version.
#   
#   This program is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU General Public License for more details.
#   
#   You should have received a copy of the GNU General Public License
#   along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
###############################################################################
  // make database connection 

  include('connection.php');
  if(isset($_FILES))
  {
    $argv = $_FILES['cropoimage']['tmp_name'];
  }

  $info = getimagesize($argv);
  $width=$info[0];
  $height=$info[1];
  $image_type = $info['mime'];
  $peices = $_POST['pieces'];

  if($peices == 25)
  {
    $cut_width = 5;
    $cut_height = 5;
  }
  elseif($peices == 50)
  {
    $cut_width = 10;
    $cut_height = 5; 
  }
  elseif($peices == 75)
  {
    $cut_width = 15;
    $cut_height = 5; 
  }
  else
  {
    $cut_width = 10;
    $cut_height = 10; 
  }



	  $output = imagecreatetruecolor($width/$cut_width, $height/$cut_height);
    $storewidth = $width/$cut_width;
    $storeheight = $height/$cut_height;
    


    if($image_type == 'image/jpeg')
    {
      $orig = imagecreatefromjpeg($argv);
    }
    elseif($image_type == 'image/gif')
    {
       $orig = imagecreatefromgif($argv); 
    }  
    else
    {
      $orig = imagecreatefrompng($argv); 
    }  

  // for height loop
   for($i=0,$X=0 ; $i<$cut_height ; $i++)
   {
     // for width loop
	   for($j=0,$Y=0 ; $j<$cut_width ; $j++ )
	    {
  		  imagecopy($output, $orig,0,0,$Y,$X, $width/$cut_width, $height/$cut_height);
  		   $sql = "INSERT INTO images (user_id,name,width,height,total_width,created,modified)VALUES (1,'result_".$j.'_'.$i."1.jpg',$storewidth,$storeheight,$width,NOW(),NOW())";  
         $insert = mysqli_query($conn,$sql);

        if($insert)
        {
          //echo "Insert Successfully";  
        }else
        {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
          exit;
        }
        
        imagejpeg($output,"output/result_".$j.'_'.$i."1.jpg");
  		  $Y = $Y + $width/$cut_width; 
  		  // echo "$Y\t\t$X";
      }
	   
	   $X=$X+$height/$cut_height;
   }
   header('Location:http://localhost/Puzzel/viewimagblock.php'); 

//////   Show Image 

  
  ?>