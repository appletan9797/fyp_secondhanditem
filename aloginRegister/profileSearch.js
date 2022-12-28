function openPage(userID){
	alert (userID);
	$.ajax({
            url: "SavePost.php",
            type: "POST",
            data:"user"=+userID,                
            success: function(data)
                        {
                             $("#right").html(data);                               
                        }
        });

}