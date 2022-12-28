 function removeImg(user){
	document.getElementById("thumbnil3").src="picture.png";
	document.getElementById("picture").value="";
	event.preventDefault();
	
	$.ajax({
            url: "deleteImage.php",
            type: "POST",
            data: { 'userID':user},                   
            success: function()
                        {
                             alert(data);                                
                        }
        });
	
 }
 
 window.onload = function(){
	$("#fname").focusout(function(){
	  var data = $("#fname").val();
	  $("#error1").hide();
		if (data == ""){
			$("#fnameError").text( "*FirstName is required" );
		}
		else{
			$("#fnameError").text( "" );
		}
  });
  
  $("#lname").focusout(function(){
	  var data = $("#lname").val();
	  $("#error2").hide();
		if (data == ""){
			$("#lnameError").text( "*LastName is required" );
		}
		else{
			$("#lnameError").text( "" );
		}
  });
  
  $("#email").focusout(function(){
	  var data = $("#email").val();
	  var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
	  
	  $("#error3").hide();
		if (data == ""){
			$("#emailError").text( "*Email is required" );
		}
		else if (!re.test(data)){
			$("#emailError").text( "*Incorrect email format" );
		}
		else{
			$("#emailError").text( "" );
		}
  });
  
 $("#dob").focusout(function(){
	  var data = $("#dob").val();
	  var d= new Date();
	  var second = d.getTime();
	  var da= new Date(data);
	  var selection = da.getTime();
	  var difference = second - selection;
	  var age = difference/31536000;
	  
	  $("#error4").hide();
		if (data == ""){
			$("#dobError").text( "*Birthday is required" );
		}
		else if(difference <0 ){
			$("#dobError").text( "*Birthday should not be later than today" );
		}
		else if(age < 10 ){
			$("#dobError").text( "*We do not encourage children who not over 10 access internet");
		}
		else{
			$("#dobError").text( "" );
		}
  });
 }