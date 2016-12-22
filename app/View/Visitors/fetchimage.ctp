
<!-- <link rel="stylesheet" href="http://puzel.stage.n-framescorp.com/app/webroot/css/visitor/bootstrap.css"> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="http://puzel.stage.n-framescorp.com/app/webroot/css/visitor/bootstrap.min.css">
<style type="text/css">
#blur{
   -webkit-filter: blur(13px);
    -moz-filter: blur(13px);
    -o-filter: blur(13px);
    -ms-filter: blur(13px);
 filter: blur(13px);}
.no-right:focus, .no-right a:focus{
    outline:none !important;
}
  .modal-open {
    overflow: hidden;
} 
.puzel{
    padding-top: 120px;
}
.social {
margin: 0;
padding: 0;
}
.social ul {
    margin: 0;
    padding: 5px;
}
.social ul li {
    margin: 5px;
    list-style: none outside none;
    display: inline-block;
    width: 30px;
    height: 30px;
    background-color: #333333;
    text-align:center;
    padding: 6px;
    border-radius: 50%;
    border: 1px solid #000;
}
.social i {
    color: #fff;
    font-size: 15px;
}
.navbar{
    background-color: #aaaaaa!important;
    min-height: 120px !important;
}
.top-nav-collapse {
        padding: 0;
        background: rgba(0,0,0,0.4) !important;
}
.socialbtn{
  padding-left: 50px;
}
.termbtn{
    padding-right: 45px;
}

.navbar-nav{
    float: right; !important;
    margin-top: 40px !important;
}
.modal{
    top: 150px !important;
}
.modal-title ,.modal-body {
    color: #E58B16 !important;
}
.navbar-default{
    border: none !important;
}


.btn , .form-control{
    border-radius: 0px !important;
}

      #Imageenroll, #Imagedata {
          padding-top: 25px;
      }

   .btn.focus, .btn:focus, .btn:hover{
    color: #fff;
    outline:none!important;
}   
</style>


<?php
  //echo "<pre>";print_r($PuzzleData);exit; 
  if(!empty($PuzzleData)) {   

    $this->webroot = Configure::read('SITE_URL');?>

 
    <input type ="hidden" id="transition" value ="<?php echo $PuzzleData['Puzzle']['transtion']?>">

<!-- END NAVIGATION ############################################### -->


<!-- HEADER ############################################### -->





<!-- END HEADER ############################################### -->

<!-- BEGIN CONTAINER ############################################### -->
  <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
              <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
             </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav wow fadeInDown top__element">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <div class="row">
                            <div class="col-md-5 col-xs-6">
                               <button type="button" class="btn button-header" data-toggle="modal" data-target="#modal">Grand Prize</button>
                            </div>     
                            <div class="col-md-7 col-xs-7 termbtn">
                                <button type="button" class="btn button-header btn-tab" data-toggle="modal" data-target="#modalterm">Terms / Description</button>
                            </div>
                     </div>
                 </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <div class="modal fade" id="modal" role="dialog">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h3 class="modal-title">Grand prize</h3>
                                        </div>
                                        <div class="modal-body">
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
                                          <div style="margin-bottom:40px;"><?php echo $PuzzleData['Puzzle']['price']?></div>
                                          <div>
                                           <?php
                                            if($PuzzleData['Puzzle']['price_image'] != "")
                                            {
                                          ?> 
                                               <div id="<?php echo $blurr_class;?>" style="background:url('<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>')">
                                               <img src = "<?php echo Configure::read("SITE_URL") ;?>app/webroot/img/grand_price/<?php echo $PuzzleData['Puzzle']['price_image'];?>"  width="540px"/>
                                              </div>
                                          <?php
                                            }
                                          ?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                             </div>
                             <div class="modal fade" id="modalterm" role="dialog">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h3 class="modal-title">Terms / Description</h3>
                                        </div>
                                        <div class="modal-body">
                                          <div style="margin-bottom:40px;"><?php echo $PuzzleData['Puzzle']['terms']?></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>

  <div class="puzel">
    <h2 style="text-align:center;"><?php echo $PuzzleData['Puzzle']['name'];?></h2>


<!-- <div id = 'puzzle1' hello> -->
<?php 
      // Fetch Image From database 
    $i = 0; 


    if ($drawimage_s > 0) 
    {?>
       <style>
    
    
    
      body{line-height: inherit;}
      .merge div div{width:<?php echo $image[0]['width']."px";?>;height:<?php echo $image[0]['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
      .merge{width:<?php echo $image[0]['total_width']."px";?>;margin:50px auto;}
      .button-puzzle{background:#e58b16;font-size: 18px;text-align:center;font-weight: 300;padding: 5px 20px;color: #fff;width:100%;margin-bottom:20px;}
      .puzle-form .active, .button-puzzle:hover{background:none;color: #e58b16 !important;border:1px solid #e58b16;box-shadow:none;}
      .button-header{background:#e58b16;font-size: 18px;text-align:center;font-weight: 300;padding: 5px 20px;color: #fff;width:100%;margin-bottom:20px;}
      .button-header .active, {background:#e58b16;color:#fff ; border: none !important;}
      /*.btn.focus, .btn:focus, .btn:hover {color: #fff !important;}*/
      #alert{left: 30px;position: absolute;top: 52px;}
     
      </style>
        <?php $peices = $PuzzleData['Puzzle']['pieces'] ; ?>
        <div class="merge">
          <div>
           <?php 
           
            $index = 0;
            foreach($image as $image_data)
              {
                  // Get Image path 
                $path =  $this->webroot.'/img/puzzel/'.$PuzzleData['Puzzle']['name'].'/'.$image_data['name'] ;
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
              
                $get_image_part = explode("_",$image_data['name']);
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

    
<div class="puzle-form">   
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 socialbtn">
          <h3>Share with your friends</h3>
              <div class="social">
                  <ul>
                      <li>
                        <a href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/<?php echo $PuzzleData['Business']['company_name'].'/'.$PuzzleData['Puzzle']['name']?>&title=<?php $PuzzleData['Puzzle']['name'];?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="fa fa-facebook"></i></a>
                      </li>
                      <li>
                        <a href="https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/<?php echo $PuzzleData['Business']['company_name'].'/'.$PuzzleData['Puzzle']['name']?>" data-size="large" target = "_blank"><i class="fa fa-twitter"></i></a>
                      </li>
                      <li>
                        <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $PuzzleData['Business']['company_name'].'/'.$PuzzleData['Puzzle']['name'];?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')"  target="_blank"><i class="fa fa-windows"></i></a>
                      </li>
                      <li>
                        <a href ="https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/<?php echo $PuzzleData['Business']['company_name'].'/'.$PuzzleData['Puzzle']['name'];?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')"><i class="fa fa-envelope-o"></i></a>
                      </li>
                  </ul>
              </div>
      </div>
     <?php if($ShowPuzzel['Show'] != 0){?> 
     <div class="col-md-6">
      <div class="col-md-6 col-xs-6">
        <button type="button" class="btn button-puzzle btn-tab active" id="puzelasubmit" name="puzzle">Signup for Puzel</button>
      </div>
      <div class="col-md-6">  
        <button type="button" class="btn button-puzzle btn-tab" id="enrollformshow">Enroll Now</button>
      </div>
       <div id="alert"></div> 
      <div class="col-md-12">
        <form id="Imagedata" >
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
              <input type = "hidden" name ="puzzlename" value = "<?php echo $PuzzleData['Puzzle']['name'];?>">
              <input type = "hidden" name ="signwithpuzzleaccount" id ="signwithpuzzleaccount" value = "">
              <div class="form-group">
                <button type="submit" class="btn button-puzzle" id="puzelacount" name="puzzle" value = "1" style="width:100%">Submit</button>
                <!-- button type="button" class="btn button-sign" id="enrollformshow">Enroll Now</button> -->
              </div>
          </form>
        </div>
        <div class="col-md-12">  
          <form id="Imageenroll" style="display:none;" method="post">
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
              <input type = "hidden" name ="puzzlename" value = "<?php echo $PuzzleData['Puzzle']['name'];?>">
              <input type = "hidden" name ="enrollwithpuzzleaccount" id ="enrollwithpuzzleaccount" value = "">
              <div class="form-group">
                <!-- <button type="button" class="btn button-sign" id="puzelasubmit" name="puzzle" >Submit</button> -->
                <button type="submit" class="btn button-puzzle" id="normalsign" value = "2" style="width:100%">Enroll Now</button>
              </div>
          </form>
          </div>
    </div>
    <?php }?>
      
   
    </div>
    <?php //}?>
</div>
</div> 



</div>
</div>
<!-- end of container -->

<?php } 
  else
    {?>

        <h1> Puzzle has been deactivated </h1>


  <?php   } ?>
  <script type="text/javascript" src="http://puzel.stage.n-framescorp.com/app/webroot/js/scrolling-nav.js"></script>
<script type="text/javascript" src="http://puzel.stage.n-framescorp.com/app/webroot/js/bootstrap.min.js"></script>