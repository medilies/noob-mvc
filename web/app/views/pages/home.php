<?php ob_start();?>

Here we go again

<?php $content = ob_get_clean();?>
<?php require_once WEB_ROOT . '/App/Views/inc/layout.php';?>
