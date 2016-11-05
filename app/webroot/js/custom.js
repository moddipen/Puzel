$(document).ready(function()
{
    
	$(document).on('click', "#puzelacount", function(e) 
      {
        $("#signwithpuzzleaccount").val(1);
      });
      
	  $(document).on('click', "#normalsign", function(e) 
      {
        $("#signwithpuzzleaccount").val(0);
      }); 
	
	$('head').append('<link rel="stylesheet" type="text/css" href="http://puzel.stage.n-framescorp.com/app/webroot/css/animations.css">');
	var snipest_id =$('.snipest').attr('id');
	var puzzle_id = snipest_id.replace("puzzle_", "");
	
	$.ajax
	  ({
		 type: "POST",
		 url: "http://puzel.stage.n-framescorp.com/visitors/snipestimage/"+puzzle_id,
		 dataType: 'text', 
		 success:function(data)
		 {
			$('#'+snipest_id).html(data);
		 }
	});
	
	$(document).on('submit', "#Imagedata", function(e) 
	{
         if($("#fname").val() == '')
         {
            $("#firsname").after("<p>Please enter first name. </p>")
            return false;
         } 
         else if($("#lname").val() == '')
         {
            $("#laname").after("<p>Please enter last name. </p>")
            return false;
         }
         else if($("#useremail").val() == '')
         {
            // var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            $("#useemail").after("<p>Please enter an email. </p>")
            return false;

         } 
         else 
         {

            var url = "http://puzel.stage.n-framescorp.com/visitors/process"; 
             // Form Submit Ajax  
              $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#Imagedata").serialize(), // serializes the form's elements.
                       dataType: 'json', 
                       success: function(data)
                       {
						   if(data.message != "That email address has already taken. Please use another email." || data.Message == "OK")
                          {
                            $.ajax
                              ({
                                 type: "POST",
                                 url: "http://puzel.stage.n-framescorp.com/visitors/fetchimage/"+data.image_id,
                                 dataType: 'text', 
                                 success:function(data)
                                 {
                                    var transition = $("#transition").val();
									
									var obj = $.parseJSON(data);
									obj = obj.name;
									objs = obj.split('.');
									var get_name = objs[0].split('_');
									$('.'+objs[0]).css("background-image","url('http://puzel.stage.n-framescorp.com/img/puzzel/"+get_name[0]+"/"+obj+"')");  //background:url('<?php echo $this->webroot;?>'img/puzzel/"+objs[0]+"/"+obj+"')");
									
									if(transition  == "Newspaper"){var classes = 'pt-page-rotateOutNewspaper pt-page-rotateInNewspaper pt-page-delay500';}
									if(transition  == "Cube to left"){var classes = 'pt-page-rotateCubeLeftOut pt-page-ontop pt-page-rotateCubeLeftIn';}
									if(transition  == "Cube to right"){var classes = 'pt-page-rotateCubeRightOut pt-page-ontop pt-page-rotateCubeRightIn';}
									if(transition  == "Cube to top"){var classes = 'pt-page-rotateCubeTopOut pt-page-ontop pt-page-rotateCubeTopIn';}
									if(transition  == "Cube to bottom"){var classes = 'pt-page-rotateCubeBottomOut pt-page-ontop pt-page-rotateCubeBottomIn';}
									if(transition  == "Flip right"){var classes = 'pt-page-flipOutRight pt-page-flipInLeft pt-page-delay500';}
									if(transition  == "Flip left"){var classes = 'pt-page-flipOutLeft pt-page-flipInRight pt-page-delay500';}
									if(transition  == "Flip top"){var classes = 'pt-page-flipOutTop pt-page-flipInBottom pt-page-delay500';}
									if(transition  == "Flip bottom"){var classes = 'pt-page-flipOutBottom pt-page-flipInTop pt-page-delay500';}
									
									$('.'+objs[0]).addClass(classes);
									// $("#puzzle").html(data);
                                    $("#Imagedata")[0].reset();
                                    $("#success").html("<div style='background:rgba(60,118,61,0.5);color:#3C763D;font-size:14px;padding:20px'> Register successfully.</div>");
                                    $("#success").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                 }
                            });
                          }
                          else
                          {
                            $("#alert").html("<p style='background:rgba(169,68,66,0.5);color:#A94442;font-size:14px;padding:20px;margin-bottom:10px;'>"+data.message+"</p>");
                            $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                          }
                          //$("#Imagedata")[0].reset();  
                       }
                     });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            } 
          });
	
}); 