// this function is for resell part
function TextBox(){
	if (document.getElementById("rdnSelling").checked == true){
		document.getElementById("fill").innerHTML = "*";
		document.getElementById("fill2").innerHTML = "*";
		document.getElementById("rdnNegotiate").disabled = false;
		document.getElementById("rdnFixed").disabled = false;
		document.getElementById("Price1").disabled = false; 
		document.getElementById("text1").style.color= "black";
		document.getElementById("Price1").value = "";
		document.getElementById("Price1").placeholder = "eg: RM 35.00";
		
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
			document.getElementById("Price1").value = "";
			document.getElementById("Price1").placeholder = "eg: RM 35.00";
			
			document.getElementById("try6").innerHTML = "";
			document.getElementById("try7").innerHTML = "";
		
		}
}


//This function is for the exchange part
function TextBox2(){
	if (document.getElementById("rdnExchange").checked == true){
		document.getElementById("Category").disabled = false; 
		document.getElementById("reason").disabled = false; 
		document.getElementById("Detail").disabled = false; 
		
		document.getElementById("fill3").innerHTML = "*";
		document.getElementById("fill4").innerHTML = "*";
		document.getElementById("fill5").innerHTML = "*";
		
		document.getElementById("text2").style.color= "black";
		document.getElementById("reason").value = "";
		document.getElementById("reason").placeholder = "eg:A gift from friend, want to exchange with something i like";
		document.getElementById("Detail").value = "";
		document.getElementById("Detail").placeholder = "eg:Doraemon/ Honda Civic";
		document.getElementById("Category").value = "NotSelected";
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
		
		
		document.getElementById("try8").innerHTML = "";
		document.getElementById("try9").innerHTML = "";
		document.getElementById("try10").innerHTML = "";
		document.getElementById("itemWantedDetailError").innerHTML = "";
		document.getElementById("reasonError").innerHTML = "";
	}
}

function removeImg(no){
	debugger;
	document.getElementById("thumbnil"+no).src="http://localhost/fyp/editPost/normal.jpg";
	document.getElementById("picture"+no).value="";
	event.preventDefault();
}


