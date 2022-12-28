<select id="CAtegoryList" name="CAtegoryList" style="width:160px;" >
<option name="NotSelected" hidden> </option>
<?php
include 'connection.php' ;

$sql= "SELECT * FROM categoryoptions WHERE CategoryID=1";
$request= $connection->query($sql);

if ($request-> num_rows>0){
	while ($row= $request->fetch_assoc()){

		echo "<option value='". $row['Options'] ."'>" .$row['OptionsDisplay'] ."</option>" ;
		/*
		echo "<option value='". $row['Options']."' <?php if(isset($Category) && $Category== '".$row['Options']."') ?>" .$row['Options']. "</option>" ;
	*/
	}
}

?>
</select>
