 jQuery(document).ready(function(){
                
                        
               jQuery("#log_out").click(function(){ 
                   var confirm_log_out = confirm("Are you sure you want to log out ?");
                   
                                
                   
                   if(confirm_log_out==true)
                   {
                       jQuery.removeCookie("LOGINUSERNAME");
                       window.location = "index.php";
                   }
               
           });
               
            });