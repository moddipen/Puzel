  <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top navbar-transparent-black mm-fixed-top collapsed" role="navigation" id="navbar">

          <!-- Branding -->
          <div class="navbar-header col-md-1">
            <a class="navbar-brand" href="<?php echo Configure::read('SITE_ADMIN_URL');?>/users/index">
              
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
                    <a href="<?php echo Configure::read('SITE_ADMIN_URL');?>/users/index">
                      <i class="fa fa-home"></i> Dashboard
                      
                    </a>
                  </li>
                  <li class="active">
                    <a href="<?php echo Configure::read('SITE_ADMIN_URL');?>/users/business">
                      <i class="fa fa-briefcase"></i> Business
                      
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo Configure::read('SITE_ADMIN_URL');?>/users/index">
                      <i class="fa fa-users"></i> Users
                      
                    </a>
                  </li>
                  
                  <li class="active">
                    <a href="<?php echo Configure::read('SITE_ADMIN_URL');?>/puzzles/index">
                      <i class="fa fa-puzel-icon-left"></i> Puzel
                      
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo Configure::read('SITE_ADMIN_URL');?>/users/data">
                      <i class="fa fa-database"></i> Data Captured
                      
                    </a>
                  </li>
                  <li>
                    <a href="<?php echo Configure::read('SITE_ADMIN_URL');?>/supports/index">
                      <i class="fa fa-support-16"></i> Support
                      
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
                      
                      <li>
                        <a href="<?php echo Configure::read('SITE_ADMIN_URL');?>/users/setting">
                          <i class="fa fa-cog"></i> Settings
                        </a>
                      </li>
                      <li>
                        <a href="<?php echo Configure::read('SITE_USER_URL');?>/users/logout">
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

     <script type="text/javascript">

    $(function(){
        var current_page_URL = location.href;
        var menu = window.location.href;
        $( "a" ).each(function() {
            if($(this).attr("href") !== "#") 
            {
                var target_URL = $(this).prop("href");
                if (target_URL == current_page_URL) 
                {
                  $('.nav li.active').removeClass('active');
                  $('a[href^="'+document.location+'"]').parent('li').addClass('active');
                  return false;
                }
            }
        });
    }); 


    </script>      