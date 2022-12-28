<select id="Location" name="MeetingPoint">
<option name="NotSelected" hidden> </option>
<?php
include 'connection.php' ;

$sql= "SELECT * FROM categoryoptions WHERE CategoryID=2";
$request= $connection->query($sql);

if ($request-> num_rows>0){
	while ($row= $request->fetch_assoc()){
		echo "<option value='". $row['Options'] ."'>" .$row['OptionsDisplay'] ."</option>" ;
		/*
		echo "<option <?php if(isset($MP) && $MP== '".$row['Options']."') echo $MP;?>" .$row['Options'] ."</option>" ;
		*/
	}
}

?>
</select>