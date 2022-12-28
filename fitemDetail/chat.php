<?php
    session_start();
    include 'connection.php';
    include '../bmainpage/mainpageBlank.php';
    $chatID = $_GET['chatID'];
?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="chat.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/portfolio-item.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../dist/js/swiper.min.js"></script>
</head>
<body>
    <div class="container text-center">
        <div class="row">
            <div class="Chatbox text-center" class="col-md-8 col-xs-12">
                <div class="chatlogs">
                <?php
                    require_once 'function.php';
						
				    $username = getValue("UserName");
                    $sql = "SELECT * FROM chat WHERE chatID = '$chatID' ORDER BY ID";
	                $request = $connection->query($sql);
			        if ($request -> num_rows > 0){
				        while ($row=$request->fetch_assoc()){
                            $pic = $row['Pic'];
                            $message = $row['Message'] ;
                            $sender = $row['Sender']; 
                            
                        if ($sender == $username){
                            echo "<div class='chat self'>";
                                echo "<div class='User-photo'><img src='http://chopper.twopiz.com/~wilsandb/SecondChance_MaroonTech/images/".$pic."'></div>";
                                echo "<p class='chat-message'>".nl2br($message)."</p>";
                            echo "</div>";
                        } 
                        else {
                            echo "<div class='chat friend'>";
                                echo "<div class='User-photo'><img src='http://chopper.twopiz.com/~wilsandb/SecondChance_MaroonTech/images/".$pic."'></div>";
                                echo "<p class='chat-message'>".nl2br($message)."</p>";
                            echo "</div>";  
                        }
                        }
                    }  
                    else {
                        header("Refresh:0");
                        $sql1 = "INSERT INTO chat(chatID, Message, Sender) VALUES('$chatID', 'I am interested with your product', '$username')";
                        $result = $connection->query($sql1);
                        
                    }
                ?>
                </div>
                <div>
                <form class="chat-form" action="" method="post">
                    <textarea name="awesome" placeholder="Type your message here"></textarea>
                    <input class="yoyo" type="submit" value="Send" />
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $messages = $_POST['awesome'];
                        if (empty($messages)){
                            $error = "Please enter your messages first.";
                        } else {
                            $sql = "INSERT INTO chat(Message, Sender, chatID) VALUES('$messages', '$username', '$chatID')" ;
                            $request = $connection->query($sql);
                            header("Refresh:0");
                        }
                    }
                    ?>
                </form>
            </div>
            <div class="col-md-2"></div>
            <?php include '../bmainpage/footer.php';?>
        </div>
        
    </div>
</body>
</html>