
<div id="container" class="container page-pricing">
  <div class="row">
      <!--Begin Plan Basic!-->
        
       <?php foreach($Plan as $list) {
            ?> 
            <div class="three columns klausbg hvr-grow">
                <div class="klausheader">
                <h5>Basic</h5>
                <span class="klaus_package">package</span>
                <?php if($list['Plan']['price'] != "Free")
                {
                    $rate = $list['Plan']['price']. "$"; 
                }
                else
                {
                    $rate = $list['Plan']['price'];    
                }    
                    ?>
                <span class="klaus_price skinonecolor"><?php echo $rate ;?></span>
                <p>/per month</p>
                </div>
                
                <div class="klaus_features skinoneklaus_features">
                <li><i class="fa fa-check-circle"></i> Design + HTML5 </li>
                <li class="klaus_plancolor"><i class="fa fa-check-circle"></i> One Page Scroll-down Layout</li>
                <li><i class="fa fa-check-circle"></i> Pricing is for 5 vert. sections</li>
                <li class="klaus_plancolor"><i class="fa fa-times-circle"></i> Responsive / Mobile Ready</li>
                <li><i class="fa fa-times-circle"></i> Bootstrap Framework</li>
                <li class="klaus_plancolor"><i class="fa fa-times-circle"></i> CSS3 &amp; jQuery Powered</li>
                </div>  
                
               <div class="klaus_getaquote skinonegetquote"><li><a href="<?php echo Configure::read('SITE_USER_URL');?>/subscriptions/plan/<?php echo $list['Plan']['id'] ;?>">GET A QUOTE</a></li></div>
            </div>
         <?php  }?>   
    
    </div>
  
</div>

<?php echo $this->Html->css('pricing');?>