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


                  <!-- tile body -->
                  <!-- <form role="form" class="custom-form" action ="puzzels/view" method="post"> -->
                  <?php echo $this->form->create('Puzzle',array('action'=>'view','method'=>'post','class'=>"custom-form"));?>
                  <div class="tile-body">
                  <div class="row">
                    <div class="col-md-10">
                      <!-- <form role="form" class="custom-form" action ="business/puzzels/view"> -->
                      <?php //echo $this->Form->create('Puzzel',array('action'=>'view','role'=>"form" ,"class"=>"custom-form"));?>
                          <div class="row minipadding">
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select  class="form-control chosen-select" name="data[Puzzel][type]">
                                      <option style="display:none">Type of Puzel</option>
                                      <option value = "Open">Open</option>
                                      <option value = "Mystery">Mystery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <input name="data[Puzzel][name]" class="form-control" type="text" placeholder="Puzel Name">
                                </div> 
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                  <div class="btn btn-file imageupload" id="uploadimage">
                                    <input name="data[Puzzel][source]" class="form-control" type="file" id="imgpre">
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="data[Puzzel][peice]" class="form-control chosen-select">
                                      <!-- <option style="display:none">Number of Pieces</option> -->
                                      <option value="25">25</option>
                                      <option value="50">50</option>
                                      <option value="75">75</option>
                                      <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="data[Puzzel][transtion]" class="form-control chosen-select">
                                      <option value="Transition">Transition</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                      <!-- </form> -->
                      <?php //echo $this->Form->end();?>
                    </div>
                  </div>
                  <input type = "hidden" name="data[Puzzel][base64]" id="base64image">
                  <input type = "hidden" name="data[Puzzel][user_id]" value="<?php echo $this->Session->read('USERDETAIL.User.id');?>">
                 <div class="body" id="showimage">
                    <img src="#" class="img-responsive" id="img_preview" alt="Please upload your image" />
                  </div>
                  </div>
                  <!-- /tile body -->

          
                  <!-- tile footer -->
                  <div class="tile-footer text-center" style="display:none">
                    <div class="form-group">
                      <input type="button" class="btn btn-black-transparent changebutton" value="Terms / Description" data-toggle="modal" data-target="#modal1">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-black-transparent" value="Grand Prize" data-toggle="modal" data-target="#modal4">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-oranges">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;
                          <button type="reset" class="btn btn-black-transparent">Cancel</button>
                    </div>
                  </div>
                  <!-- /tile footer -->
                   <?php echo $this->form->end();?>


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
 <!--Modal-->
     <div class="modal fade orange" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modalDialogLabel" aria-hidden="true">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>

            <h3 class="modal-title" id="modalDialogLabel">Terms / Description</h3>

          </div>

          <div class="modal-body">
          <form class="popup-form">
            <div class="form-group">
        <textarea name="textarea" id="textarea" class="form-control wysiwyg"></textarea>
            </div>
            <div class="form-group">
              <div class="row">
                  <div class="col-md-4">
                        <select name="opton" class="form-control chosen-select">
                            <option> Templates</option>
                        </select>
                  </div>
                </div>
            </div>
            
            <div class="row minipadding">
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                   <button type="submit" class="btn btn-oranges fullwidth">Submit</button>
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="form-group">
                   <button type="reset" class="btn btn-black-transparent fullwidth" data-dismiss="modal">Cancel</button>
                   </div>
               </div>
            </div>
                
    </form>
          </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->

  <div class="modal fade orange" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modalDialogLabel" aria-hidden="true">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>

            <h3 class="modal-title" id="modalDialogLabel">Sign Up Prize</h3>

          </div>

          <div class="modal-body">
          <form class="popup-form">
            <div class="form-group">
        <textarea name="textarea" id="textarea" class="form-control wysiwyg"></textarea>
            </div>
            <div class="form-group">
              <div class="row">
                  <div class="col-md-4">
                        <div class="btn btn-file imageupload">
                            <input name="uploadfile" class="form-control" type="file">
                        </div>
                  </div>
                </div>
            </div>
            
            <div class="row minipadding">
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                   <button type="submit" class="btn btn-oranges fullwidth">Submit</button>
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="form-group">
                   <button type="reset" class="btn btn-black-transparent fullwidth" data-dismiss="modal">Cancel</button>
                   </div>
               </div>
            </div>
                
    </form>
          </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->
    <div class="modal fade orange" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modalDialogLabel" aria-hidden="true">

      <div class="modal-dialog">

        <div class="modal-content">

          <div class="modal-header">

            <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>

            <h3 class="modal-title" id="modalDialogLabel">Milestone Prize</h3>

          </div>

          <div class="modal-body">
          <form class="popup-form">
            <div class="form-group">
        <textarea name="textarea" id="textarea" class="form-control wysiwyg"></textarea>
            </div>
            <div class="form-group">
              <div class="row minipadding">
                  <div class="col-md-4">
                        <select name="opton" class="form-control chosen-select">
                            <option> Milestone</option>
                        </select>
                  </div>
                  <div class="col-md-4">
                        <div class="btn btn-file imageupload">
                            <input name="uploadfile" class="form-control" type="file">
                        </div>
                  </div>
                </div>
            </div>
            
            <div class="row minipadding">
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                   <button type="submit" class="btn btn-oranges fullwidth">Submit</button>
                   </div>
               </div>
               <div class="col-md-3">
                   <div class="form-group">
                   <button type="reset" class="btn btn-black-transparent fullwidth" data-dismiss="modal">Cancel</button>
                   </div>
               </div>
            </div>
                
    </form>
          </div>

        </div><!-- /.modal-content -->

      </div><!-- /.modal-dialog -->

    </div><!-- /.modal -->
    <!--Modal-->
<!-- <script src="../assets/js/vendor/summernote/summernote.min.js"></script> -->
<?php echo $this->Html->script('dashboard/vendor/summernote/summernote.min.js')?>
<script type="text/javascript">
  // Image preview  function 
  function readURL(input)
    {
      if (input.files && input.files[0])
      {
        var reader = new FileReader();
        reader.onload = function (e)
        {
          $('#img_preview').attr('src', e.target.result);
          $(".tile-footer").css("display", "block");
          var img = document.getElementById('img_preview');
          $("#base64image").val(img.src);   
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
  $("#imgpre").change(function()
  {
      readURL(this);
  });

  //

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
   

</script>

        






      