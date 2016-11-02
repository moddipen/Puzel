
<?php echo $this->Session->flash();?>
<div id="container" class="container page-pricing">
  <div class="row">
      <!--Begin Plan Basic!-->
     
            <h1> Thank you.</h1>    
    </div>
  
</div>

<?php echo $this->Html->css('pricing');?>
<script>
window.setTimeout(function() {
    window.location.href = '<?php echo Configure::read("SITE_USER_URL");?>/users/login';
}, 10000);
</script>