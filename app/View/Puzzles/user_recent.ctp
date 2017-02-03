  <style type="text/css">
    .pagesubheader .title, .pagesubheader .alert{float: left;}
    .alert{margin-left: 20px;margin-top: 25px;font-size: 16px;color:#FFF;}
    .title {margin-bottom: 15px;}
</style>
     



       <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('user/header');?>
               <!-- /cards -->
             <div class="pagesubheader">
              <h2 class="title"><i class="fa fa-puzel-icon-left-big"></i> Most recent 20 puzels</h2><div id="alert" class="alert"><?php echo $this->Session->flash();?> 
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
                  <!--<div class="row">
                    <div class="col-md-10">
                      <form role="form" class="custom-form">
                          <div class="row minipadding">
                            <!-- <div class="col-md-2">
                              <div class="form-group">
                                    <select name="user" class="form-control chosen-select">
                                      <option value="">All Puzels</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <select name="datetime" class="form-control chosen-select" id="datetime">
                                      <option style="display:none;" >Please select</option>
                                      <option value="Today">Today</option>
                                      <option value="Weeks">Weeks</option>
                                      <option value="Month">Month</option>
                                      <option value="Year">Year</option>
                                      <option value="AllTime">All time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                  <div class="input-group">
                                        <input name="startdate" id="startdate" class="form-control date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                    </div>
                                </div>
                            </div>
                            <input type ="hidden" value="" id="selectedstartdate">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon nobackground newposition">To</span>
                                        <input name="enddate" id="enddate" class="form-control date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                     </div>
                                </div>
                            </div>
                            <input type ="hidden" value="" id="selectedenddate">
                          </div>
                      </form>
                    </div>
                  </div>-->
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                       <!--  <thead>
                          <tr>
                            <th class="text-center">Companyname</th>
                            <th class="text-center">Launch</th>
                            <th class="text-center">Puzel Name</th>
                            <th class="text-center">Click here to Enroll Now</th>
                          </tr>
                        </thead> -->
                        <tbody id ="datafile">
                        <?php 
                       
                        if(!empty($Puzzel)) {
                          foreach ($Puzzel as $value) {  ?>
                            <tr>
                              <td><?php echo $value['Business']['company_name'];?></td>
                              <td>Launch</td>
                              <td><?php echo $value['Puzzle']['name'];?></td>
                              <td><!-- <a target="_blank" style="color: rgba(255, 255, 255, 0.9);" href="<?php echo Configure::read("SITE_URL").$value['Business']['company_name']."/".$value['Puzzle']['random'];?>"><?php echo Configure::read("SITE_URL").$value['Business']['company_name']."/".$value['Puzzle']['random'];?></a> -->
                              <a  style="color: rgba(255, 255, 255, 0.9);" href="javascript:void(0)" onclick="mostrecent('<?php echo $value['Puzzle']['random'];?>','<?php echo Configure::read("SITE_URL").$value['Business']['company_name']."/".$value['Puzzle']['random'];?>')"> - Click here to Enroll Now</a>



                              </td>
                            </tr>
                         <?php } }?>
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
        <!-- Page content end -->

<script>
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
    
  $('#datafile').pageMe({pagerSelector:'#pagination',childSelector:'tr',showPrevNext:true,hidePageNumbers:false,perPage:10});

///////////////////////////////////////////////////// Filter Module ---------------------------------------

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
      url: "<?php echo Configure::read('SITE_URL')?>date",
      data: {'startdate':$("#selectedstartdate").val(),'enddate':$("#selectedenddate").val()},
      success: function(data)
      {
      $("#datafile").html(data);
      }
    });  
  });  


    //////////////////////////////// Monthwise filter -----------------------------------------
  
  $("#datetime").change(function()
  {
    var value = this.value;
    var d = new Date();
    var c_date = ((d.getDate())>=10)? (d.getDate()) : '0' + (d.getDate());
    
    var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + c_date;
    
    if(value == "Today"){ $("#startdate").val(strDate); $("#enddate").val(strDate);}
    if(value == "Weeks"){   
      d.setDate(d.getDate() - 7);
      var c_date = ((d.getDate())>=10)? (d.getDate()) : '0' + (d.getDate());
      $("#enddate").val(strDate);
      $("#startdate").val(d.getFullYear() + "-" + (d.getMonth()+1) + "-" + c_date);
    }
    if(value == "Month"){
      d.setMonth(d.getMonth() - 1);
      var c_date = ((d.getDate())>=10)? (d.getDate()) : '0' + (d.getDate());
      $("#enddate").val(strDate);
      $("#startdate").val(d.getFullYear() + "-" + (d.getMonth()+1) + "-" + c_date);
    }
    if(value == "Year"){
      d.setYear(d.getFullYear() - 1);
      var c_date = ((d.getDate())>=10)? (d.getDate()) : '0' + (d.getDate());
      $("#enddate").val(strDate);
      $("#startdate").val(d.getFullYear() + "-" + (d.getMonth()+1) + "-" + c_date);
      
    }
    if(value == "AllTime")
    {
      $("#startdate").val("");
      $("#enddate").val("");
    } 
    $.ajax(
      {
        type: "POST",
        url: "<?php echo Configure::read('SITE_URL')?>date",
        data: {'startdate':$("#startdate").val(),'enddate':$("#enddate").val()},
        success: function(data)
        {
        $("#datafile").html(data);
        }
      });  
  })
});

  function mostrecent(id,url)
  { 
      $(".mask").show();
      $("#loader").show() ; 
      
      $.ajax(
      {
        type: "POST",
        url: "<?php echo Configure::read('SITE_USER_URL')?>/puzzles/recentclick/"+id,
        data: {'random':id},
        success: function(data)
        {
          $("#loader").hide() ; 
          $(".mask").hide();   
          window.open(url,'_blank');
        }
      });  
  } 

                                 
</script>
      