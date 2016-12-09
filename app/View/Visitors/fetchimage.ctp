
<div id="container" class="page-hosted">
<h2 class="text-center title-page"><?php echo $explode[6];?></h2>
 <div class="row"> 
  <div class="col-md-12">
    <div id="puzzle">
      <div id="contentfield">

<!-- <div id = 'puzzle1'> -->
<?php 
      // Fetch Image From database 
    $i = 0;
      
    if ($drawimage_s > 0) 
    {?>
        <style>
      .merge div div{width:<?php echo $image[0]['Image']['width']."px";?>;height:<?php echo $image[0]['Image']['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
      .merge{width:<?php echo $image[0]['Image']['total_width']."px";?>;}
      </style>
        <?php $peices = $PuzzleData['Puzzle']['pieces'] ; 
        // Number of peices of block
        // if($peices == 25) {    $cut_width = 5;  $cut_height = 5; }
        // elseif($peices == 50)  {   $cut_width = 10;   $cut_height = 5;  }
        // elseif($peices == 75)  {   $cut_width = 15;   $cut_height = 5;  }
        // else {   $cut_width = 10;  $cut_height = 10; }  ?>
    
        <div class="merge pt-perspective">
      <div>
           <?php 
       $index = 0;
            foreach($image as $image_data)
              {
                
                // Get Image path 
              $path =  $this->webroot.'img/puzzel/'.$PuzzleData['Puzzle']['name'].'/'.$image_data['Image']['name'] ;
              // $split = substr($image_data['Image']['name'], strrpos($image_data['Image']['name'], '_') + 1);
                
                // if    ($split == "01.jpg")  {   $block = "1";   }
              // elseif($split == "11.jpg")  {   $block = "2";   }
              // elseif($split == "21.jpg")  {   $block = "3";   }
              // elseif($split == "31.jpg")  {   $block = "4";   }
              // elseif($split == "41.jpg")  {   $block = "5";   }
              // elseif($split == "51.jpg")  {   $block = "6";   }
              // elseif($split == "61.jpg")  { $block = "7";   }
              // elseif($split == "71.jpg")  {   $block = "8";   }
              // elseif($split == "81.jpg")  {   $block = "9";   }
              // else  {   $block = "10";  }
              
            
                if($image_data['Image']['status'] == 0)
              {
                $class_image = "background-display:none;";
                $getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['Image']['name']); 
                $class_name = $getname  ;
              }
              else
              {
                $getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['Image']['name']); 
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
  </div> 
  <!-- </div> -->
      </div>
    </div>
    </div>
 
<div class="row">
  <div class="six columns">
      <div class="share-social">
          <h3>Share with your friends</h3>
              <?php if(isset($Refrel))
              { ?>
                  <a class="share-btn" href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.$explode[5].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo $explode[5];?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="facebook">f</i></a>
                  <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.$explode[5].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" data-size="large" target = "_blank"><i class="twitter">l</i>
                  <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $explode[5];?>&body=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.$explode[5].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')"  target="_blank">
                  <i class="windows">w</i></a>


                  <a class="icon-gplus" href ="https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $explode[5];?>&body=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.$explode[5].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')">
                  <i class="email">m</i></a> 

              <?php }
              else
              { ?>
                  <a class="share-btn" href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="facebook">f</i></a>
                   <a class="twitter-share-button"
                    href="https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" data-size="large" target = "_blank"><i class="twitter">l</i>
                  <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&body=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')"  target="_blank">
                  <i class="windows">w</i></a>
                  

                  <a class="icon-gplus" href ="https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&body=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')">
                  <i class="email">m</i></a>
              <?php } ?>


            
        </div>
    </div>
    <?php if($ShowPuzzel['Show'] != 0) {?>
    <div class="six columns" >
      <div class="form-group">
        <button type="button" class="btn button-sign btn-tab active" id="puzelasubmit" name="puzzle">Signup for Puzel</button>
        <button type="button" class="btn button-sign btn-tab" id="enrollformshow">Enroll Now</button>
      </div>
      <div id="alert"></div><br/>
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
            <?php if(isset($Refrel))
              {?>
                <input type = "hidden" name ="refrel" value = "1">
                <input type = "hidden" name ="refrel_id" value = "<?php echo $PuzzleData['Puzzle']['user_id']?>">
            <?php }?>
            <input type = "hidden" name ="puzzlename" value = "<?php echo $explode[6];?>">
            <input type = "hidden" name ="signwithpuzzleaccount" id ="signwithpuzzleaccount" value = "">
            <div class="form-group">
              <button type="submit" class="btn button-sign" id="puzelacount" name="puzzle" value = "1" style="width:100%">Submit</button>
              <!-- button type="button" class="btn button-sign" id="enrollformshow">Enroll Now</button> -->
            </div>
        </form>
        <form id="Imageenroll" style="display:none;padding-top: 25px;">
          <div class="form-group" id="usenrollemail">
             <input type="email" name="email1"  id="userenrollemail"  class="form-control" placeholder="Email" required>
          </div>
          <div class="form-group" id="pasword">
            <input type="password" name="password"   id="password"  class="form-control" placeholder="Password" required>
          </div>
          
            <?php if(isset($Refrel))
              {?>
                <input type = "hidden" name ="refrel" value = "1">
                <input type = "hidden" name ="refrel_id" value = "<?php echo $PuzzleData['Puzzle']['user_id']?>">
            <?php }?>
            <input type = "hidden" name ="puzzlename" value = "<?php echo $explode[6];?>">
            <input type = "hidden" name ="enrollwithpuzzleaccount" id ="enrollwithpuzzleaccount" value = "">
            <div class="form-group">
              <!-- <button type="button" class="btn button-sign" id="puzelasubmit" name="puzzle" >Submit</button> -->
              <button type="submit" class="btn button-sign" id="normalsign" value = "2" style="width:100%">Enroll Now</button>
            </div>
        </form>
    </div>
    <?php }?>
</div>
</div> <!-- end of container -->

<?php } 
  else
    {?>

        <h1> Puzzle has been deactivated </h1>


  <?php   } ?>
 <script>
$(document).ready(function()
{
    $('#collapse-menu').on('click', function(){
    if($(this).hasClass('active'))
    {
       $(this).removeClass('active');
    }
    else
    {
       $(this).addClass('active');
    }
    });

    // hide submit form when click on enroll button

    $("#enrollformshow").on("click",function()
    {
        $(this).siblings().removeClass('active')
        $("#Imagedata").css('display','none');
        $("#Imageenroll").css('display','block');
        $(this).addClass('active');
    });
    
    // hide enroll form when click on submit button    
    $("#puzelasubmit").on("click",function()
    {
        $(this).siblings().removeClass('active')
        $("#Imageenroll").css('display','none');
        $("#Imagedata").css('display','block');
        $(this).addClass('active');
    });




});
</script>





<!--  Grand prize model -->
    <div class="modal fade orange" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modalDialogLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
            <h3 class="modal-title" id="modalDialogLabel">Grand Prize</h3>
          </div>
          <div class="modal-body">
            <form class="popup-form">
              <div class="form-group">
        <?php
          if($PuzzleData['Puzzle']['type'] == "Mystery")
          {
            $blurr_class = "blur";
          }
          else
          {
            $blurr_class = "";
          }
        ?>
                <div style="margin-bottom:40px;"> <?php echo $PuzzleData['Puzzle']['price'];?></div>
        <div>        
        <?php
            if($PuzzleData['Puzzle']['price_image'] != "")
            {
          ?>
               <div id="<?php echo $blurr_class;?>" style="background:url('<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>')">
                <!-- <a href = "<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>" target="_blank"> --><img src = "<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>"  width="540px"/><!-- </a> --> 
              </div>
          <?php
            }
          ?>
          </div>
                <!-- <textarea name="textarea" id="textarea" class="form-control wysiwyg"></textarea> -->
              </div>
             </form>
          </div>
         </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--Modal-->

    <!--Modal Term -->
     <div class="modal fade orange" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modalDialogLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
            <h3 class="modal-title" id="modalDialogLabel">Terms / Description</h3>
          </div>
         <div class="modal-body">
          <form class="popup-form" id="terms" >
            <div class="form-group">
              <div> <?php echo $PuzzleData['Puzzle']['terms'];?></div>

              <!-- <textarea name="textarea" id="textarea" class="form-control wysiwyg"></textarea> -->
            </div>
        </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
