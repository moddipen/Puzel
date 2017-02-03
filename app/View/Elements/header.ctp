<div class="mobile-menu" style="padding-bottom: 55px;">
			<section id="collapse">
				<div class="row">
					<div class="mobile-menu-inner">
						<ul class="nav-mobile">
						
						 <li><a href="<?php echo Configure::read('SITE_URL');?>how-it-works">How It Works</a></li>
						 <li><a href="<?php echo Configure::read('SITE_URL');?>puzel-for-business">Puzel for Business</a></li>
						 <li><a href="<?php echo Configure::read('SITE_URL');?>subscriptions/package">Packages</a></li>
						 <li><a href="<?php echo Configure::read('SITE_URL');?>contact">Contact</a></li>
						 <li><a href="http://blog.puzel.co/">Blog</a></li>
                         <?php
							if($this->Session->read("Auth.User"))
							{
						?>
								<li><a href="<?php echo Configure::read('SITE_URL');?>logout">Sign Out</a></li>
						<?php
							}
							else
							{
						?>
								<li><a href="<?php echo Configure::read('SITE_URL');?>user/sign-up">Sign Up</a></li>
								<li><a href="<?php echo Configure::read('SITE_URL');?>login">Sign In</a></li>
						<?php
							}
						 ?>
						 
						 <?php
							if($this->Session->read("Auth.User"))
							{
						?>
								
						<?php
							}
							else
							{
						?>
								 <li><a href="<?php echo Configure::read('SITE_URL');?>pricing">Join as a Business</a></li>
						<?php
							}
						?>
						
						</ul>
					</div>
				</div>
			</section>
                        <a href="<?php echo Configure::read('SITE_URL');?>"><img src="<?php echo $this->webroot ;?>img/logo.png" style="float: left; width: 75px; padding: 5px; margin-left: 15px;"></a>
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
				 <div id="logo"><a href="<?php echo Configure::read('SITE_URL');?>"><img src="<?php echo $this->webroot ;?>img/logo.png"></a></div>
				
				 <ul id="nav">
                 	<?php
							if($this->Session->read("Auth.User"))
							{
						?>
									<li><a href="<?php echo Configure::read('SITE_URL');?>logout" style="margin-right: 0px; padding-right: 0px;"><span class="button-sign">Sign out</span></a></li>
						<?php
							}
							else
							{
						?>
								<li><a href="<?php echo Configure::read('SITE_URL');?>pricing"><span class="button-join">Join as a Business</span></a></li>
								<li><a href="<?php echo Configure::read('SITE_URL');?>login" style="margin-right: 0px; padding-right: 0px;"><span class="button-sign">Sign In</span></a></li>
								<li><a href="<?php echo Configure::read('SITE_URL');?>user/sign-up"><span class="button-sign">Sign Up</span></a></li>
						<?php
							}
						?>
					
				 	
					
					<li><a href="http://blog.puzel.co/">Blog</a></li>
					<li><a href="<?php echo Configure::read('SITE_URL');?>contact">Contact</a></li>
					<li><a href="<?php echo Configure::read('SITE_URL');?>pricing">Packages</a></li>
					<li><a href="<?php echo Configure::read('SITE_URL');?>puzel-for-business">Puzel for Business</a></li>
					<li><a href="<?php echo Configure::read('SITE_URL');?>how-it-works">How It Works</a></li>
                    
				 </ul>
			 
			</nav>
		
		</div>