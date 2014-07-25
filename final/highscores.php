<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/load.css">
        <link rel="stylesheet" type="text/css" href="css/highscores.css">
        <script src="../js/jq.js" type="text/javascript"></script>
        
    </head>
    <body>
        <?php
            include 'functions.php';
            $rows = list_highscores();
            $num_rows = pg_num_rows($rows);
            $name= array(0,0,0,0,0,0,0,0,0,0,0);
	        $score= array(0,0,0,0,0,0,0,0,0,0,0);
	        
	        $index = 0;
	        
        	while ($row = pg_fetch_row($rows)) {
        		$name[$index] = $row[0];
        		$score[$index++] = $row[1];
        		
        	}
        ?>
        <div class="Highscores" >
                <table >
                    <tr>
                        <td>
                            Name
                        </td>
                        <td >
                            Score
                        </td>
                        
                    </tr>
                    <tr>
                        <td >
                            <?php echo $name[0];?>
                        </td>
                        <td>
                            <?php echo $score[0];?>
                        </td>
                        
                    </tr>
                    <tr>
                        <td >
                            <?php echo $name[1];?>
                        </td>
                        <td>
                            <?php echo $score[1];?>
                        </td>
                        
                    </tr>
                    <tr>
                        <td >
                            <?php echo $name[2];?>
                        </td>
                        <td>
                            <?php echo $score[2];?>
                        </td>
                        
                    </tr>
                    <tr>
                        <td >
                            <?php echo $name[3];?>
                        </td>
                        <td>
                            <?php echo $score[3];?>
                        </td>
                        
                    </tr>
                </table>
            </div>
            
        <div class="trigger" id="gamestart" onclick="window.location=bar.php;">
            <a id="back" href="bar.php">Back</a>
        </div>
    </body>
    
</html>
