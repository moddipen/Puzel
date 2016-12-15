
<link rel="stylesheet" href="http://puzel.stage.n-framescorp.com/css/visitor/add-oct-13-2016.css">
<link rel="stylesheet" href="http://puzel.stage.n-framescorp.com/css/bootstrap.css">
 <link rel="stylesheet" href="http://puzel.stage.n-framescorp.com/css/visitor/styles.css">
 
 
 <?php 
  if(!empty($PuzzleData)) {   

    $this->webroot = Configure::read('SITE_URL')?>

 
    <input type ="hidden" id="transition" value ="<?php echo $PuzzleData['Puzzle']['transtion']?>">

<!-- END NAVIGATION ############################################### -->


<!-- HEADER ############################################### -->





<!-- END HEADER ############################################### -->

<!-- BEGIN CONTAINER ############################################### -->

  <div class="puzel">
    <h3 style="text-align:center;"><?php echo $PuzzleData['Puzzle']['name'];?></h3>


<!-- <div id = 'puzzle1' hello> -->
<?php 
      // Fetch Image From database 
    $i = 0; 


    if ($drawimage_s > 0) 
    {?>
       <style>
      /*.merge div div{width:;height:;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
      .merge{width:<?php echo $image[0]['total_width']."px";?>;}*/
      body{line-height: inherit;}
      .merge div div{width:<?php echo $image[0]['width']."px";?>;height:<?php echo $image[0]['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-5px;}
      .merge{width:<?php echo $image[0]['total_width']."px";?>;margin:50px auto;}
      .button-puzzle,.button-confirm{background:#e58b16;font-size: 18px;text-align:center;font-weight: 300;padding: 5px 20px;color: #fff;width:100%;margin-bottom:50px;border-radius: none !important;}
      .form-control{border-radius: none !important;}
      .puzle-form .active, .button-puzzle:hover{background:none;color: #e58b16;border:1px solid #e58b16;box-shadow:none;}
      #alert{left: 30px;position: absolute;top: 52px;}
      .button-puzzle{background:#e58b16;font-size: 18px;text-align:center;font-weight: 300;padding: 5px 20px;color: #fff;width:100%;margin-bottom:50px;}
      @media (max-width:433px){.button-puzzle,.button-confirm{font-size:12px}}
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
<div class="row">
	<div class="col-md-12">
	<div class="col-md-3">
		<div class="share-social">
          <h3>Share with your friends</h3>
             
                  <a class="share-btn" href="http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company ;?>/<?php echo $PuzzleData['Puzzle']['name'];?>&title=<?php echo $PuzzleData['Puzzle']['name'];?>&description=Price 33$" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=580')"><i class="facebook">f</i></a>
                   <a class="twitter-share-button"
                    href="https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company ?>.'/'.<?php echo $PuzzleData['Puzzle']['name'];?>" data-size="large" target = "_blank"><i class="twitter">l</i>
                  <a href="http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company ?>.'/'.<?php echo $PuzzleData['Puzzle']['name'];?>" onclick="return !window.open(this.href, 'Outlook', 'width=640,height=580')"  target="_blank">
                  <i class="windows">w</i></a>
                  

                  <a class="icon-gplus" href ="https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle <?php echo $PuzzleData['Puzzle']['name'];?>&body=http://puzel.stage.n-framescorp.com/puzzle/<?php echo $Company ?>.'/'.<?php echo $PuzzleData['Puzzle']['name'];?>" onclick="return !window.open(this.href, 'Google', 'width=640,height=580')">
                  <i class="email">m</i></a>
             
        </div>
	</div>
	<?php //if($ShowPuzzel['Show'] != 0) {?>
	<div class="col-md-9">
    <div class="col-md-6 col-md-offset-6">
      <div class="col-md-12">
	  <div class="six columns">
      
      </div>
    </div>
	</div>
  
    <?php //if($ShowPuzzel['Show'] != 0) {?>
    <div class="col-md-6 col-md-offset-6">
      <div class="col-md-6 col-xs-6">
        <button type="button" class="btn button-puzzle btn-tab active" id="puzelasubmit" name="puzzle">Signup for Puzel</button>
      </div>
      <div class="col-md-6 col-xs-6">  
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
                <button type="submit" class="btn button-confirm" id="puzelacount" name="puzzle" value = "1" style="width:100%">Submit</button>
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
                <button type="submit" class="btn button-confirm" id="normalsign" value = "2" style="width:100%">Enroll Now</button>
              </div>
          </form>
          </div>
    </div>
	</div>
    <?php //}?>
	</div>
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