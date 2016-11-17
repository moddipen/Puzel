<style type="text/css">
    textarea.note-codable{ display: none;}
    .btn-toolbar{margin-left:0px !important; }
    .note-editable:focus {
      outline: none;
      }
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
                                    <select  class="form-control chosen-select" name="data[Puzzel][type]" id="puzzletype">
                                      <option style="display:none">Type of Puzel</option>
                                      <option value = "Open">Open</option>
                                      <option value = "Mystery">Mystery</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <input name="data[Puzzel][name]" class="form-control" type="text" placeholder="Puzel Name" id="puzzlename">
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
                                    <select name="data[Puzzel][peice]" class="form-control chosen-select" id="validation-pieces">
                                      <option>Number of Pieces</option>
                                      <option value="25">25</option>
                                      <option value="50">50</option>
                                      <option value="75">75</option>
                                      <option value="100">100</option>
                                    </select>
									<p id="validate-pieces"></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="data[Puzzel][transtion]" class="form-control chosen-select">
                                      <option value="Newspaper">Newspaper</option>
                                      <option value="Cube to left">Cube to left</option>
                                      <option value="Cube to right">Cube to right</option>
                                      <option value="Cube to top">Cube to top</option>
                                      <option value="Cube to bottom">Cube to bottom</option>
                                      <option value="Flip right">Flip right</option>
                                      <option value="Flip left">Flip left</option>
                                      <option value="Flip top">Flip top</option>
                                      <option value="Flip bottom">Flip bottom</option>
                                    </select>
                                </div>
                            </div>
                          </div>
                      <!-- </form> -->
                      <?php //echo $this->Form->end();?>
                    </div>
                  </div>
                  <input type = "hidden" name="data[Puzzel][base64]" id="base64image">
                  <input type = "hidden" name="data[Puzzel][user_id]" value="<?php echo $this->Session->read('Auth.User.id');?>">
                  <input type ="hidden" name="data[Puzzel][terms]" value="" id="puzzleterm">
                  <input type ="hidden" name="data[Puzzel][price]" value="" id="puzzleprice">
                  <input type ="hidden" name="data[Puzzel][price_image]" value="" id="pricepuzzle">
                  <input type ="hidden" name="data[Puzzel][compnay_name]" value="<?php echo $this->Session->read('Auth.User.company_name');?>" id="pricepuzzle">
                 <div class="body" id="showimage">
                    <img src="#" class="img-responsive" id="img_preview" alt="Please upload your image" />
                  </div>
                  </div>
                  <!-- /tile body -->
                  <input type = "hidden" value="" id="clickterm"/>
                  <input type = "hidden" value="" id="clickprize"/>
          
                  <!-- tile footer -->
                  <div class="tile-footer text-center" style="display:none">
                    <div class="form-group">
                      <input type="button" class="btn btn-black-transparent changebutton" value="Terms / Description" data-toggle="modal" data-target="#modal1" id="clickzone">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-black-transparent" value="Grand Prize" data-toggle="modal" data-target="#modal3" id="clickpricezone">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-oranges" id="validateform">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;
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
              <div class="row">
                  <div class="col-md-5">
                        <select name="opton" class="form-control chosen-select" id = "changetemplate">
                            <option style="display:none">Select previous template</option>
                            <?php 
                            if(!empty($Name))
                            {  
                              foreach ($Name as $value)
                                {?>
                                <option value ="<?php echo $value['Puzzle']['id']; ?>"><?php echo $value['Puzzle']['name']; ?></option>
                            <?php } }?>
                        </select>
                  </div>
                </div>
            </div>

            <div class="form-group">
              <textarea name="textarea" id="textarea" class="form-control wysiwyg"></textarea>
            </div>
            
            <div class="row minipadding">
                <div class="col-md-3"></div>
                <div class="col-md-3">
                   <div class="form-group">
                    <button type="button" id="submitterms"class="btn btn-oranges fullwidth">Submit</button>
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
                <textarea name="textarea" id="textarea" class="form-control wysiwyg"></textarea>
              </div>
              <div class="form-group">
                <div class="row minipadding">
                    <div class="col-md-4">
                      <div class="btn btn-file imageupload">
                          <input name="data[Puzzle][uploadfile]" class="form-control" type="file" id="filecontent">
                      </div>
                    </div>
                  </div>
              </div>
              <div class="row minipadding">
                  <div class="col-md-3">
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                     <button type="submit" class="btn btn-oranges fullwidth" id="grandprice">Submit</button>
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

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
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
  
   $("#validation-pieces").change(function()
  {
		
	 $.ajax(
       {
         type: "POST",
         url: "<?php echo Configure::read("SITE_URL");?>puzzles/checkpieces",
           data: {'pieces':$(this).val()}, 
		   dataType : "json",
        success: function(data)
         {
            if(data.message != "Success")
      			{
      				$("#validate-pieces").html(data.message);
      			}
      			else
      			{
      				$("#validate-pieces").html("");
      			}
				
         }
       });
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


   // Form submit term and description save 
     
    $('#submitterms').click(function()
    {
       var html = $('.note-editable').html(); 
       if(html == "<p><br></p>")
       {
           $("#modal1" ).effect("shake");
          //$('#modal1').shake("fast");  
          return false; 
       }
       else
       {
          $.ajax(
           {
             type: "POST",
             url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/terms",
             data: {'content':html}, 
            success: function(data)
             {
                $('#modal1').modal('hide');
             }
           });
       } 
    });  

    // Save grand price of puzzle 

   $("#grand_price").on('submit',(function(e) 
    {
      e.preventDefault();
       
      var html = $('.note-editable').html(); 
       $.ajax(
       {
        type: "POST",
        url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/price",
        // data: {'price':html,'image':$('#filecontent').val()}, 
        data: new FormData(this),
    		contentType: false,
    		cache: false,
    		processData:false,		 
            success: function(data)
         {
            //alert($('#filecontent').val());
            $('#modal3').modal('hide');
            $('#pricepuzzle').val($('#filecontent').val());
         }
       });
    }));  

    // On change event in templete

    $("#changetemplate").change(function()
    {
      $.ajax(
       {
         type: "POST",
         url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/template",
         data: {'id':this.value,'type':'terms'}, 
         dataType: 'json', 
         success: function(data)
         {
            $('.note-editable').html(data.Puzzle.terms);
            $('#puzzleterm').val(data.Puzzle.terms);  
          }
       });
      // alert();
    })


    $("#changeprice").change(function()
    {
      $.ajax(
       {
         type: "POST",
        url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/template/"+this.value,
         data: {'id':this.value,'type':'price'}, 
         dataType: 'json', 
         success: function(data)
         {
            $('.note-editable').html(data.Puzzle.price);
            $('#puzzleprice').val(data.Puzzle.price);   
          }
       });
      // alert();
    })

    // check user is click on term button or not 
    $("#clickzone").click(function()
    {
      $("#clickterm").val("22");
    });
    // check if user click on price not 
    $("#clickpricezone").click(function()
    {
      $("#clickprize").val("22");
    });
       
    // validation form 

    $("#PuzzleViewForm").submit(function(e)
    {
      if($('#clickterm').val()=='')
      {
        alert("Please click on Term and description");
        e.preventDefault();  
      }
      if($('#clickprize').val() == '')
      {
        alert("Please click on Grandprize button");
        e.preventDefault();   
      }
      if($("#puzzletype").val() == $("#puzzletype option:first").val())
      {
        alert("Please select on puzzle type");
        e.preventDefault();    
      }
      if($("#puzzlename").val() =='')
       {
          alert("Please enter puzzle name");
          e.preventDefault();      
       } 
      
    });




</script>

        






      