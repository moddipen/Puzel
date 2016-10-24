

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('business/header');?>
            
                <!-- /cards -->
            <?php echo $this->Session->flash(); ?>
             <div class="pagesubheader">
            

              <h2><i class="fa fa-support-32"></i> Support</h2>

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
                                        <input name="startdate" id="startdate" class="form-control date">
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
                                    <select name="by" class="form-control chosen-select">
                                      <option value="">Email Address</option>
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
                          <input type="button" value="Create Request" onClick="location.href='<?php echo Configure::read('SITE_BUSINESS_URL');?>/supports/add';" class="btn btn-oranges pull-right">
                        </div>
                    </div>
                  </div>
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                        <thead >
                          <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Date / Time</th>
                            <th class="text-center">Options</th>
                          </tr>
                        </thead>
                        <tbody id = "black">
                          <?php if(!empty($Supports))
                            {
                              foreach ($Supports as  $singlesupport)
                              {
                                $user = AuthComponent::user();
                                ?>
                          <tr>
                            <td><?php 
                                  // check in list that list in name is not a login user name
                                  if($singlesupport['Sender']['id'] != $user['id'])
                                  {
                                    $name = $singlesupport['Sender']['firstname'];
                                  }
                                  else
                                  {
                                    $name = $singlesupport['Receiver']['firstname']; 
                                  }  
                                  echo $name;?></td>
                            <td><?php echo $singlesupport['Support']['subject'];?></td>
                            <td><?php echo date('g:i A dS M Y',strtotime($singlesupport['Support']['created']));?></td>
                            <td>
                              <?php 
                              echo $this->html->link( '',array('action' => 'conversation',$singlesupport['Support']['id']),array('class'=>'fa fa-comments','style'=>"color:white;"));
                              echo "&nbsp; &nbsp;";
                              echo $this->html->link( '',array('action' => 'delete',$singlesupport['Support']['id']),array('class'=>'fa fa-trash-o','style'=>"color:white;"),' Do you want to delete this record?');
                              ?>
                            </td>
                          </tr>
                          <?php  } }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- /tile body -->


                  <!-- tile footer -->
                  <div class="tile-footer text-center">
                    <ul class="pagination pagination-sm nomargin pagination-custom" id="myPager">
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
          <!-- /content container -->






        </div>
        <!-- Page content end -->


 <script>
    $(function(){
    $(".chosen-select").chosen({disable_search_threshold: 10});
    $('.date').datepicker({ format: 'yyyy-mm-dd', autoclose: true});
    $('.input-group span.input-group-addon').click(function(){
      $(this).parent().children('input.date').focus();
    });
      // Initialize card flip
      $('.card.hover').hover(function(){
        $(this).addClass('flip');
      },function(){
        $(this).removeClass('flip');
      });  
      
    })

       /* pagination plugin */
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 5,
            showPrevNext: true,
            numbersPerPage: 1,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = $('.pagination');
    
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
$(document).ready(function()
{
    
  $('#black').pageMe({pagerSelector:'#myPager',childSelector:'tr',showPrevNext:true,hidePageNumbers:false,perPage:5});


  // Filter Module 

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
      url: "<?php echo Configure::read('SITE_BUSINESS_URL')?>/supports/datefilter",
      data: {'startdate':$("#selectedstartdate").val(),'enddate':$("#selectedenddate").val()},
      success: function(data)
      {
        $("#black").html(data);
      }
    });
    });  
 



    
});



      
    </script>


      