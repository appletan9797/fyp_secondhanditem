<select name="option" style="width:100px;" >
<option value="NotSelected" hidden> </option>

<?php
include 'aConnect.php' ;

$sql= "SELECT * FROM categoryoptions WHERE CategoryID=1";
$request= $connection->query($sql);

if ($request-> num_rows>0){
	while ($row= $request->fetch_assoc()){
	
		echo "<option value='". $row['Options'] ."'>" .$row['Options'] ."</option>" ;
		
	}
}

?>
</select>