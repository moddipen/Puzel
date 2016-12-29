<?php
    echo $this->Html->css('visitor/jAlert-master/src/jAlert.css');
    echo $this->Html->script('visitor/jAlert-master/src/jAlert.js');
    echo $this->Html->script('visitor/jAlert-master/src/jAlert-functions.js');


 
  // Get current URl 
  $path = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  
  // Make parition or url and get puzzle name 
  $explode = explode('/',$path);
  echo $this->Html->css('animations.css');
?>
<style>

/* .no-right:focus, .no-right a:focus{
    outline:none !important;
}
.form-control:focus {
    border-color: #e58b16;
    outline: 0 none;
}
 #blur{
   -webkit-filter: blur(13px);
    -moz-filter: blur(13px);
    -o-filter: blur(13px);
    -ms-filter: blur(13px);
 filter: blur(13px);}
 .btn-tab{width:47% !important;}
 @media (max-width:992px){
  .btn-tab{width:46% !important;word-wrap: break-word !important;white-space: pre-wrap;}
}
@media (max-width:433px){
.btn-tab, .btn-confirm{font-size:12px}
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
.modal-open{overflow:hidden !important;}
.modal{top:10% !important;}

a:hover {
    color: #fff;
}*/
<style>
.no-right:focus, .no-right a:focus{
    outline:none !important;
}
.form-control:focus {
    border-color: #e58b16;
    outline: 0 none;
}
 #blur{
   -webkit-filter: blur(13px);
    -moz-filter: blur(13px);
    -o-filter: blur(13px);
    -ms-filter: blur(13px);
 filter: blur(13px);}
 .btn-tab{width:47% !important;}
 @media (max-width:992px){
  .btn-tab{width:46% !important;word-wrap: break-word !important;white-space: pre-wrap;}
}
@media (max-width:433px){
.btn-tab, .btn-confirm{font-size:12px}
}
  .btn-tab.active, .button-btn:hover, .btn-tab:hover{
     background: #fff;
    color: #e58b16 !important;
    border:1px solid #e58b16 !important;
  }

  #Imageenroll .form-group {
    margin-bottom: 25px;
    position: relative;
}
.button-btn{ background:#fff; color:#808080 !important; border-color: #808080 !important}
a:hover {
    color: #fff;
}
.columns .col-md-4, .columns .col-md-6{
    padding-right: 0px;
    padding-left: 0px;
    float:none;
    display: inline-block;
}
.columns .col-md-4{
  width:32.333%;
}
.columns .col-md-6{
  width: 49%;
}
.modal{top:10%;}
@media (max-width:378px){
  .columns .col-md-4, .columns .col-md-6{
  width:50%;
  }
}
.btn-confirm:hover{
   background: #fff;
    color: #e58b16;
    border: 1px solid #e58b16 !important;
}
.btn-confirm{
  margin: 0 auto !important;
  /*display:flex;*/
}
.btn-confirm:focus , .btn-tab:focus{
  outline: none !important;
}
.row .four.columns {
   /* width: 31.1489%;
    float: none;
    display: inline-block;*/
}
  .share-social h3{
    margin-right: 25px;
}
.share-social p{
    padding-top: 17px;
}
.share-social i {
    top: -25px;
}
#Imagedata .form-group, #Imageenroll .form-group{margin-bottom:16px;}
</style>
<script type="text/javascript">
var transition = '<?php echo $PuzzleData['Puzzle']['transtion'];?>';
	jQuery.validator.addMethod("validateemail", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/);
}, 'Please enter a valid email address.');
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
          email: true,
		  validateemail:true
        }
      },
      messages: {
        firstname: "Please enter first name.",
        lastname: "Please enter last name.",
        email: "Please enter a valid email.",
      }
    });

    $("#Imageenroll").validate({
      rules: {
        email1: {
          required: true,
          email: true,
		  validateemail:true
        },
        password: "required"
      },
      messages: {
        email1: "Please enter a valid email address.",
        password: "Please enter a valid password.",
      }
    }); 

      
      // Check email is valid or not 
      // Check email is valid or not 
      function validateEmail($email)
      {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
          if (filter.test($email))
        {
          return true;
        }
        else
        {
          $("#useremail").removeClass('valid');
          $("#useremail").addClass('error');
          $("#useremail").after('<label class="error" for="useremail">Please enter a valid email address.</label>');
          return false;
        }
      }


      $("#Imageenroll").submit(function(e)
      {

         if($("#password").val() == '')
         {
            return false;
         } 
         else if( $("#userenrollemail").val() == '') 
         {
            return false;
         } 
         else 
         {

            var url = "<?php echo Configure::read('SITE_URL')?>process/<?php echo $PuzzleData['Puzzle']['name'];?>"; 
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
                                 url: "<?php echo Configure::read('SITE_URL');?>fetchimage/"+data.ImageId,
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
                                    // $("#alert").html("<p style='font-size:14px;'>Puzzle created successfully.</p>");
                                    // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                    // javascript:successAlert('You have been enrolled.');

                                    // $(".ja_wrap_black").show().delay(5000).fadeOut(function(){ $(this).remove(); });
                                    javascript:successAlert("You have been enrolled. </br></br>Share with your friends</br><?php if(isset($Refrel)) {?><a class='share-btn' href='http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo $puzle_name;?>&description=Price 33$' onclick='return !window.open(this.href,Facebook,width=640,height=580)'><i class='facebook' style='color:black !important;font-size:40px !important;top: 0px;'>f</i></a><a class='twitter-share-button' href='https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' data-size='large' target ='_blank'><i class='twitter' style='color:black !important;font-size:40px !important;top: 0px;'>l</i></a><a href='http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Outlook,width=640,height=580)' target='_blank'><i class='windows' style='color:black !important;font-size:40px !important;margin: 0 10px;'>w</i></a><a class='icon-gplus' href ='https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Google,width=640,height=580)'><i class='email' style='color:black !important;font-size:40px !important;margin: 0 10px;'>m</i></a><?php } else {?><a class='share-btn' href='http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&description=Price 33$' onclick ='return !window.open(this.href,Facebook,width=640,height=580)'><i class='facebook' style='color:black !important;font-size:40px !important;top: 0px;'>f</i></a><a class='twitter-share-button' href='https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' data-size='large' target = '_blank'><i class='twitter' style='color:black !important;font-size:40px !important;top: 0px;'>l</i><a href='http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Outlook,width=640,height=580)' target='_blank'><i class='windows' style='color:black !important;font-size:40px !important;margin: 0 10px;'>w</i></a><a class='icon-gplus' href ='https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Google,width=640,height=580)'><i class='email' style='color:black !important;font-size:40px !important;margin: 0 10px;'>m</i></a><?php } ?>");

                                      var newaddcount = parseInt($("#showimagecontent").val()) - 1 ;
                                      var newminuscount = parseInt($("#hideimagecontent").val()) + 1;
                                      if(newaddcount != 0)
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far, "+newaddcount+" more to go before we give away the rewards, enroll yourself now!");     
                                      }
                                      else
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far,");   
                                      }  
                                      
                                      $("#showimagecontent").val(newaddcount);
                                      $("#hideimagecontent").val(newminuscount);
                                   }
                              });
                          }
                          else
                          {
                            // $("#alert").html("<p style='font-size:14px;'>"+data.message+"</p>");
                            // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                            javascript:errorAlert(data.message);
                            $(".ja_wrap_black").show().delay(5000).fadeOut(function(){ $(this).remove(); });
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
         else if( $("#useremail").val() == '') 
         {
            return false;
         } 
         else 
         {

            var url = "<?php echo Configure::read('SITE_URL')?>process/<?php echo $PuzzleData['Puzzle']['name'];?>"; 
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
                                 url: "<?php echo Configure::read('SITE_URL');?>fetchimage/"+data.ImageId,
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
                                    // $("#alert").html("<p style='font-size:14px;'>You have been enrolled.</p>");
                                    // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                    // javascript:successAlert('You have been enrolled.');

                                    // $(".ja_wrap_black").show().delay(5000).fadeOut(function(){ $(this).remove(); });
                                    javascript:successAlert("You have been enrolled. </br></br>Share with your friends</br><?php if(isset($Refrel)) {?><a class='share-btn' href='http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo $puzle_name;?>&description=Price 33$' onclick='return !window.open(this.href,Facebook,width=640,height=580)'><i class='facebook' style='color:black !important;font-size:40px !important;top: 0px;'>f</i></a><a class='twitter-share-button' href='https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' data-size='large' target ='_blank'><i class='twitter' style='color:black !important;font-size:40px !important;top: 0px;'>l</i></a><a href='http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Outlook,width=640,height=580)' target='_blank'><i class='windows' style='color:black !important;font-size:40px !important;margin: 0 10px;'>w</i></a><a class='icon-gplus' href ='https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Google,width=640,height=580)'><i class='email' style='color:black !important;font-size:40px !important;margin: 0 10px;'>m</i></a><?php } else {?><a class='share-btn' href='http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&description=Price 33$' onclick ='return !window.open(this.href,Facebook,width=640,height=580)'><i class='facebook' style='color:black !important;top: 0px;font-size:40px !important;'>f</i></a><a class='twitter-share-button' href='https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' data-size='large' target = '_blank'><i class='twitter' style='color:black !important;font-size:40px !important;top: 0px;'>l</i><a href='http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Outlook,width=640,height=580)' target='_blank'><i class='windows' style='color:black !important;font-size:40px !important;margin: 0 10px;'>w</i></a><a class='icon-gplus' href ='https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $puzle_name;?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'],strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>' onclick='return !window.open(this.href,Google,width=640,height=580)'><i class='email' style='color:black !important;font-size:40px !important;margin: 0 10px;'>m</i></a><?php } ?>");

                                      var newaddcount = parseInt($("#showimagecontent").val()) - 1 ;
                                      var newminuscount = parseInt($("#hideimagecontent").val()) + 1;
                                      if(newaddcount != 0)
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far, "+newaddcount+" more to go before we give away the rewards, enroll yourself now!");     
                                      }
                                      else
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far,");   
                                      }  
                                      
                                      $("#showimagecontent").val(newaddcount);
                                      $("#hideimagecontent").val(newminuscount);
                                  }
                            });
                          }
                          else
                          {
                            // $("#alert").html("<p style='font-size:14px;'>"+data.message+"</p>");
                            // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                            javascript:errorAlert(data.message);
                            $(".ja_wrap_black").show().delay(5000).fadeOut(function(){ $(this).remove(); });
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
            
             <li><a href="#" data-toggle="modal" data-target="#modal3">Grand Prize</a></li>
             <li><a href="#" data-toggle="modal" data-target="#modal1">Terms / Description</a></li>
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
            
            <li class="no-right"><a href="#" data-toggle="modal" data-target="#modal1"><span class="button-btn btn" style="width:100%">Terms / Description</span></a></li>                     
            <li class="no-right"><a href="#" data-toggle="modal" data-target="#modal3"><span class="button-btn btn" style="width:100%">Grand Prize</span></a></li>                     
         </ul>
       
      </nav>
    
    </div> 


<!-- END NAVIGATION ############################################### -->


<!-- HEADER ############################################### -->





<!-- END HEADER ############################################### -->

<!-- BEGIN CONTAINER ############################################### -->


<div id="container" class="page-hosted" style="background:url(<?php echo $this->webroot?>img/visitor/summer-bokeh.png);background-size: cover;">
<h2 class="text-center title-page" style="padding:30px 0px 0px;"><?php echo $PuzzleData['Puzzle']['name'];?></h2>
 <div class="row"> 
  <div class="col-md-12">
    <div id="puzzle">
      <div id="contentfield" align="center">

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
    
        <div class="merge pt-perspective" style="background:rgba(0,0,0,0.03);">
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
<input type ="hidden" id="showimagecontent" value="<?php echo $ShowPuzzel['Show']?>">
<input type ="hidden" id="hideimagecontent" value="<?php echo $ShowPuzzel['Hide']?>">
    
 
<div class="row">
  <div class="three columns">
      <div class="share-social">
          <h3>Share with your friends</h3>
          <br />
              <?php if(isset($Refrel))
              { ?>
                  <a class="share-btn" href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo $PuzzleData['Puzzle']['name'];?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="facebook">f</i></a>
                  <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" data-size="large" target = "_blank"><i class="twitter">l</i>
                  <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')"  target="_blank">
                  <i class="windows">w</i></a>


                  <a class="icon-gplus" href ="https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.$explode[4].'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')">
                  <i class="email">m</i></a> 

              <?php }
              else
              { ?>
                  <a class="share-btn" href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>&title=<?php echo $PuzzleData['Puzzle']['name'];?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="facebook">f</i></a>
                   <a class="twitter-share-button"
                    href="https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" data-size="large" target = "_blank"><i class="twitter">l</i>
                  <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')"  target="_blank">
                  <i class="windows">w</i></a>
                  

                  <a class="icon-gplus" href ="https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $Company.'/'.substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')">
                  <i class="email">m</i></a>
              <?php } ?>


            
        </div>
    </div>
     <div class="three columns">
      <div class="share-social">
              <p id="messagecontent">
          <?php if($ShowPuzzel['Show'] > 0){?>
             <?php echo $ShowPuzzel['Hide']?> have signed up so far, <?php echo $ShowPuzzel['Show']?> more to go before we give away the rewards, enroll yourself now!
              <?php } else {
               echo $ShowPuzzel['Hide'].' have signed up so far,';}?>
             </p>

            
        </div>
    </div>
    <?php if($ShowPuzzel['Show'] != 0) {?>
    <div class="six columns" >
     
      <div class="form-group" style="margin-bottom:0px;">
        <button type="button" class="btn button-btn btn-tab active" id="puzelasubmit" name="puzzle" >Signup for Puzel</button>
        <button type="button" class="btn button-btn btn-tab " id="enrollformshow" >Enroll Now</button>
      </div>  
       <div id="alert"></div>
      <form id="Imagedata" style="padding-top: 16px;">
          <div class="four columns">
            <div class="form-group" id="firsname">
              <input type="text" name="firstname" id="fname" class="form-control" placeholder="First Name"  required>
            </div>
          </div>
          <div class="four columns">  
            <div class="form-group" id="laname">
              <input type="text" name="lastname"   id="lname"  class="form-control" placeholder="Last Name" required>
            </div>
          </div> 
          <div class="four columns"> 
            <div class="form-group" id="useemail">
               <input type="email" name="email"  id="useremail"  class="form-control" placeholder="Email"  required>
            </div>
          </div>  
            <?php if(isset($Refrel))
              {?>
                <input type = "hidden" name ="refrel" value = "1">
                <input type = "hidden" name ="refrel_id" value = "<?php echo $Refrel?>">
            <?php }?>
            <input type = "hidden" name ="puzzlename" value = "<?php echo $PuzzleData['Puzzle']['name'];?>">
            <input type = "hidden" name ="signwithpuzzleaccount" id ="signwithpuzzleaccount" value = "">
            <div class="clearfix"></div>
            <div class="form-group text-center">
              <button type="submit" class="btn button-sign btn-confirm" id="puzelacount" name="puzzle" value = "1" >Submit</button>
              
            </div>
        </form>
        <form id="Imageenroll" style="display:none;padding-top: 16px;">
        <div class="six columns">
          <div class="form-group" id="useenrollemail">
             <input type="email" name="email1"  id="userenrollemail"  class="form-control" placeholder="Email" required>
          </div>
        </div>
        <div class="six columns">  
          <div class="form-group" id="pasword">
            <input type="password" name="password"   id="password"  class="form-control" placeholder="Password" required>
          </div>
        </div>  
          <input type = "hidden" name ="puzzlename" value = "<?php echo $PuzzleData['Puzzle']['name'];?>">
            <input type = "hidden" name ="enrollwithpuzzleaccount" id ="enrollwithpuzzleaccount" value = "">
            <div class="clearfix"></div>
            <div class="form-group text-center">
              <button type="submit" class="btn button-sign btn-confirm" id="normalsign" value = "2" >Enroll Now</button>
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
  
