window.onload = function(){

// $("#clear").on("click", function() {
// $("#thumbnil").src="http://localhost/fyp/editPost/normal.jpg";

// });




/* $("#clear").on("click", function() {
  $("#picture2").val("");
});
$("#clear2").on("click", function() {
  $("#picture3").val("");
}); */

$("#itemName").focusout(function(){
	 $("#try1").hide();
	  var empty = $("#itemName").val();
	  var length = $("#itemName").val().length;
		if (empty == ""){
			$("#itemNameError").text( "Please enter item's name" );
		}
		else{
			$("#itemNameError").text( "" );
			
		}
  });

 $("#ItemDescription").focusout(function(){
	 $("#try2").hide();
	  var emptyDesc = $("#ItemDescription").val();
	  var length = $("#ItemDescription").val().length;
		if (emptyDesc == ""){
			$("#itemDescriptionError").text( "Please enter the description" );
		}
		else{
			$("#itemDescriptionError").text( "" );
		}
  }); 
  
$("#CAtegoryList").focusout(function(){
	$("#try3").hide();
	  var emptyCatList = $("#CAtegoryList").val();
	  var length = $("#CAtegoryList").val().length;
		if (emptyCatList == ""){
			$("#itemCategoryError").text( "Please select a category" );
		}
		else{
			$("#itemCategoryError").text( "" );
		}
  }); 
  
$("#Location").focusout(function(){
	 $("#try4").hide();
	  var emptyLocation = $("#Location").val();
	  var length = $("#Location").val().length;
		if (emptyLocation == ""){
			$("#locationError").text( "Please select location" );
		}
		else{
			$("#locationError").text( "" );
		}
  });  

$("input[name='rdnCondition']").change(function(){ 
$("#try5").hide(); 
}); 
  
$("#Price1").focusout(function(){
	$("#try6").hide();
	  var emptyPrice = $("#Price1").val();
	  var length = $("#Price1").val().length;
	 
		if (emptyPrice == ""){	
			$("#itemPriceError").text( "Please enter the price" );
		}
		else{
			if ($.isNumeric(emptyPrice)){
				if (emptyPrice<0){
					$("#itemPriceError").text( "Please enter positive number" );
				}
				else{
					$("#itemPriceError").text( "" );
				}
			}
			else{
			$("#itemPriceError").text( "Please enter number only" );
			}
		}
  }); 
  

$("input[name='rdnPriceChange']").change(function(){ 
$("#try7").hide(); 
});

  
$("#Category").focusout(function(){
	$("#try8").hide();
	  var emptyWantedCat = $("#Category").val();
	  var lengthWantedCat = $("#Category").val().length;
		if (emptyWantedCat == ""){
			$("#itemWantedCatError").text( "Please select a category" );
		}
		else{
			$("#itemWantedCatError").text( "" );
		}
  }); 
   
$("#Detail").focusout(function(){
	$("#try9").hide();
	  var emptyDetail = $("#Detail").val();
	  var length = $("#Detail").val().length;
		if (emptyDetail == ""){
			$("#itemWantedDetailError").text( " Please enter the wanted item's detail" );
		}
		else{
			$("#itemWantedDetailError").text( "" );
		}
  }); 
 
$("#reason").focusout(function(){
	$("#try10").hide();
	  var emptyReason = $("#reason").val();
	  var length = $("#reason").val().length;
		if (emptyReason == ""){
			$("#reasonError").text( "Please enter the reason" );
		}
		else{
			$("#reasonError").text( "" );
		}
  }); 
  
  
//This is to enable the fields if user enter wrong data and the page is reload 
  
	//Barter
	if (document.getElementById("rdnExchange").checked == true){
		document.getElementById("Category").disabled = false; 
		document.getElementById("reason").disabled = false; 
		document.getElementById("Detail").disabled = false; 
		document.getElementById("fill3").innerHTML = "*";
		document.getElementById("fill4").innerHTML = "*";
		document.getElementById("fill5").innerHTML = "*";
		document.getElementById("text2").style.color= "black";
		
	}
	else{
		
		document.getElementById("Category").disabled = true; 
		document.getElementById("reason").disabled = true; 
		document.getElementById("Detail").disabled = true; 
		
		document.getElementById("fill3").innerHTML = "";
		document.getElementById("fill4").innerHTML = "";
		document.getElementById("fill5").innerHTML = "";
		
		document.getElementById("text2").style.color= "gray";
		document.getElementById("reason").value = "";
		document.getElementById("reason").placeholder = "eg:A gift from friend, want to exchange with something i like";
		document.getElementById("Detail").value = "";
		document.getElementById("Detail").placeholder = "eg:Doraemon/ Honda Civic";
		document.getElementById("Category").value = "NotSelected";
		
		document.getElementById("itemWantedDetailError").innerHTML = "";
		document.getElementById("reasonError").innerHTML = "";
	}
	
	//Selling
  if (document.getElementById("rdnSelling").checked == true){
		document.getElementById("fill").innerHTML = "*";
		document.getElementById("fill2").innerHTML = "*";
		document.getElementById("rdnNegotiate").disabled = false;
		document.getElementById("rdnFixed").disabled = false;
		document.getElementById("Price1").disabled = false; 
		document.getElementById("text1").style.color= "black";	
	}
	else{
		document.getElementById("fill").innerHTML = "";
		document.getElementById("fill2").innerHTML = "";
		document.getElementById("itemPriceError").innerHTML = "";
		document.getElementById("rdnNegotiate").disabled = true;
		document.getElementById("rdnFixed").disabled = true;
		document.getElementById("Price1").disabled = true;
		document.getElementById("rdnNegotiate").checked = false;
		document.getElementById("rdnFixed").checked = false;
		document.getElementById("text1").style.color= "gray";
		document.getElementById("try6").innerHTML="";
		
	}
}