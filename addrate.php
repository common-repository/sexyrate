<?php
@require('../../../wp-config.php');


if(isset($_GET['rate']) && $_GET['rate'] != '' && ! isset($_COOKIE['ratted'])  ) {
	
setcookie("ratted", "set", time() + 360000 ,'/');
$rate = $_GET['rate'];

switch($rate)
{
	case 'p':	update_option('perfect', get_option('perfect') + 1 );
			break;
	case 'g':	update_option('good', get_option('good') + 1 );
			break;
	case 'b':	update_option('bad', get_option('bad') + 1 );
			break;
	case 't':	update_option('toobad', get_option('toobad') + 1 );
			break;						
}



}
?>
		
