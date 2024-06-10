
<?php
$cutter->set('layout', '/dash');
$cutter->data('page_title', 'hello member');
?>

<?php $cutter('content', function() { ?>
	welcome
<?php }) ?>
