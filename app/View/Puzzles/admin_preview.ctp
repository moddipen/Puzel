<style type="text/css">
    textarea.note-codable{ display: none;}
    .btn-toolbar{margin-left:0px !important; }
</style>

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('admin/header');?>
           
              <div class="pagesubheader">
            

              <h2><i class="fa fa-puzel-icon-left-big"></i> Puzel</h2>

            </div>

            <!-- row -->
            <div class="row">


              <!-- col 8 -->
              <div class="col-lg-12 col-md-12">




                <!-- tile -->
                <!-- /tile -->



                <!-- tile -->
                <section class="tile color transparent-black padding10px">



                
                  <!-- tile header -->
                  
                  <!-- /tile header -->

                  <?php $id = $Capturedata['Puzzle']['id'] ;?>
                  <!-- tile body -->
                  <!-- <form role="form" class="custom-form" action ="puzzels/view" method="post"> -->
                  <div class="tile-body">
                  <div class="row">
                    <div class="col-md-10">
                      <!-- <form role="form" class="custom-form" action ="business/puzzels/view"> -->
                      <?php //echo $this->Form->create('Puzzel',array('action'=>'view','role'=>"form" ,"class"=>"custom-form"));?>
                          <div class="row minipadding">
                            <div class="col-md-2">
                              <div class="form-group">
                                    <!-- <select  class="form-control chosen-select" name="data[Puzzle][type]" id="puzzletype">
                                    
                                      <option value = "<?php echo $Capturedata['Puzzle']['type'];?>"><?php echo $Capturedata['Puzzle']['type'];?></option>
                                      
                                    </select> -->
                                    <label class = "form-control"><?php echo $Capturedata['Puzzle']['type'];?></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <!-- <input name="data[Puzzle][name]" class="form-control" type="text" placeholder="Puzel Name" id="puzzlename" value ="<?php echo $Capturedata['Puzzle']['name'];?>"> -->
                                    <label class = "form-control"><?php echo $Capturedata['Puzzle']['name'];?></label>
                                </div> 
                            </div>
                             <input name="data[Puzzle][id]" class="form-control" type="hidden" placeholder="Puzel Name" id="puzzlename" value ="<?php echo $Capturedata['Puzzle']['id'];?>">
                            <!-- <div class="col-md-2">
                              <div class="form-group">
                                  <div class="btn btn-file imageupload" id="uploadimage">
                                    <input name="data[Puzzel][source]" class="form-control" type="file" id="imgpre">
                                    </div>
                                </div> 
                            </div> -->
                            <div class="col-md-2">
                              <div class="form-group">
                                    <!-- <select name="data[Puzzle][peice]" class="form-control chosen-select"> -->
                                      <!-- <option style="display:none">Number of Pieces</option> -->
                                      <!-- <option value="<?php echo $Capturedata['Puzzle']['pieces'];?>"><?php echo $Capturedata['Puzzle']['pieces'];?></option> -->
                                      <!-- <option value="50">50</option>
                                      <option value="75">75</option>
                                      <option value="100">100</option> -->
                                    <!-- </select> -->
                                    <label class = "form-control"><?php echo $Capturedata['Puzzle']['pieces'];?></label>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <!-- <select name="data[Puzzle][transtion]" class="form-control chosen-select">
                                      <option value=""><?php echo $Capturedata['Puzzle']['transtion']?></option>
                                    </select> -->
                                    <label class = "form-control"><?php echo $Capturedata['Puzzle']['transtion'];?></label>
                                </div>
                            </div>
                          </div>
                      <!-- </form> -->
                      <?php //echo $this->Form->end();?>
                    </div>
                  </div>
                  
                  <input type = "hidden" name="data[Puzzle][user_id]" value="<?php echo $this->Session->read('USERDETAIL.User.id');?>">
                 <div class="body" id="showimage">
                    <!-- <img src="<?php echo $this->webroot ?>img/puzzel/<?php echo $Capturedata['Puzzle']['image_ext']?>" class="img-responsive" id="img_preview" alt="Please upload your image" /> -->
                             <style>
            .merge div div{width:<?php echo $Capturedata['Image'][0]['width']."px";?>;height:<?php echo $Capturedata['Image'][0]['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-6px;border:1px solid #FFF;filter: brightness(0.55);}
       .merge div div:last-child{border-right:none}
            .merge{width:<?php echo $Capturedata['Image'][0]['total_width']."px";?>;}
            </style>
              <?php $peices = $Capturedata['Puzzle']['pieces'] ; ?>
          
              <div class="merge pt-perspective">
              <div>
                 <?php 
             $index = 0;
                  foreach($Capturedata['Image'] as $image_data)
                    {
                      
                      // Get Image path 
                    $path =  $this->webroot.'img/puzzel/'.$Capturedata['Puzzle']['name'].'/'.$image_data['name'] ;
                 
                    $getname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image_data['name']); 
                    $class_name = $getname  ;
                    $class_image = "background:url('$path')"; 
                    
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
                    echo "</div>";?>
                 </div> 
                  
                  </div>
                  </div>
                  <!-- /tile body -->
                  <input type = "hidden" value="" id="clickterm"/>
                  <input type = "hidden" value="" id="clickprize"/>
                  <!-- tile footer -->
                  <!-- /tile footer -->
                
                </section>
                <!-- /tile -->


              </div>
              <!-- /col 8 -->



              <!-- col 4 -->
              
              <!-- /col 4 -->
              
              
            </div>
           

          </div>
          <!-- /content container -->
       </div>
        <!-- Page content end -->
