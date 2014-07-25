<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_POST['action']) && !empty($_POST['action']) ) {
		$action = trim($_POST['action']);
		if (isset($_POST['arg']) && !empty($_POST['arg'])) {
			$arg = trim($_POST['arg']);
		}
		if (isset($_POST['quantity']) && !empty($_POST['quantity'])) {
			$quantity = trim($_POST['quantity']);
		}
	}else{
		$action = '';
		$arg = '';
	}
	
	switch ($action) {
		case 'growl_message':
			{
			    
			    $gm = $_SESSION['growlmessage'];
				echo '<a id="gm">'.$gm.'</a>';
			}
			break;
		case 'growl_pending':
			{
				$gp = $_SESSION['growlpending'];
				echo '<a id="gp">'.$gp.'</a>';
			}
			break;
		default:
			
			break;
	}
    
?>