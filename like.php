<?php

require_once '../../../wp-config.php';

$id = $_POST['id'];


if($id != '') {
	$likeNew = get_post_meta($id, '_liked', true) + 1;
	update_post_meta($id, '_liked', $likeNew);
	setcookie('liked-'.$id, time(), time()+3600*24*365, '/');
	
 	echo '...Voto registrado';
}
?>