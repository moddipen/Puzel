$(document).ready(function()
{
    
  $(document).on('click', "#puzelacount", function(e) 
      {
        $("#signwithpuzzleaccount").val(1);
      });
      
    $(document).on('click', "#normalsign", function(e) 
      {
        $("#enrollwithpuzzleaccount").val(2);
      }); 
  
  $('head').append('<link rel="stylesheet" type="text/css" href="http://puzel.stage.n-framescorp.com/app/webroot/css/animations.css">');
  var snipest_id =$('.snippet').attr('id');
  // var puzzle_id = snipest_id.replace("puzzle_", "");
  var puzzle_id = snipest_id;
  
  $.ajax
    ({
     type: "POST",
     url: "http://puzel.stage.n-framescorp.com/snipestimage/"+puzzle_id,
     dataType: 'text', 
     success:function(data)
     {
      $('#'+snipest_id).html(data);
     }
  });
  
  var businesname = $("#businesname").val();
  var randomid = $("#randomid").val();
  var puzzlename = $("#puzzlename").val();      

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

            var url = "http://puzel.stage.n-framescorp.com/process/"+puzzle_id; 
             // Form Submit Ajax  
              $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#Imagedata").serialize(), // serializes the form's elements.
                       dataType: 'json', 
                       success: function(data)
                       {
                        if(data.message != "You have already enrolled" || data.Message == "OK")
                          {
                            $.ajax
                              ({
                                 type: "POST",
                                 url: "http://puzel.stage.n-framescorp.com/fetchimage/"+data.ImageId,
                                 dataType: 'text', 
                                 success:function(data)
                                 {
                                    
                                    var transition = $("#transition").val();
                                    var businesname = $("#businesname").val();
                                    var randomid = $("#randomid").val();
                                    var puzzlename = $("#puzzlename").val();  


                                     function alert()
                                       {
                                          javascript:successAlert("You have been enrolled. </br></br>Share with your friends</br><div class='social-icons'><a href='http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"&title="+puzzlename+"' onclick='return !window.open(this.href,\"Facebook\",\"width=640,height=580\")' class='fb'><i class='fa fa-facebook'></i></a><a href='https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"'  class='twitter'><i class='fa fa-twitter'></i></a><a href='http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle "+puzzlename+"&body=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"' onclick='return !window.open(this.href,Outlook,width=640,height=580)' target='_blank' class='window'><i class='fa fa-windows'></i></a><a href ='https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle "+puzzlename+"&body=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"' onclick='return !window.open(this.href,Google,width=640,height=580)' class='email'><i class='fa fa-envelope-o'></i></a></div>");
                                       } 


                                     var audioElement = document.createElement('audio');
                                      audioElement.setAttribute('src', 'http://puzel.stage.n-framescorp.com/tone/notification.mp3');
                                       audioElement.play();         

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
                                    // $("#alert").html("<p>You have been enrolled.</p>");
                                    // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                     
                                      setTimeout( alert, 3000);
                                      var newaddcount = parseInt($("#showimagecontent").val()) - 1 ;
                                      var newminuscount = parseInt($("#hideimagecontent").val()) + 1;
                                      if(newaddcount != 0)
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far, "+newaddcount+" more to go before we give away the rewards, enroll yourself now!");     
                                      }
                                      else
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far,");   
                                      }  
                                      
                                      $("#showimagecontent").val(newaddcount);
                                      $("#hideimagecontent").val(newminuscount); 
                                 }
                            }); 
                          }
                          else
                          {
                            // $("#alert").html("<p>"+data.message+"</p>");
                            // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                            javascript:errorAlert(data.message);
                           // $(".ja_wrap_black").show().delay(5000).fadeOut(function(){ $(this).remove(); });
                          }
                          //$("#Imagedata")[0].reset();  
                       }
                     });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            } 
          });
      

     








           // Check email is valid or not 
      function validateEmail($email)
      {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
      }

      
      
      $(document).on('submit', "#Imageenroll", function(e) 
      {
      
        if($("#password").val() == '')
         {
            return false;
         } 
         else if( !validateEmail($("#userenrollemail").val()) || $("#userenrollemail").val() == '') 
         {
            return false;
         } 
         else 
         {
            var url = "http://puzel.stage.n-framescorp.com/process/"+puzzle_id; 
             // Form Submit Ajax  
              $.ajax({
                       type: "POST",
                       url: url,
                       data: $("#Imageenroll").serialize(), // serializes the form's elements.
                       dataType: 'json', 
                       success: function(data)
                       {

                        
                        if(data.message == "success" )
                          {
                            $.ajax
                              ({
                                 type: "POST",
                                 url: "http://puzel.stage.n-framescorp.com/fetchimage/"+data.ImageId,
                                 dataType: 'text', 
                                 success:function(data)
                                 {
                                    var obj = $.parseJSON(data);
                                    
                                    var businesname = $("#businesname").val();
                                    var randomid = $("#randomid").val();
                                    var puzzlename = $("#puzzlename").val();  
  
                                    function enrollalert()
                                       {
                                           javascript:successAlert("You have been enrolled. </br></br>Share with your friends</br><div class='social-icons'><a href='http://www.facebook.com/share.php?u=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"&title="+puzzlename+"' onclick='return !window.open(this.href,\"Facebook\",\"width=640,height=580\")' class='fb'><i class='fa fa-facebook'></i></a><a href='https://twitter.com/intent/tweet?text=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"'  class='twitter'><i class='fa fa-twitter'></i></a><a href='http://mail.live.com/default.aspx?rru=compose&to=&subject=Share new puzzle "+puzzlename+"&body=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"' onclick='return !window.open(this.href,Outlook,width=640,height=580)' target='_blank' class='window'><i class='fa fa-windows'></i></a><a href ='https://mail.google.com/mail/?view=cm&fs=1&to=&su=Share new puzzle "+puzzlename+"&body=http://puzel.stage.n-framescorp.com/"+businesname+"/"+randomid+"' onclick='return !window.open(this.href,Google,width=640,height=580)' class='email'><i class='fa fa-envelope-o'></i></a></div>");
                                       } 

                                       var audioElement = document.createElement('audio');
                                      audioElement.setAttribute('src', 'http://puzel.stage.n-framescorp.com/tone/notification.mp3');
                                       audioElement.play();    

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
                                    $("#Imageenroll")[0].reset();
                                    // $("#success").html("<div style='background:rgba(60,118,61,0.5);color:#3C763D;font-size:14px;padding:20px'> Register successfully.</div>");
                                    // $("#success").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                                    // $("#alert").html("<p>Puzzle created successfully.</p>");
                                    // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });



                                    setTimeout( enrollalert, 3000);

                                      var newaddcount = parseInt($("#showimagecontent").val()) - 1 ;
                                      var newminuscount = parseInt($("#hideimagecontent").val()) + 1;
                                      if(newaddcount != 0)
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far, "+newaddcount+" more to go before we give away the rewards, enroll yourself now!");     
                                      }
                                      else
                                      {
                                        $("#messagecontent").html(newminuscount+" have signed up so far,");   
                                      }  
                                      
                                      $("#showimagecontent").val(newaddcount);
                                      $("#hideimagecontent").val(newminuscount);
                                   }
                              });
                          }
                          else
                          {
                            // $("#alert").html("<p>"+data.message+"</p>");
                            // $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
                            javascript:errorAlert(data.message);
                           // $(".ja_wrap_black").show().delay(5000).fadeOut(function(){ $(this).remove(); });
                          }
                       }
                     });

                e.preventDefault(); // avoid to execute the actual submit of the form.
            } 
          });  













      
      // $("#Imagedata").submit(function(e)
      // {
      //    if($("#fname").val() == '')
      //    {
      //       return false;
      //    } 
      //    else if($("#lname").val() == '')
      //    {
      //       return false;
      //    }
      //    else if( !validateEmail($("#useremail").val()) || $("#useremail").val() == '') 
      //    {
      //       return false;
      //    } 
      //    else 
      //    {

      //       var url = "http://localhost/puzzel/visitors/process/"+puzzle_id; 
      //        // Form Submit Ajax  
      //         $.ajax({
      //                  type: "POST",
      //                  url: url,
      //                  data: $("#Imagedata").serialize(), // serializes the form's elements.
      //                  dataType: 'json', 
      //                  success: function(data)
      //                  {
      //                    if(data.message != "You have already enrolled")
      //                     {
      //                       $.ajax
      //                         ({
      //                            type: "POST",
      //                            url: "http://localhost/puzzel/visitors/fetchimage/"+data.ImageId,
      //                            dataType: 'text', 
      //                            success:function(data)
      //                            {
      //                               var obj = $.parseJSON(data);
      //                               obj = obj.name;
      //                               objs = obj.split('.');
      //                               var get_name = objs[0].split('_');
      //                               $('.'+objs[0]).css("background-image","url('<?php echo $this->webroot;?>img/puzzel/"+get_name[0]+"/"+obj+"')");  //background:url('<?php echo $this->webroot;?>'img/puzzel/"+objs[0]+"/"+obj+"')");
                                    
      //                               if(transition  == "Newspaper"){var classes = 'pt-page-rotateOutNewspaper pt-page-rotateInNewspaper pt-page-delay500';}
      //                               if(transition  == "Cube to left"){var classes = 'pt-page-rotateCubeLeftOut pt-page-ontop pt-page-rotateCubeLeftIn';}
      //                               if(transition  == "Cube to right"){var classes = 'pt-page-rotateCubeRightOut pt-page-ontop pt-page-rotateCubeRightIn';}
      //                               if(transition  == "Cube to top"){var classes = 'pt-page-rotateCubeTopOut pt-page-ontop pt-page-rotateCubeTopIn';}
      //                               if(transition  == "Cube to bottom"){var classes = 'pt-page-rotateCubeBottomOut pt-page-ontop pt-page-rotateCubeBottomIn';}
      //                               if(transition  == "Flip right"){var classes = 'pt-page-flipOutRight pt-page-flipInLeft pt-page-delay500';}
      //                               if(transition  == "Flip left"){var classes = 'pt-page-flipOutLeft pt-page-flipInRight pt-page-delay500';}
      //                               if(transition  == "Flip top"){var classes = 'pt-page-flipOutTop pt-page-flipInBottom pt-page-delay500';}
      //                               if(transition  == "Flip bottom"){var classes = 'pt-page-flipOutBottom pt-page-flipInTop pt-page-delay500';}
                                    
      //                               $('.'+objs[0]).addClass(classes);
      //                               $("#Imagedata")[0].reset();
      //                               // $("#success").html("<div style='background:rgba(60,118,61,0.5);color:#3C763D;font-size:14px;padding:20px'> Register successfully.</div>");
      //                               // $("#success").show().delay(3000).fadeOut(function(){ $(this).remove(); });
      //                               $("#alert").html("<p>You have been enrolled.</p>");
      //                               $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
      //                             }
      //                       });
      //                     }
      //                     else
      //                     {
      //                       $("#alert").html("<p>"+data.message+"</p>");
      //                       $("p").show().delay(3000).fadeOut(function(){ $(this).remove(); });
      //                     }
      //                     //$("#Imagedata")[0].reset();  
      //                  }
      //                });

      //           e.preventDefault(); // avoid to execute the actual submit of the form.
      //       } 
      //     });  















    $('#collapse-menu').on('click', function(){
    if($(this).hasClass('active'))
    {
       $(this).removeClass('active');
    }
    else
    {
       $(this).addClass('active');
    }
    });

    // hide submit form when click on enroll button

    $(document).on('click', "#enrollformshow", function() 
    {
      
        $("#puzelasubmit").removeClass('active')
        $("#Imagedata").css('display','none');
        $("#Imageenroll").css('display','block');
        $(this).addClass('active');
    });
    
    // hide enroll form when click on submit button    
    $(document).on('click', "#puzelasubmit", function() 
    {
        $('#enrollformshow').removeClass('active')
        $("#Imageenroll").css('display','none');
        $("#Imagedata").css('display','block');
        $(this).addClass('active');
    });




    
  
}); 



