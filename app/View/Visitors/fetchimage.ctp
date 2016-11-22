
<!-- <div id = 'puzzle1'> -->
<?php 
      // Fetch Image From database 
    $i = 0; 
      
    if ($drawimage_s > 0) 
    {?>
        <style>
      .merge div div{width:<?php echo $image[0]['width']."px";?>;height:<?php echo $image[0]['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
      .merge{width:<?php echo $image[0]['total_width']."px";?>;}
      </style>
        <?php $peices = $PuzzleData['Puzzle']['pieces'] ; 
        // Number of peices of block
        // if($peices == 25) {    $cut_width = 5;  $cut_height = 5; }
        // elseif($peices == 50)  {   $cut_width = 10;   $cut_height = 5;  }
        // elseif($peices == 75)  {   $cut_width = 15;   $cut_height = 5;  }
        // else {   $cut_width = 10;  $cut_height = 10; }  ?>
    
        <div class="merge" >
          <div>
           <?php 
           // for blank image get 
           // while ($image_data)
			   $index = 0;
            foreach($image as $image_data)
              {
                
                // Get Image path 
              $path =  Configure::read("SITE_URL").'/img/puzzel/'.$PuzzleData['Puzzle']['name'].'/'.$image_data['name'] ;
              // $split = substr($image_data['name'], strrpos($image_data['name'], '_') + 1);
                
              //   if    ($split == "01.jpg")  {   $block = "1";   }
              // elseif($split == "11.jpg")  {   $block = "2";   }
              // elseif($split == "21.jpg")  {   $block = "3";   }
              // elseif($split == "31.jpg")  {   $block = "4";   }
              // elseif($split == "41.jpg")  {   $block = "5";   }
              // elseif($split == "51.jpg")  {   $block = "6";   }
              // elseif($split == "61.jpg")  { $block = "7";   }
              // elseif($split == "71.jpg")  {   $block = "8";   }
              // elseif($split == "81.jpg")  {   $block = "9";   }
              // else  {   $block = "10";  }
              
            
                if($image_data['status'] == 0)
              {
                $class_image = "background-display:none;";
                $getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['name']); 
                $class_name = $getname  ;
              }
              else
              {
                $getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['name']); 
                $class_name = $getname  ;
                $class_image = "background:url('$path')"; 
              }
            
              $get_image_part = explode("_",$image_data['Image']['name']);
             if($get_image_part[1] == 0 && $index != 0)
               {
                 echo "</div><div>";
               }  
              
            ?> 
              <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div>  
                   <?php
            
                     $index ++;
            }
          echo "</div>";
    }?>
<div class="six columns" >
      <div id="alert"></div>
      <div id ="success"></div>  
      <form id="Imagedata">
          <div class="form-group" id="firsname">
            <input type="text" name="firstname" id="fname" class="form-control" placeholder="First Name"  required>
          </div>
          <div class="form-group" id="laname">
            <input type="text" name="lastname"   id="lname"  class="form-control" placeholder="Last Name" required>
          </div>
          <div class="form-group" id="useemail">
             <input type="email" name="email"  id="useremail"  class="form-control" placeholder="Email" required>
          </div>
  
            <input type = "hidden" name ="puzzlename" value = "<?php echo $PuzzleData['Puzzle']['name'];?>">
            <input type = "hidden" name ="transition" id="transition" value = "<?php echo $PuzzleData['Puzzle']['transtion'];?>">
            <input type = "hidden" name ="signwithpuzzleaccount" id ="signwithpuzzleaccount" value = "">
            <div class="form-group text-center">
              <button type="submit" class="btn button-sign" id="normalsign">Submit</button><button type="submit" class="btn button-sign" id="puzelacount" name="puzzle" value = "1">Signup with Puzel Account</button>
            </div>
        </form>
    </div>