  <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top navbar-transparent-black mm-fixed-top collapsed" role="navigation" id="navbar">

          <!-- Branding -->
          <div class="navbar-header col-md-1">
            <a class="navbar-brand" href="<?php echo Configure::read('SITE_BUSINESS_URL');?>/users/index">
              
            </a>
            <div class="sidebar-collapse hidden-md hidden-lg">
              <a href="#">
                <i class="fa fa-bars"></i>
              </a>
            </div>
          </div>
          <!-- Branding end -->


          <!-- .nav-collapse -->
          <div class="navbar-collapse">
            

            <!-- Sidebar -->
            <ul class="nav navbar-nav side-nav" id="sidebar">
              
             

              <li class="navigation" id="navigation">                
                <ul class="menu">
                  
                  <li>
                    <a href="<?php echo Configure::read('SITE_BUSINESS_URL');?>/users/index">
                      <i class="fa fa-home"></i> Dashboard
                      
                    </a>
                  </li>
                  <li class="active">
                    <a href="<?php echo Configure::read('SITE_BUSINESS_URL');?>/puzzels/index">
                      <i class="fa fa-puzel-icon-left"></i> Puzel
                      
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo Configure::read('SITE_BUSINESS_URL');?>/users/data">
                      <i class="fa fa-database"></i> Data Captured
                      
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo Configure::read('SITE_BUSINESS_URL');?>/orders/index">
                      <i class="fa fa-billing"></i> Billing
                      
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo Configure::read('SITE_BUSINESS_URL');?>/supports/index">
                      <i class="fa fa-support-16"></i> Support
                      
                    </a>
                  </li>
                  <li class="welcome">Welcome Tony!</li>
                      <li>
                        <a href="<?php echo Configure::read('SITE_BUSINESS_URL');?>">
                          <i class="fa fa-cog"></i> Settings
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo Configure::read('SITE_BUSINESS_URL');?>">
                          <i class="fa fa-power-off"></i> Logout
                        </a>
                      </li>
                  </ul>
              
              </li>
                        
            </ul>
            <!-- Sidebar end -->

          </div>
          <!--/.nav-collapse -->

        </div>
        <!-- Fixed navbar end -->