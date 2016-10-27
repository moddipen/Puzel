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
               <!-- /cards -->
            <?php echo $this->Session->flash();?> 
             <div class="pagesubheader">
            

              <h2><i class="fa fa-puzel-icon-left-big"></i> Puzel</h2>

            </div>

            <div id="alert"></div>
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
                  <div class="tile-body">
                  <div class="row">
                    <div class="col-md-10">
                      <form role="form" class="custom-form">
                          <div class="row minipadding">
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="user" class="form-control chosen-select">
                                      <option value="">All Users</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="datetime" class="form-control chosen-select">
                                      <option value="">Today</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                  <div class="input-group">
                                      <span class="input-group-addon nobackground">From</span>
                                        <input name="startdate" id="startdate" class="form-control filter_date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                    </div>
                                </div>
                            </div>
                            <input type ="hidden" value="" id="selectedstartdate">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon nobackground">To</span>
                                        <input name="enddate" id="enddate" class="form-control date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                     </div>
                                </div>
                            </div>
                            <input type ="hidden" value="" id="selectedenddate">
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="by" class="form-control chosen-select" id="status">
                                      <option style ="display:none;">Status</option>
                                      <option value="0">Active</option>
                                      <option value="1">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                  <input type="text" value="" name="search" class="form-control">
                                </div>
                            </div>
                          </div>
                      </form>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                          <?php if(AuthComponent::user('status') == 1)
                          {?>
                          <input type="button" value="Account Deactivate" class="btn btn-oranges pull-right">
                          <?php 
                          }
                          else{?>
                          <input type="button" value="Create Puzel" onClick="location.href='<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/create';" class="btn btn-oranges pull-right">
                          <?php } ?>

                          
                        </div>
                    </div>
                  </div>
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                        <thead>
                          <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Puzel Name</th>
                            <th class="text-center">Pieces Used</th>
                            <th class="text-center">Balance Pieces</th>
                            <th class="text-center">Data Captured</th>
                             <?php if(AuthComponent::user('status') != 1)
							  {?>
								<th class="text-center">Options</th>
							  <?php 
							  }
							?>
                          </tr>
                        </thead>
                        <tbody id="content1">
                        <?php if(!empty($Puzzel))
                        {
                          
                          foreach ($Puzzel as $puzel) {  
                           

                            ?>
                          <tr>
                            <td><?php echo date('m/d/Y',strtotime($puzel['Puzzle']['created']))?></td>
                            <td><?php echo $puzel['Puzzle']['name']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->html->link('',array('action' => 'preview',$puzel['Puzzle']['id']),array('class'=>'fa fa-eye','style'=>"color:white;"));
                              echo "&nbsp;&nbsp;"; ?></td>
                            <td><?php echo $puzel['Puzzle']['pieces']?></td>
                            <td><?php echo $puzel['Show']?></td>
                            <td><?php echo $puzel['Hide']?>&nbsp;&nbsp;
                            <?php 
                            if($puzel['Hide'] != '')
                            {
                              echo $this->html->link('',array('action' => 'export',$puzel['Puzzle']['id']),array('class'=>'fa fa-download-16px','style'=>"color:white;"));
                              echo "&nbsp;&nbsp;";
                              echo $this->html->link('',array('controller'=>'visitors','action' => 'data',$puzel['Puzzle']['id']),array('class'=>'fa fa-eye','style'=>"color:white;"));
                            
                            }
                            ?>
                            </td>
							<?php if(AuthComponent::user('status') != 1)
							  {?>
								
							  
                            <td class="minipadding controls">
                              <input type ="hidden" value = "<?php echo $puzel['Puzzle']['id'];?>" class ="puzelid" >
                              <div class="col-xs-5 text-right"> <?php 

                               if(AuthComponent::user('status') == 1)
                               {?>
                                 <i class ='fa fa-pencil'></i>
                               <?php }
                               else
                               {
                                echo $this->html->link('',array('action' => 'edit',$puzel['Puzzle']['id']),array('class'=>'fa fa-pencil','style'=>"color:white;"));     
                               } 
                            ?><!-- <i class="fa fa-pencil"></i> --></div>
                              <?php 
                              if(AuthComponent::user('status') == 1)
                               {?>
                                <div class="col-xs-7">
                                <div class="onoffswitch green small">
                                  <?php 
                                    // check puzzle s activate or not
                                    if($puzel['Puzzle']['status'] == 0)
                                    {
                                      $puzzle = "checked='checked'";
                                    }
                                    else
                                     {
                                       $puzzle = '';
                                     } 

                                  ?> 
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch<?php echo $puzel['Puzzle']['id'];?>" <?php echo $puzzle;?> value = "<?php echo $puzel['Puzzle']['id'];?>" disabled="disabled">
                                  <label class="onoffswitch-label" for="onoffswitch<?php echo $puzel['Puzzle']['id'];?>">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div>
                              </div>


                                <?php }
                                else
                                  {?>

                              <div class="col-xs-7">
                                <div class="onoffswitch green small">
                                  <?php 
                                    // check puzzle s activate or not
                                    if($puzel['Puzzle']['status'] == 0)
                                    {
                                      $puzzle = "checked='checked'";
                                    }
                                    else
                                     {
                                       $puzzle = '';
                                     } 

                                  ?> 
                                  <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch<?php echo $puzel['Puzzle']['id'];?>" <?php echo $puzzle;?> value = "<?php echo $puzel['Puzzle']['id'];?>">
                                  <label class="onoffswitch-label" for="onoffswitch<?php echo $puzel['Puzzle']['id'];?>">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                  </label>
                                </div>
                              </div>
                              <?php }?>
                            </td>
							<?php 
							  }
							?>
                          </tr>
                          <?php }}?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /tile body -->


                  <!-- tile footer -->
                  <div class="tile-footer text-center">
                    <ul class="pagination pagination-sm nomargin pagination-custom" id="pagination">
                    </ul>
                  </div>
                  <!-- /tile footer -->



                </section>
                <!-- /tile -->


              </div>
              <!-- /col 8 -->



              <!-- col 4 -->
              
              <!-- /col 4 -->
              
              
            </div>
            <!-- /row -->

          </div>
          <!-- /content container -->
     </div>
     
<script type="text/javascript">
          /* pagination plugin */
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 10,
            showPrevNext: true,
            numbersPerPage: 2,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = $('#pagination');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    var curr = 0;
    pager.data("curr",curr);
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
  
    if (settings.numbersPerPage>1) {
       $('.page_link').hide();
       $('.page_link').slice(pager.data("curr"), settings.numbersPerPage).show();
    }
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
    pager.children().eq(0).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }
        
        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
       
        if (settings.numbersPerPage>1) {
          $('.page_link').hide();
          $('.page_link').slice(page, settings.numbersPerPage+page).show();
      }
      
        pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};
/* end plugin */

$(document).ready(function(){
    
  $('#content1').pageMe({pagerSelector:'#pagination',childSelector:'tr',showPrevNext:true,hidePageNumbers:false,perPage:10});
    

       
// On off   button code  

    $('input[type="checkbox"]').click(function()
    {
      // if button activate
      if (this.checked)
      {
        $.ajax(
        {
          url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/active/"+this.value,
          type: "post",
          datatype:"json",
          data: {'id':this.value} ,
          success: function (data)
          {
              // Button message 
              $("#alert").html("<div style='background:rgba(60,118,61,0.5);color:#3C763D;font-size:14px;padding:20px'>Puzzle activated</div>");
              $("#alert").show().delay(3000).fadeOut();
          },
        }); 
      }
      // when button is deactivate
      else
      {
        $.ajax(
        {
          url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/deactive/"+this.value,
          type: "post",
          datatype:"json",
          data: {'id':this.value} ,
          success: function (data)
          {
            // button alert message 
            $("#alert").html("<p style='background:rgba(169,68,66,0.5);color:#A94442;font-size:14px;padding:20px;margin-bottom:10px;'>Puzzle deactivate</p>");
            $("#alert").show().delay(3000).fadeOut();
          }
        });   
      } 
    });

// Filter Module 


  // Active puzzle filter

  $("#status").change(function()
  {
    var status = this.value ;
    $.ajax(
    {
      type: "POST",
      url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/status",
      data: {'status':status},
      success: function(data)
      {
        $("#content1").html(data);
      }
    });  
  })

  // Calender Filter 
  $('#startdate').datepicker({ format: 'yyyy-mm-dd', autoclose: true}).on('changeDate',function(event){
      var d = event.date; //Selected date in Timezone format
      var curr_date = d.getDate(); // Seletced date
      var curr_month = d.getMonth() + 1; // Selected date moth
      var curr_year = d.getFullYear(); // Selected date year
      var desired_date_fromat = curr_year+"-"+curr_month+"-"+curr_date; //Desired date format 
      $("#selectedstartdate").val(desired_date_fromat);
    });
      
  $('#enddate').datepicker({ format: 'yyyy-mm-dd', autoclose: true}).on('changeDate',function(event){
    var d = event.date; //Selected date in Timezone format
    var curr_date = d.getDate(); // Seletced date
    var curr_month = d.getMonth()+ 1; // Selected date moth
    var curr_year = d.getFullYear(); // Selected date year
    var desired_date_fromat = curr_year+"-"+curr_month+"-"+curr_date; //Desired date format 
    $("#selectedenddate").val(desired_date_fromat);

    $.ajax(
    {
      type: "POST",
      url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/puzzles/datefilter",
      data: {'startdate':$("#selectedstartdate").val(),'enddate':$("#selectedenddate").val()},
      success: function(data)
      {
        $("#content1").html(data);
      }
    });  
















  });












});

</script>      