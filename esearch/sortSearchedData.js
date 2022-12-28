function SortData(itemID){
	var pageNo = $("#PageNo").val();
		$.ajax({
			type:"post",
			url:"SortRecent.php?id=itemID&page=#PageNo.val()",
			data:"itemID="+itemID,
			success:function(data){
				$("#SearchedDataAppear").html(data);
			}
		});
	}
	
function SortByConditionUsed(itemID){
	var pageNo = $("#PageNo").val();
		$.ajax({
			type:"post",
			url:"SortCondition.php?id=itemID&page=#PageNo.val()",
			data:"itemID="+itemID,
			success:function(data){
				$("#SearchedDataAppear").html(data);
			}
		});
	}

function SortByConditionNew(itemID){
	var pageNo = $("#PageNo").val();
		$.ajax({
			type:"post",
			url:"SortConditionNew.php?id=itemID&page=#PageNo.val()",
			data:"itemID="+itemID,
			success:function(data){
				$("#SearchedDataAppear").html(data);
			}
		});
	}
