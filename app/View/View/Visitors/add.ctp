<!DOCTYPE html>
  <head>
    <div id="paymentform_3"></div>
    <?php echo $this->Html->script('jquery.min');?>
    <script type="text/javascript">
    $( document ).ready(function() {  
      var id = $("div").attr("id");
       id = id.split("_").pop();
      $("#puzzleid").val(id);
    

      $("#Imagedata").submit(function(e)
      {
        var url = "process"; // the script where you handle the form input.
       // Form Submit Ajax  
        $.ajax({
                 type: "POST",
                 url: url,
                 dataType: 'json', 
                 data: $("#Imagedata").serialize(), // serializes the form's elements.
                 success: function(data)
                 {
                    if(data)
                    {
                      $.ajax
                        ({
                           type: "POST",
                           url: "fetchimage/"+data.Id,
                           data:'' ,
                           success:function(data)
                           {
                              $("#ccontent").html(data);
                           }
                      });
                    }
                 }
               });

          e.preventDefault(); // avoid to execute the actual submit of the form.
      });
      }); 
    </script>
  </head>
<body>
<div >
  <div class="getdata"> 
    <!--  Insert User Detail -->
    <form id="Imagedata">
      <h3>Please Insert Form Detail</h3>
      <input type ="text" name="firstname" placeholder="First Name" required/> <br>
      <input type ="text" name="lastname" placeholder="Last Name" required/><br>
      <input type ="text" name="email" placeholder="Email" required/><br>
      <input type ="hidden" name="data[Visitior][puzzle_id]" value="" id="puzzleid"/><br>
      <input type = "submit" value ="Submit">
    </form>
    <div id="ccontent"></div>
    
</div>
</div>
</body>
</html>  