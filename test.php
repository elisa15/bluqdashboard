<?php
/* decide what the content should be up here .... */
$content = 'hello'; //generic function;

/* AJAX check  */
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	/* special ajax here */
	echo 'failed';
}
echo $_SERVER['HTTP_X_REQUESTED_WITH'];/* not ajax, do more.... */
?>