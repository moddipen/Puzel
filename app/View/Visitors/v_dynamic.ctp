<?php
 
  // Get current URl 
  $path = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  
  // Make parition or url and get puzzle name 
  $explode = explode('/',$path);
  echo $this->Html->css('animations.css');
?>
<style>

 .no-right:focus, .no-right a:focus{
    outline:none !important;
}
 #blur{
   -webkit-filter: blur(13px);
    -moz-filter: blur(13px);
    -o-filter: blur(13px);
    -ms-filter: blur(13px);
 filter: blur(13px);}
 .btn-tab{width:47% !important;}
 @media (max-width:992px){
  .btn-tab{width:46% !important;}

 }
 .columns .active{
     background: #fff;
    color: #e58b16;
    border:2px solid #e58b16;
  }
  #Imageenroll .form-group {
    margin-bottom: 25px;
    position: relative;
}
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
        $("#enrollwithpuzzleaccount").val(2);
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

    $("#Imageenroll").validate({
      rules: {
        email1: {
          required: true,
          email: true
        },
        password: "required"
      },
      messages: {
        email1: "Please enter a valid email address.",
        password: "Please enter a valid password.",
      }
    }); 

      
      // Check email is valid or not 
      function validateEmail($email)
      {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
      }

      $("#Imageenroll").submit(function(e)
      {

         if($("#password").val() == '')
         {
            return false;
         } 
         else if( !validateEmail($("#userenrollemail").val()) || $("#userenrollemail").val() == '') 
         {
            return false;
         } 
         else 
         {

            var url = "<?php echo Configure::read('SITE_URL')?>visitors/process/<?php echo $explode[5];?>"; 
             // Form Submit Ajax  
              $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#Imageenroll").serialize(), // serializes the form's elements.
                       dataType: 'json', 
                       success: function(data)
                       {

                        if(data.message == "success" )
                          {
                            $.ajax
                              ({
                                 type: "POST",
                                 url: "<?php echo Configure::read('SITE_URL');?>visitors/fetchimage/"+data.ImageId,
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
                                    $("#Imageenroll")[0].reset();
                                    // $("#success").html("<div style='background:rgba(60,118,61,0.5);color:#3C763D;font-size:14px;padding:20px'> Register successfully.</div>");
                                    // $("#success").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                    $("#alert").html("<p style='font-size:14px;'>Puzzle created successfully.</p>");
                                    $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                   }
                              });
                          }
                          else
                          {
                            $("#alert").html("<p style='font-size:14px;'>"+data.message+"</p>");
                            $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                          }
                       }
                     });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            } 
          });  














      $("#Imagedata").submit(function(e)
      {
         if($("#fname").val() == '')
         {
            return false;
         } 
         else if($("#lname").val() == '')
         {
            return false;
         }
         else if( !validateEmail($("#useremail").val()) || $("#useremail").val() == '') 
         {
            return false;
         } 
         else 
         {

            var url = "<?php echo Configure::read('SITE_URL')?>visitors/process/<?php echo $explode[5];?>"; 
             // Form Submit Ajax  
              $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#Imagedata").serialize(), // serializes the form's elements.
                       dataType: 'json', 
                       success: function(data)
                       {
                         if(data.message != "You have already enrolled")
                          {
                            $.ajax
                              ({
                                 type: "POST",
                                 url: "<?php echo Configure::read('SITE_URL');?>visitors/fetchimage/"+data.ImageId,
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
                                    $("#Imagedata")[0].reset();
                                    // $("#success").html("<div style='background:rgba(60,118,61,0.5);color:#3C763D;font-size:14px;padding:20px'> Register successfully.</div>");
                                    // $("#success").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                    $("#alert").html("<p style='font-size:14px;'>You have been enrolled.</p>");
                                    $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                  }
                            });
                          }
                          else
                          {
                            $("#alert").html("<p style='font-size:14px;'>"+data.message+"</p>");
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
            
             <li><a href="#" data-toggle="modal" data-target="#modal1">Grand Prize</a></li>
             <li><a href="#" data-toggle="modal" data-target="#modal3">Terms / Description</a></li>
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
         <div id="logo"><a href="<?php echo Configure::read('SITE_URL');?>"><img src="<?php echo $this->webroot;?>img/visitor/img/logo.png"></a></div>
        
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
<h2 class="text-center title-page"><?php echo $explode[5];?></h2>
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
        <button type="button" class="btn button-sign active" id="puzelasubmit" name="puzzle" style="width:47%">Signup for Puzel</button>
        <button type="button" class="btn button-sign" id="enrollformshow" style="width:47%">Enroll Now</button>
      </div>  
       <div id="alert"></div>
      <form id="Imagedata">
          <div class="form-group" id="firsname">
            <input type="text" name="firstname" id="fname" class="form-control" placeholder="First Name"  required>
          </div>
          <div class="form-group" id="laname">
            <input type="text" name="lastname"   id="lname"  class="form-control" placeholder="Last Name" required>
          </div>
          <div class="form-group" id="useemail">
             <input type="email" name="email"  id="useremail"  class="form-control" placeholder="Email"  onkeypress="checkemail(this.id)" required>
          </div>
            <?php if(isset($Refrel))
              {?>
                <input type = "hidden" name ="refrel" value = "1">
                <input type = "hidden" name ="refrel_id" value = "<?php echo $PuzzleData['Puzzle']['user_id']?>">
            <?php }?>
            <input type = "hidden" name ="puzzlename" value = "<?php echo $explode[5];?>">
            <input type = "hidden" name ="signwithpuzzleaccount" id ="signwithpuzzleaccount" value = "">
            <div class="form-group text-center">
              <button type="submit" class="btn button-sign" id="puzelacount" name="puzzle" value = "1" style="width:100%">Submit</button>
              
            </div>
        </form>
        <form id="Imageenroll" style="display:none;padding-top: 25px;">
          <div class="form-group" id="useenrollemail">
             <input type="email" name="email1"  id="userenrollemail"  class="form-control" placeholder="Email" onkeypress="checkemail(this.id)" required>
          </div>
          <div class="form-group" id="pasword">
            <input type="password" name="password"   id="password"  class="form-control" placeholder="Password" required>
          </div>
          
            <?php if(isset($Refrel))
              {?>
                <input type = "hidden" name ="refrel" value = "1">
                <input type = "hidden" name ="refrel_id" value = "<?php echo $PuzzleData['Puzzle']['user_id']?>">
            <?php }?>
            <input type = "hidden" name ="puzzlename" value = "<?php echo $explode[5];?>">
            <input type = "hidden" name ="enrollwithpuzzleaccount" id ="enrollwithpuzzleaccount" value = "">
            <div class="form-group text-center">
              <button type="submit" class="btn button-sign" id="normalsign" value = "2" style="width:100%">Enroll Now</button>
            </div>
        </form>
    </div>
    <?php } ?>
</div>
</div> <!-- end of container -->

<?php } 
  else
    {?>

        <h1> Puzzle has been deactivated </h1>


  <?php   } ?>
 <script>
	 //setup before functions
	
	var $input = $('#userenrollemail');
	
	
	//on keyup, start the countdown
	function checkemail(id){
		var typingTimer;                //timer identifier
		var doneTypingInterval = 500;  //time in ms, 5 second for example
		$('#'+id).on('keyup', function () {
		  clearTimeout(typingTimer);
		  typingTimer = setTimeout(doneTyping(id), doneTypingInterval);
		});
		
		//on keydown, clear the countdown 
		$('#'+id).on('keydown', function () {
		  clearTimeout(typingTimer);
		});
	}
	//user is "finished typing," do something
	function doneTyping (id) {
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if($("#"+id).val().match(mailformat))
		{
			$("label for='"+id+"'").hide()
			return true;
		}
		else
		{
			$("label for='"+id+"'").show()
			return false;
		}
	  //do something
	}
  
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
  
