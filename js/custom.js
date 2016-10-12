$(document).ready(function()
{
    $.ajax(
    {
       type: "get",
       url: "fetchdata.php",
       success: function(data)
       {
          $("#content").html(data);
               
       }
    });
}); 