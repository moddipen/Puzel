

      
                
        <!-- Page content -->
        <div id="content" class="col-md-12">

          <!-- content main container -->
          <div class="main">
            <!-- cards -->
            <?php echo $this->element('admin/header');?>
            <!-- /cards -->
            
             <div class="pagesubheader">
            

              <h2><i class="fa fa-briefcase"></i> Business</h2>

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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon nobackground">To</span>
                                        <input name="enddate" id="enddate" class="form-control date">
                                        <span class="input-group-addon nobackground"><i class="fa fa-calendar fa-2x"></i></span>
                                     </div>
                                </div>
                            </div>                            
                          </div>
                      </form>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group iconwithtext">
                          <i class="fa fa-downloads"></i> <span class="text">Download as CSV</span>
                        </div>
                    </div>
                  </div>
                    <div class="table-responsive">
                      <table class="table nomargin text-center">
                        <thead>
                          <tr>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Company Name</th>
                            <th class="text-center">Puzels Created</th>
                            <th class="text-center">Active Puzels</th>
                            <th class="text-center">Balance Credits</th>
                            <th class="text-center">Membership Plan</th>
                            <th class="text-center">Options</th>
                          </tr>
                        </thead>
                        <tbody id = "content1">
						
                        <?php if(!empty($Business)) {
								            foreach ($Business as $user) {
                              ?>
                          <tr>
                            <td><?php echo $user['User']['firstname'] ;?></td> 
                            <td><?php echo $user['User']['lastname'] ;?></td>
                            <td><?php echo $user['User']['company_name'] ;?></td>
                            <td><?php echo count($user['Puzzle']); ?></td>
                            <td><?php
                  								$index = 1;
                  								$count = 0;
                  								foreach($user['Puzzle'] as $puz)
                  								{
                  									if($puz['status'] == 0)
                  									{
                  										$count = $index;
                  										$index ++;
                  									}
                  								}
                  								echo $count;
                  							?></td>
                            <td><?php if($user['UserSubscription']['id'] != ""){echo $user['UserSubscription']['used_pieces'];}else{echo "0";}?></td>
                            <td><?php if($user['UserSubscription']['id'] != ""){echo $user['UserSubscription']['Subscription']['name'];}else{echo "Inactive";}?></td>
                            <td class="minipadding controls"><div class="col-xs-5 text-right"><i class="fa fa-eye"></i></div><div class="col-xs-7">
                              <div class="onoffswitch green small">
                                 <?php 
                                    // check puzzle s activate or not
                                    if($user['User']['status'] == 0)
                                    {
                                      $status = "checked='checked'";
                                    }
                                    else
                                     {
                                       $status = '';
                                     } 

                                  ?> 
                                 
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="onoffswitch_<?php echo $user['User']['id'];?>" <?php echo $status;?> value ="<?php echo $user['User']['id'];?>">
                                    <label class="onoffswitch-label" for="onoffswitch_<?php echo $user['User']['id'];?>">
                                      <span class="onoffswitch-inner"></span>
                                      <span class="onoffswitch-switch"></span>
                                    </label>
                                  </div></div>
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
  $(document).ready(function()
  {
      
    $('#content1').pageMe({pagerSelector:'#pagination',childSelector:'tr',showPrevNext:true,hidePageNumbers:false,perPage:10});
    
    /* end plugin */

// On off   button code  

    
  $( document ).delegate( "input[type='checkbox']", "click", function() 
    {
      // if button activate
      if (this.checked)
      {
        $.ajax(
        {
          url: "<?php echo Configure::read('SITE_ADMIN_URL')?>/users/active/"+this.value,
          type: "post",
          datatype:"json",
          data: {'id':this.value} ,
          success: function (data)
          {
              // Button message 
              $("#alert").html("<div style='background:rgba(60,118,61,0.5);color:#A94442;font-size:14px;padding:20px'>User activated</div>");
              $("#alert").show().delay(3000).fadeOut();
          },
        }); 
      }
      // when button is deactivate
      else
      {
        $.ajax(
        {
          url: "<?php echo Configure::read('SITE_ADMIN_URL')?>/users/deactive/"+this.value,
          type: "post",
          datatype:"json",
          data: {'id':this.value} ,
          success: function (data)
          {
            // button alert message 
            $("#alert").html("<p style='background:rgba(169,68,66,0.5);color:#A94442;font-size:14px;padding:20px;margin-bottom:10px;'>User deactivate</p>");
            $("#alert").show().delay(3000).fadeOut();
          }
        });   
      } 
    });


  });




</script>
        






      