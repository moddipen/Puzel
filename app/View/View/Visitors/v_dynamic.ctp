<?php
exit("ddfds");
  // Get current URl 
  $path = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  
  // Make parition or url and get puzzle name 
  $explode = explode('/',$path);
  


echo $this->Html->css('animations.css');
?>
<style>
 #blur{
	 -webkit-filter: blur(13px);
    -moz-filter: blur(13px);
    -o-filter: blur(13px);
    -ms-filter: blur(13px);
 filter: blur(13px);}
</style>
<script type="text/javascript">
var transition = '<?php echo $PuzzleData['Puzzle']['transtion'];?>';

    $( document ).ready(function() {  
      $("#puzelacount").click(function()
      {
        $("#signwithpuzzleaccount").val(1);
      });
      $("#normalsign").click(function()
      {
        $("#signwithpuzzleaccount").val(0);
      }); 
      $("#Imagedata").validate({
			rules: {
				firstname: "required",
				lastname: "required",
				email: {
					required: true,
					email: true
				}
			},
			messages: {
				firstname: "Please enter first name.",
				lastname: "Please enter last name.",
				email: "Please enter a valid email address.",
			}
		});


      $("#Imagedata").submit(function(e)
      {
         if($("#fname").val() == '')
         {
            //$("#firsname").after("<p>Please enter first name. </p>")
            return false;
         } 
         else if($("#lname").val() == '')
         {
            //$("#laname").after("<p>Please enter last name. </p>")
            return false;
         }
         else if($("#useremail").val() == '')
         {
            // var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            //$("#useemail").after("<p>Please enter an email. </p>")
            return false;

         } 
         else 
         {

            var url = "<?php echo Configure::read('SITE_URL')?>visitors/process/<?php echo $explode[6];?>"; 
             // Form Submit Ajax  
              $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#Imagedata").serialize(), // serializes the form's elements.
                       dataType: 'json', 
                       success: function(data)
                       {
                         if(data.message != "That email address has already taken. Please use another email.")
                          {
                            $.ajax
                              ({
                                 type: "POST",
                                 url: "<?php echo Configure::read('SITE_URL');?>visitors/fetchimage/"+data.image_id,
                                 dataType: 'text', 
                                 success:function(data)
                                 {
                                    var obj = $.parseJSON(data);
									obj = obj.name;
									objs = obj.split('.');
									var get_name = objs[0].split('_');
									$('.'+objs[0]).css("background-image","url('<?php echo $this->webroot;?>img/puzzel/"+get_name[0]+"/"+obj+"')");  //background:url('<?php echo $this->webroot;?>'img/puzzel/"+objs[0]+"/"+obj+"')");
									
									if(transition  == "Newspaper"){var classes = 'pt-page-rotateOutNewspaper pt-page-rotateInNewspaper pt-page-delay500';}
									if(transition  == "Cube to left"){var classes = 'pt-page-rotateCubeLeftOut pt-page-ontop pt-page-rotateCubeLeftIn';}
									if(transition  == "Cube to right"){var classes = 'pt-page-rotateCubeRightOut pt-page-ontop pt-page-rotateCubeRightIn';}
									if(transition  == "Cube to top"){var classes = 'pt-page-rotateCubeTopOut pt-page-ontop pt-page-rotateCubeTopIn';}
									if(transition  == "Cube to bottom"){var classes = 'pt-page-rotateCubeBottomOut pt-page-ontop pt-page-rotateCubeBottomIn';}
									if(transition  == "Flip right"){var classes = 'pt-page-flipOutRight pt-page-flipInLeft pt-page-delay500';}
									if(transition  == "Flip left"){var classes = 'pt-page-flipOutLeft pt-page-flipInRight pt-page-delay500';}
									if(transition  == "Flip top"){var classes = 'pt-page-flipOutTop pt-page-flipInBottom pt-page-delay500';}
									if(transition  == "Flip bottom"){var classes = 'pt-page-flipOutBottom pt-page-flipInTop pt-page-delay500';}
									
									$('.'+objs[0]).addClass(classes);
									// $("#puzzle").html(data);
                                    $("#Imagedata")[0].reset();
                                    $("#success").html("<div style='background:rgba(60,118,61,0.5);color:#3C763D;font-size:14px;padding:20px'> Register successfully.</div>");
                                    $("#success").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                 }
                            });
                          }
                          else
                          {
                            $("#alert").html("<p style='background:rgba(169,68,66,0.5);color:#A94442;font-size:14px;padding:20px;margin-bottom:10px;'>"+data.message+"</p>");
                            $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                          }
                          //$("#Imagedata")[0].reset();  
                       }
                     });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            } 
          });  
          




        
      }); 
    </script>
<!-- NAVIGATION ############################################### -->



<?php 
  if(!empty($PuzzleData)) {?>

    <!-- Mobile Menu --> 
    <div class="mobile-menu" style="padding-bottom: 55px;">
      <section id="collapse">
        <div class="row">
          <div class="mobile-menu-inner">
            <ul class="nav-mobile">
            
             <li><a href="#">Grand Prize</a></li>
            </ul>
          </div>
        </div>
      </section>
      
      <a href="#"><img src="<?php echo $this->webroot;?>img/visitor/img/logo.png" style="float: left; width: 75px; padding: 5px; margin-left: 15px;"></a>
      <a href="#" id="collapse-menu" style="float: right">
        <button class="navbar-toggle">
          <span class="icon-bar top-bar"></span>
          <span class="icon-bar middle-bar"></span>
          <span class="icon-bar bottom-bar"></span>
        </button>
      </a>
    </div>
    <!--  Menu --> 
    <div class="cbp-af-header">
      <nav class="row">
         <div id="logo"><a href="index.php"><img src="<?php echo $this->webroot;?>img/visitor/img/logo.png"></a></div>
        
         <ul id="nav">
            
            <li class="no-right"><a href="#" data-toggle="modal" data-target="#modal1"><span class="button-sign">Terms / Descrption</span></a></li>                     
            <li class="no-right"><a href="#" data-toggle="modal" data-target="#modal3"><span class="button-sign">Grand Prize</span></a></li>                     
         </ul>
       
      </nav>
    
    </div> 


<!-- END NAVIGATION ############################################### -->


<!-- HEADER ############################################### -->





<!-- END HEADER ############################################### -->

<!-- BEGIN CONTAINER ############################################### -->


<div id="container" class="page-hosted">
<h2 class="text-center title-page">Smart Weigh May Giveaway</h2>
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
      .merge div{width:<?php echo $image[0]['Image']['width']."px";?>;height:<?php echo $image[0]['Image']['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
      .merge{width:<?php echo $image[0]['Image']['total_width']."px";?>;}
      </style>
        <?php $peices = $PuzzleData['Puzzle']['pieces'] ; 
        // Number of peices of block
        if($peices == 25) {    $cut_width = 5;  $cut_height = 5; }
        elseif($peices == 50)  {   $cut_width = 10;   $cut_height = 5;  }
        elseif($peices == 75)  {   $cut_width = 15;   $cut_height = 5;  }
        else {   $cut_width = 10;  $cut_height = 10; }  ?>
    
        <div class="merge pt-perspective">
        
           <?php 
		   $index = 0;
            foreach($image as $image_data)
              {
                
                // Get Image path 
              $path =  $this->webroot.'img/puzzel/'.$PuzzleData['Puzzle']['name'].'/'.$image_data['Image']['name'] ;
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
            
            if($i%$cut_width == 0)
            {
              if($block == "1") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }  
                if($block == "2") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "3") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "4") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "5") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "6") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "7") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "8") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "9") {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
                if($block == "10")  {?> <div class= "pt-page pt-page-<?php echo $index;?> <?php echo $class_name ;?>" style = "<?php echo $class_image ;?>"></div> <?php }
            }
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
            <?php if(isset($Refrel))
              {?>
                <input type = "hidden" name ="refrel" value = "1">
                <input type = "hidden" name ="refrel_id" value = "<?php echo $PuzzleData['Puzzle']['user_id']?>">
            <?php }?>
            <input type = "hidden" name ="puzzlename" value = "<?php echo $explode[5];?>">
            <input type = "hidden" name ="signwithpuzzleaccount" id ="signwithpuzzleaccount" value = "">
            <div class="form-group text-center">
              <button type="submit" class="btn button-sign" id="normalsign">Submit</button><button type="submit" class="btn button-sign" id="puzelacount" name="puzzle" value = "1">Signup with Puzel Account</button>
            </div>
        </form>
    </div>
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
                <div> <?php echo $PuzzleData['Puzzle']['price'];?></div>
				<?php
						if($PuzzleData['Puzzle']['price_image'] != "")
						{
					?>
						   <div id="<?php echo $blurr_class;?>" style="background:url('<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>')">
								<a href = "<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>" target="_blank"><img src = "<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>"  width="540px"/></a> 
							</div>
					<?php
						}
					?>
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
  
