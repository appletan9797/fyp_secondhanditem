window.onload = function(){
	$("#oldpw").focusout(function(){
	  var passwords1 = $("#oldpw").val();
	  var orip = $("#oriPW").val();
	  $("#oldPW1").hide();
		if (passwords1 == ""){
			$("#error1").text( "*Enter your old password, please?" );
		}
		else if (orip !== passwords1){
			$("#error1").text( "*Old password not match" );
		}
		else{
			$("#error1").text( "" );
		}
  });
  
  $("#newpw").focusout(function(){
	  var passwords1 = $("#newpw").val();
	  var pwlength = $("#newpw").val().length;
		
	  $("#newPW1").hide();
		if (passwords1 == ""){
			$("#error2").text( "*Enter your new password, please?" );
		}
		else if(pwlength <8){
			$("#error2").text( "*At least 8 characters!" );
		}
		else if(!passwords1.match(/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z]).{8,}$/)){
			$("#error2").text( "*Password should contain number, uppercase character, lowercase character and symbol" );
		}
		else{
			$("#error2").text( "" );
		}
  });
  
   $("#confirm").focusout(function(){
	  var passwords1 = $("#confirm").val();
	  var newPWa = $("#newpw").val();
	  $("#rePW1").hide();
		if (passwords1 == ""){
			$("#error3").text( "*Confirm your new password, please?" );
		}
		else if ((newPWa !== "" ) && (passwords1 !== newPWa)){
			$("#error3").text( "*Confirm password not match" );
		}
		else{
			$("#error3").text( "" );
		}
  });
  
}


 