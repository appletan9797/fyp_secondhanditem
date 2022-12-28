<select name="choice" style="width:200px;">
<option value="NotSelected" hidden> </option>
<?php
include 'connection.php' ;

$sql= "SELECT * FROM category";
$request= $connection->query($sql);

if ($request-> num_rows>0){
	while ($row= $request->fetch_assoc()){
	
		echo "<option value='". $row['SearchCategory'] ."'>" .$row['SearchCategory'] ."</option>" ;
		
	}
}

?>
</select>