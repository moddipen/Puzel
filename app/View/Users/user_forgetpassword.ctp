<script type="text/javascript">
$( document ).ready(function() { 
$("form").validate({
	rules: {
		'data[User][email]': {required: true, email: true},
	},
	messages: {
		'data[User][email]': {required: "Please enter a valid email address." },
	}
});});
</script>
<!-- Page content -->
        <div id="content" class="col-md-12 full-page login">
			<div class="inside-block">
                <img src="<?php echo $this->webroot;?>img/logo.png" alt="" class="logo">
                
                 <?php echo $this->Session->flash();?>
                <!-- <form id="form-signin" class="form-signin" > -->
                <?php echo $this->form->create('User',array('action'=>'forgetpassword' , 'class'=>'form-signin','id'=>'form-signin'))?>
                  <section>
                    <div class="input-group">
                      <input type="text" class="form-control" name="data[User][email]" placeholder="Email Address">
                      <div class="input-group-addon"><i class="fa fa-user"></i></div>
                    </div>
                  </section>
                  <section class="log-in">
                    <button class="btn btn-oranges"><b>Get New Password</b></button>
                  </section>
                <?php echo $this->form->end();?>
			</div>
		</div>
        <!-- Page content end -->
