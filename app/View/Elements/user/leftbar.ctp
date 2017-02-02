  <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top navbar-transparent-black mm-fixed-top collapsed" role="navigation" id="navbar">

          <!-- Branding -->
          <div class="navbar-header col-md-1">
            <a class="navbar-brand" href="<?php echo Configure::read('SITE_URL');?>puzel">
              
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
                  
                  <!-- <li>
                    <a href="<?php echo Configure::read('SITE_USER_URL');?>/puzzles/index">
                      <i class="fa fa-home"></i> Dashboard
                      
                    </a>
                  </li> -->
                  
                   <?php 
                    if($main == "Puzzle")
                      {
                        if($sub == "index") 
                        {
                          $mainClass = "active";  
                        }
                        else
                        {
                          $mainClass = "";
                        }  
                      }
                      else
                        {
                          $mainClass = "";
                        } ?>
                  <li class="<?php echo $mainClass;?>">
                    <a href="<?php echo Configure::read('SITE_URL');?>puzels">
                      <i class="fa fa-puzel-icon-left"></i> Puzel
                      
                    </a>
                  </li>
                  <?php 
                    if($main == "Support")
                      {
                        if($sub == "index" || $sub == "add" || $sub == "conversation")
                        {
                          $mainClass = "active";  
                        }
                        else
                        {
                          $mainClass = "";
                        }  
                      }
                      else
                        {
                          $mainClass = "";
                        } ?>
                  <li class="<?php echo $mainClass;?>">
                    <a href="<?php echo Configure::read('SITE_URL');?>supports">
                      <i class="fa fa-support-16"></i> Support
                      
                    </a>
                  </li>
                  <li class="<?php echo $mainClass;?>">
                    <a href="<?php echo Configure::read('SITE_URL');?>top-20-puzels">
                      <i class="fa fa-puzel-icon-left"></i> Most recent 20 puzels
                      
                    </a>
                  </li>
                  <li class="welcome"><?php 
                      
                      if(AuthComponent::user('User'))
                      {
                        $user = AuthComponent::user('User');
                        $login_detail = $user['firstname'].' '.$user['lastname'];
                      }
                      if(AuthComponent::user('id'))
                      {
                        $user = AuthComponent::user();
                        $login_detail = $user['firstname'].' '.$user['lastname']; 
                      }  
                      echo $login_detail;?>!</li>
                        <?php 
                    if($main == "User")
                      {
                        if($sub == "setting") 
                        {
                          $mainClass = "active";  
                        }
                        else
                        {
                          $mainClass = "";
                        }  
                      }
                      else
                        {
                          $mainClass = "";
                        } ?>
                       <li class="<?php echo $mainClass;?>">
                        <a href="<?php echo Configure::read('SITE_URL');?>settings">
                          <i class="fa fa-cog"></i> Settings
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo Configure::read('SITE_URL');?>logout">
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
