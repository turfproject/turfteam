$(document).ready(function() {
  $("#buyButton").click(function() {  
    $('.popupWrapper').addClass("active");      
  });
    $("#closeButton").click(function() {  
    $('.popupWrapper').removeClass("active");      
  });

  $("#submit_btn").click(function() {
       
        var proceed = true;
        //simple validation at client's end
        //loop through each field and we simply change border color to red for invalid fields      
        $("#customerDetails form input[required=true], #customerDetails form textarea[required=true]").each(function(){
            $(this).css('');
            if(!$.trim($(this).val())){ //if this field is empty
                $(this).css({"border": "1px solid #af2a2a"}); //change border color to red  
                proceed = false; //set do not proceed flag
            }
            //check invalid email
            var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
                $(this).css({"border": "1px solid #af2a2a"}); //change border color to red  
                proceed = false; //set do not proceed flag             
            }  
        });
       
        if(proceed) //everything looks good! proceed...
        {
            //get input field values data to be sent to server
            post_data = {
                'first_name'     : $('input[name=first_name]').val(),
				'last_name'     : $('input[name=last_name]').val(),
                'email'         : $('input[name=email]').val(),
				'address_one'   : $('input[name=address1]').val(),
				'address_two'   : $('input[name=address2]').val(),
				'city'          : $('input[name=city]').val(),
                'post_code'     : $('input[name=zip]').val(),
                'phone_number'  : $('input[name=night_phone_b]').val(),
				'item_name'     : $('input[name=item_name]').val()
            };
           
            //Ajax post data to server
            $.post('scripts/sendmail.php', post_data, function(response){  
                if(response.type == 'error'){ //load json data from server and output message    
                    output = '<div class="error">'+response.text+'</div>';
                }else{
					document.customerDetails.action = "https://www.paypal.com/cgi-bin/webscr";
       				document.customerDetails.submit();          
       				return true;
                }
                $("#message-results").show().html(output);

            }, 'json');
        }
    	});
   
    //reset previously set border colors and hide all message on .keyup()
    $("#customerDetails  form input[required=true], #customerDetails form textarea[required=true]").keyup(function() {
        $(this).css('');
        			    // Clear the form.
					 $("#customerDetails form input[required=true], #customerDetails form textarea[required=true]").each(function(){
           				 $(this).val('');
					 });
    });  
});