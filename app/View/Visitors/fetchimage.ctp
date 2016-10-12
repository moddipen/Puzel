
<div id = 'ccontent'>
<?php 
      // Fetch Image From database 
    $i = 0;
      
    if ($drawimage_s > 0) 
    {?>
        <style>
      .merge div{width:<?php echo $image[0]['Image']['width']."px";?>;height:<?php echo $image[0]['Image']['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
      .merge{width:<?php echo $image[0]['Image']['total_width']."px";?>;}
      </style>
        <?php $peices = $PuzzleData['Puzzle']['pieces'] ; 
        // Number of peices of block
        if($peices == 25) {    $cut_width = 5;  $cut_height = 5; }
      elseif($peices == 50)  {   $cut_width = 10;   $cut_height = 5;  }
      elseif($peices == 75)  {   $cut_width = 15;   $cut_height = 5;  }
      else {   $cut_width = 10;  $cut_height = 10; }  ?>
    
        <div class="merge" >
        
           <?php 
           // for blank image get 
           // while ($image_data)
            foreach($image as $image_data)
              {
                
                // Get Image path 
              $path =  $this->webroot.'img/puzzel/user/'.$image_data['Image']['name'] ;
              $split = substr($image_data['Image']['name'], strrpos($image_data['Image']['name'], '_') + 1);
                
                if    ($split == "01.jpg")  {   $block = "1";   }
              elseif($split == "11.jpg")  {   $block = "2";   }
              elseif($split == "21.jpg")  {   $block = "3";   }
              elseif($split == "31.jpg")  {   $block = "4";   }
              elseif($split == "41.jpg")  {   $block = "5";   }
              elseif($split == "51.jpg")  {   $block = "6";   }
              elseif($split == "61.jpg")  { $block = "7";   }
              elseif($split == "71.jpg")  {   $block = "8";   }
              elseif($split == "81.jpg")  {   $block = "9";   }
              else  {   $block = "10";  }
              
            
                if($image_data['Image']['status'] == 0)
              {
                $class_image = "background:none;";
                $getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['Image']['name']); 
                $class_name = $getname  ;
              }
              else
              {
                $getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['Image']['name']); 
                $class_name = $getname  ;
                $class_image = "background:url('$path')"; 
              }
            
            if($i%$cut_width == 0)
            {
              if($block == "1") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }  
                if($block == "2") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "3") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "4") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "5") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "6") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "7") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "8") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "9") {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "10")  {?> <div class= "<?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
            }
               
          }
      echo "</div>";  
    }?>
  </div> 
  </div>