<div class="row" >
        <div class="sidebar" style="margin-bottom:10px"> 
            <div class="mini-submenu" style="font-weight:bold;text-align:center;cursor:pointer;display:none;border:1px solid rgba(0, 0, 0, 0.9);border-radius:4px;padding:9px;width:auto">
                District Area
            </div>
            <div class="list-group">
                <span href="#" class="list-group-item active" style="width:auto">
                    District Area
                    <span class="pull-right" id="slide-submenu" style="background:rgba(0, 0, 0, 0.45);display:inline-block;padding:0 8px;border-radius:4px;cursor:pointer">
                        <i class="fa fa-times"></i>
                    </span>
                </span>
				
				<ul style="list-style: none">
				<?php
						include 'Connection.php' ;

						$sql= "SELECT * FROM categoryoptions WHERE CategoryID=2";
						$request= $connection->query($sql);
						if ($request-> num_rows>0){
							while ($row= $request->fetch_assoc()){
							$number = $request->num_rows;
							echo "<li value='". $row['Options'] ."'><a  class='list-group-item' href='http://localhost/finalFYP/esearch/place.php?id=".$row['Options']."&page=1'>" .$row['OptionsDisplay'] ."<span class='badge'>".$number."</span></a></li>" ;
		
							}
						}
						?>
				</ul>
               <!-- <a href="#" class="list-group-item" href="#">Johor Bahru</a>
                <a href="#" class="list-group-item" href="#">Kulai Jaya</a>
                <a href="#" class="list-group-item" href="#">Kota Tinggi</a>
                <a href="#" class="list-group-item" href="#">Kluang</a>
                <a href="#" class="list-group-item" href="#">Mersing<span class="badge">14</span></a>
                <a href="#" class="list-group-item" href="#">Pontian</a>
                <a href="#" class="list-group-item" href="#">Batu Pahat</a>
                <a href="#" class="list-group-item" href="#">Segamat</a>
                <a href="#" class="list-group-item" href="#">Muar</a>
                <a href="#" class="list-group-item" href="#">Ledang</a> -->
            </div>        
        </div>

        <div class="col-md-9">
            
        </div>
    </div>