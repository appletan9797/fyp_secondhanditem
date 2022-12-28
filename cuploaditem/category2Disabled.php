<select id="Category" name="catList" disabled>
<option name="NotSelected" value="" hidden> </option>
<?php
include 'aConnect.php' ;

$sql= "SELECT * FROM categoryoptions WHERE CategoryID=4";
$request= $connection->query($sql);

if ($request-> num_rows>0){
	while ($row= $request->fetch_assoc()){
		echo "<option value='". $row['Options'] ."'>" .$row['OptionsDisplay'] ."</option>" ;
		/*echo "<option <?php if(isset($ItemWanted) && $ItemWanted== '".$row['Options']."') echo $ItemWanted;?>".$row['Options'] ."</option>" ;
		*/
	}
}

?>
</select>