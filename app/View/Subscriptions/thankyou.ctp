<style>
.twelve {display:none;}
.padding-row {display:none;}
</style>
<div id="container" class="container page-pricing">
  <div class="row" align="center">
     <h1> Thank You for Subscribing.</h1>    
  </div>  
</div>

<?php echo $this->Html->css('pricing');
	if($this->Session->read("Auth.User"))
	{
?>
		<script>
		window.setTimeout(function() {
		    window.location.href = '<?php echo Configure::read("SITE_URL");?>billing'; 
		}, 10000);
		</script>
<?php
	}
	else
	{
?>
		<script>
		window.setTimeout(function() {
		    window.location.href = '<?php echo Configure::read("SITE_URL");?>login'; 
		}, 10000);
		</script>
<?php
	}
?>