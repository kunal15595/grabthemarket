<!DOCTYPE HTML>
<html style="background-color: #111111; background-image: url(../images/pattern_40.gif);">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="itinerary, list" />
        <meta name="description" content="This page provides a list of all itineraries" />
        <link rel="stylesheet" type="text/css" href="css/round.css">
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="../js/jq.js"></script>
        <script type="text/javascript" src="../js/block.js"></script>

    </head>
    <body id="main_body">
        
        <?php 
            include 'marquee.php';
            if (isset($_GET['inc']) && !empty($_GET['inc'])) {
                $inc = $_GET['inc'];
                $incphp = $inc.'.php';
            }else{
                $inc = 'companies';
                $incphp = $inc.'.php?tenure=compare';
            }
            $incjs = 'js/'.$inc.'.js';
            
            
        ?>

    
        <div id="hold">

            <div class="container">
                <div class="content">
                <div class="circle"></div>
                <div class="circle1"></div>
                </div>
            </div>
            <div id="left">
                <div id="top">
                    <iframe src="../clock/clock.php" style="visibility:hidden;" onload="this.style.visibility = 'visible';"  marginwidth="0" marginheight="0" frameborder="no"></iframe>
                </div>
                <div id="middle"><?php include 'vertical.php'; ?></div>
                <div id="bottom">
                    <iframe id="cpframe" src="evaluate.php" style="visibility:hidden;" onload="this.style.visibility = 'visible';"  ></iframe>
                </div>
                
            </div>
            <script type="text/javascript" src="js/common.js"></script>
            <script type="text/javascript" src="js/vertical.js"></script>
            
            
            <!-- // <script type="text/javascript" src="../js/jq.js"></script> -->
            
            <!-- // <script type="text/javascript" src="js/evaluate.js"></script> -->
            <script type="text/javascript">
                var stat = JSON.parse(sessionStorage.stat);
                var broker = JSON.parse(sessionStorage.broker);
                var bonus_submitted = JSON.parse(sessionStorage.bonus_submitted);
                
                if(stat.status == 'visit'){
                    jQuery('.hide_stat').hide();
                }else if(!bonus_submitted.submitted){
                    jQuery('.hide_bon').hide();
                }
                if(stat.status != 'visit' || broker.opted == 'true'){
                    jQuery('.hide_broke').hide();
                }
                var page = "<?php echo $inc;?>";
                add_page(page);
            </script>
            <div  width="100%" height="100%" id="main">
                <iframe scrolling="no" style="visibility:hidden;" onload="this.style.visibility = 'visible';" width="100%" height="100%" frameborder="0" id="mainframe" src="<?php echo $incphp; ?>"></iframe>
                
            </div>  
        </div>     
        
        
    </body>

</html>
