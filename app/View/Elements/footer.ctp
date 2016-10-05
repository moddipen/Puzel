<div class="row">

		<div class="twelve columns centered">

			<div class="hi-icon-wrap">
			         
                <ul class="three_up tiles centered">
                    
                    <li>
                    <a href="#join"><img src="<?php echo $this->webroot ;?>img/join.png" /></a>
                    <h4>Join</h4>
                    </li>
                    
                    <li>
                    <a href="#share"><img src="<?php echo $this->webroot ;?>img/share.png" /></a>
                    <h4>Share</h4>
                    </li>
                    
                    <li>
                    <a href="#connect"><img src="<?php echo $this->webroot ;?>img/connect.png" /></a>
                    <h4>Connect</h4>
                    </li>
                
                </ul>
            
  			</div>
		</div>
        

	</div>
    <div class="row padding-row">
    <div class="six columns text-right">
         <a href="<?php echo Configure::read('SITE_USER_URL');?>/users/register" style="margin-right:20px; padding-bottom:15px; display: inline-block;"><span class="button-sign">Sign Up</span></a>
          
        </div>
        <div class="six columns">
          <a href="<?php echo Configure::read('SITE_USER_URL');?>/users/register/business"><span class="button-join">Join as a Business</span></a>
        </div>
    </div>

<footer id="footer">

	<div class="row">

		<!-- Footer Navigation -->

		<div class="six columns pull_left">
			
		
				 <ul id="navfirst">
				 
					 <li><a href="<?php echo Configure::read('SITE_URL');?>users/about">How It Works</a></li>
					 
					 <li><a href="<?php echo Configure::read('SITE_URL');?>users/business">Puzel for Business</a></li>
					 
					 <li><a href="<?php echo Configure::read('SITE_URL');?>users/contact">Contact</a></li>
					 
				 </ul>
          	
		</div>
		<!-- Text from left -->
		
		
<div class="six columns text-right social">
		
			<a href="https://www.facebook.com/sharethepuzel" target="_blank"><i class="facebook">f</i></a>
            <a href="https://twitter.com/puzelco" target="_blank"><i class="twitter">l</i></a>
            <a href="mailto:connect@puzel.co" target="_blank"><i class="envelope">m</i> <span>connect@puzel.co </span></a>

		</div>

		

	</div>

</footer>


<!-- END FOOTER SECTION ############################################### -->


</div> <!-- end of container -->


  <!-- Grab Google CDN's jQuery, fall back to local if offline -->
  <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script>
  <script src="js/main.js" type="text/javascript"></script>--> <!-- Main Javascript File -->
  <!--<script src="js/plugins.js" type="text/javascript"></script>--> <!--Plugins File -->
  <!--<script src="js/cbpScroller.js" type="text/javascript"></script>--> <!-- Scroll from left & right -->
  <!--<script src="js/classie.js" type="text/javascript"></script>--> <!-- Scroll from left & right -->
  <!--<script src="js/jquery.scrollto.js" type="text/javascript"></script>--> <!-- ScrollTo for Button -->
  <!--<script src="js/jquery.parallax-1.1.3.js" type="text/javascript"></script>--> <!-- Parallax -->
  <!--<script src="js/jquery.flexslider.js" type="text/javascript"></script>--> <!-- FlexSlider -->

<?php 
  echo $this->Html->script("jquery.min");
  echo $this->Html->script("jquery-1.9.1.min.js");
  echo $this->Html->script("main");
  echo $this->Html->script("plugins");
  echo $this->Html->script("cbpScroller");
  echo $this->Html->script("classie");
  echo $this->Html->script("jquery.scrollto");
  echo $this->Html->script("jquery.parallax-1.1.3");
  echo $this->Html->script("jquery.flexslider");
?>





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

 $(window).load(function() {
       $('.vuong').css('height',$('#get-h').height()+'px');
    });

});
</script>
 

  