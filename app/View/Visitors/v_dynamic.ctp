<script type="text/javascript">
    $( document ).ready(function() {  
      $("#puzelacount").click(function()
      {
        $("#signwithpuzzleaccount").val(1);
      });  

      $("#Imagedata").submit(function(e)
      {
        var url = "visitors/process"; // the script where you handle the form input.
       // Form Submit Ajax  
        $.ajax({
                 type: "POST",
                 url: url,
                 dataType: 'json', 
                 data: $("#Imagedata").serialize(), // serializes the form's elements.
                 success: function(data)
                 {

                    

                    if(data.message != "That email address has already taken. Please use another email.")
                    {
                      $.ajax
                        ({
                           type: "POST",
                           url: "visitors/fetchimage/"+data.Id,
                           data:'' ,
                           success:function(data)
                           {
                              $("#puzzle").html(data);
                           }
                      });
                    }
                    else
                    {
                      $("#alert").after("<p>"+data.message+"</p>")
                    }  
                 }
               });

          e.preventDefault(); // avoid to execute the actual submit of the form.
      });
      }); 
    </script>
<!-- NAVIGATION ############################################### -->


    <!-- Mobile Menu --> 
    <div class="mobile-menu" style="padding-bottom: 55px;">
      <section id="collapse">
        <div class="row">
          <div class="mobile-menu-inner">
            <ul class="nav-mobile">
            
             <li><a href="#">Grand Prize</a></li>
            </ul>
          </div>
        </div>
      </section>
      
      <a href="#"><img src="<?php echo $this->webroot;?>img/visitor/img/logo.png" style="float: left; width: 75px; padding: 5px; margin-left: 15px;"></a>
      <a href="#" id="collapse-menu" style="float: right">
        <button class="navbar-toggle">
          <span class="icon-bar top-bar"></span>
          <span class="icon-bar middle-bar"></span>
          <span class="icon-bar bottom-bar"></span>
        </button>
      </a>
    </div>
    <!--  Menu --> 
    <div class="cbp-af-header">
      <nav class="row">
         <div id="logo"><a href="index.php"><img src="<?php echo $this->webroot;?>img/visitor/img/logo.png"></a></div>
        
         <ul id="nav">
                  <li class="no-right"><a href="#"><span class="button-sign">Sign Up Prize</span></a></li>
          <li class="no-right"><a href="#"><span class="button-sign">Milestone Prize</span></a></li> 
                    <li class="no-right"><a href="#"><span class="button-sign">Grand Prize</span></a></li>                     
         </ul>
       
      </nav>
    
    </div> 


<!-- END NAVIGATION ############################################### -->


<!-- HEADER ############################################### -->





<!-- END HEADER ############################################### -->

<!-- BEGIN CONTAINER ############################################### -->


<div id="container" class="container page-hosted">
<h2 class="text-center title-page">Smart Weigh May Giveaway</h2>
 <div class="row"> 
  <div class="col-md-12">
    <div id="puzzle"></div>
    </div>
 </div> 
<div class="row">
  <div class="six columns" id="alert">
      <div class="share-social">
          <h3>Share with your friends</h3>
            <i class="facebook">f</i>
            <i class="twitter">l</i>
            <i class="windows">w</i>
            <i class="email">m</i>
        </div>
    </div>
    <div class="six columns" >
        
      <form id="Imagedata">
          <div class="form-group">
            <input type="text" name="firstname" class="form-control" placeholder="First Name">
            </div>
            <div class="form-group">
            <input type="text" name="lastname"  class="form-control" placeholder="Last Name">
            </div>
            <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Email">
            </div>
  
            <input type = "hidden" name ="puzzlename" value = "<?php echo substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1);?>">
            <input type = "hidden" name ="signwithpuzzleaccount" id ="signwithpuzzleaccount" value = "">
            <div class="form-group text-center">
              <button type="submit" class="btn button-sign">Submit</button><button type="submit" class="btn button-sign" id="puzelacount" name="puzzle" value = "1">Signup with Puzel Account</button>
            </div>
        </form>
    </div>
</div>
</div> <!-- end of container -->
 <script>
$(document).ready(function() {
$('#collapse-menu').on('click', function(){
if($(this).hasClass('active'))
{
   $(this).removeClass('active');
}
else
{
   $(this).addClass('active');
}
});



});
</script>
