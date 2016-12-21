<style type="text/css">
    textarea.note-codable{ display: none;}
    .btn-toolbar{margin-left:0px !important; }
</style>

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>
           
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
                    <div class="col-md-11">
                      
                        <div class="row">
                          <div class="col-md-6">
                              <div class="row minipadding">
                                  <div class="col-sm-8">
                                      <div class="form-group">
                                        <textarea class="form-control" style="height:87px;line-height:14pt;background-color:#fff;color:black;" id="script"><script type="text/javascript" src="<?php echo Configure::read("SITE_URL");?>custom.js"></script><div class="snipest" id="puzzle_<?php echo $Capturedata['Puzzle']['random']; ?>"></div> </textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                          <button type="button" class="btn btn-oranges fullwidth" onclick="copyToClipboard('#script')" id="copyScript">Copy Script</button>
                                        </div>
                                         <div class="form-group">
                                          <button type="button" id="sendTo" class="btn btn-oranges fullwidth">Send to Developer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row minipadding">
                                  <div class="col-sm-8">
                                      <div class="form-group">
                                        <?php $name = str_replace(' ','', $Capturedata['Puzzle']['name']);?>
                                        <?php $company = str_replace(' ','', $Capturedata['Business']['company_name']);?>
                                          <input type="text" class="form-control" style="background-color:#fff;color:black;" value="<?php echo Configure::read("SITE_URL").$Capturedata['Business']['company_name']."/".$Capturedata['Puzzle']['name'];?>" id="puzlename">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                      <div class="form-group">
                                          <button type="button" class="btn btn-oranges fullwidth" onclick="copyToClipboard('#puzlename')" id="copyButton">Copy</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row minipadding" style="display:none;">
                                    <div class="col-sm-8"  id="newalert" style="display:none;">
                                        <div class="form-group">
                                          <p id="snip-m" ></p>
                                        </div> 
                                    </div>     
                                    <div id="emailfield">
                                      <div class="col-sm-8" >
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="send-snipest-email" style="background-color:#fff;color:black;" placeholder="Email Address">
                                          </div>
                                      </div>
                                      
                                      <div class="col-sm-4">
                                        <div class="form-group">
                                            <button type="button" id="send-snipest" class="btn btn-oranges fullwidth">Send</button>
                                          </div>
                                      </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                      
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-md-10">
                      <!-- <form role="form" class="custom-form" action ="business/puzzels/view"> -->
                      <?php //echo $this->Form->create('Puzzel',array('action'=>'view','role'=>"form" ,"class"=>"custom-form"));?>
                          <div class="row minipadding">
                            <div class="col-md-3">
                              <div class="form-group">
                                    <!-- <select  class="form-control chosen-select" name="data[Puzzle][type]" id="puzzletype">
                                    
                                      <option value = "<?php echo $Capturedata['Puzzle']['type'];?>"><?php echo $Capturedata['Puzzle']['type'];?></option>
                                      
                                    </select> -->
                                    <label class = "form-control"><?php echo $Capturedata['Puzzle']['type'];?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                              <div class="form-group">
                                    <!-- <select name="data[Puzzle][transtion]" class="form-control chosen-select">
                                      <option value=""><?php echo $Capturedata['Puzzle']['transtion']?></option>
                                    </select> -->
                                    <label class = "form-control"><?php echo $Capturedata['Puzzle']['transtion'];?></label>
                                </div>
                            </div>
                          </div>
                          <!-- /tile body -->
                      
                      <!-- </form> -->
                      <?php //echo $this->Form->end();?>
                    </div>

                  </div>





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
              <!-- <textarea name="textarea" id="textarea" class="form-control wysiwyg"><?php echo $Capturedata['Puzzle']['terms'];?></textarea> -->
              <div><?php echo $Capturedata['Puzzle']['terms'];?></div>
            </div>
            
        </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  

    <!--  Grand prize model -->
    <div class="modal fade orange" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modalDialogLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
            <h3 class="modal-title" id="modalDialogLabel">Grand Prize</h3>
          </div>
          <div class="modal-body">
            <form class="popup-form" id="grand_price" action="" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <!-- <textarea name="textarea" id="textarea1" class="form-control wysiwyg"><?php echo $Capturedata['Puzzle']['price'];?></textarea> -->
                <div><?php echo $Capturedata['Puzzle']['price'];?></div>
              </div>
              <div id="image">
                <?php 
                  if($Capturedata['Puzzle']['price_image'] != "")
                  {
                    $filepath  = Configure::read("SITE_URL").'app/webroot/img/grand_price/';
                    $filepath = $filepath.strtolower($Capturedata['Puzzle']['price_image']);
                    echo "<img src='$filepath' style='width:540px;'/>";
                  }
                ?>
            </div>
        
              <form>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--Modal-->

                  
                 <input type = "hidden" name="data[Puzzle][user_id]" value="<?php echo $this->Session->read('USERDETAIL.User.id');?>">
                 <div class="body" id="showimage">
                    <style>
      			.merge div div{width:<?php echo $Capturedata['Image'][0]['width']."px";?>;height:<?php echo $Capturedata['Image'][0]['height']."px";?>;display:inline-block;margin-left:-5px;margin-bottom:-6px;-webkit-filter: brightness(0.55); filter: brightness(0.55);border:1px solid #FFF;}
			 .merge div div:last-child{border-right:none}
			 .merge div div:first-child{border-left:none}
			 .merge div:first-child div{border-top:none}
			 .merge div:last-child div{border-bottom:none}
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
  <!-- </div> -->
      </div>
                    <?php ?>


                  </div>
                  </div>
                  <!-- /tile body -->
                  <input type = "hidden" value="" id="clickterm"/>
                  <input type = "hidden" value="" id="clickprize"/>
                  <!-- tile footer -->
                  <!-- /tile footer -->
                  <!-- tile footer -->
                  <div class="tile-footer text-center" >
                    <div class="form-group">
                      <input type="button" class="btn btn-black-orange" value="Terms / Description" data-toggle="modal" data-target="#modal1" id="clickzone">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-black-orange" value="Grand Prize" data-toggle="modal" data-target="#modal3" id="clickpricezone">
                    </div>
                  </div>
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
        <?php echo $this->Html->script('dashboard/vendor/summernote/summernote.min.js')?>
<script type="text/javascript">
  document.getElementById("copyButton").addEventListener("click", function()
     {
       copyToClipboard(document.getElementById("puzlename"));
    });
    document.getElementById("copyScript").addEventListener("click", function()
     {
       copyToClipboard(document.getElementById("script"));
    });

 $('.wysiwyg').summernote({
        toolbar: [
          ['style', ['bold', 'italic', 'underline']],
      ['para', ['ul', 'ol']],
        ],

        height: 300,   //set editable area's height
    disableResizeEditor: true
      });
    $('.note-statusbar').hide()
    $('.changebutton').click(function(){
    $(this).addClass('btn-oranges');  
    $(document).on('hide.bs.modal','.modal', function () {
       $('.changebutton').removeClass('btn-oranges');
 //Do stuff here
});
    })


  $("#sendTo").click(function(){    
    $(".minipadding").css("display","block");
  });
  
  $("#send-snipest").click(function(){    
    if($("#send-snipest-email").val() !=  "")
    {
      $.ajax(
      {
        url: "<?php echo Configure::read("SITE_BUSINESS_URL");?>/puzzles/send",
        type: "post",
        datatype:"json",
        data: {'email':$("#send-snipest-email").val(),'snipest':$('#script').val()} ,
        success: function (data)
        {
        var obj = $.parseJSON(data);
        if(obj.Message == "OK")
        {
          $("#emailfield").remove();
          
          $("#newalert").css("display", "block");
          $("#snip-m").html("Snippest code emailed successfully");
        }
        else
        {
          $("#snip-m").html("Error while sending snipest code.");
        }
        }
      });   
    }
  });
  // Remove toolbar 
  $(".btn-toolbar").remove();

    function copyToClipboard(elem) {
    // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
        succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

</script>