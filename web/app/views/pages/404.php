<?php ob_start();?>

<h1>    Not found   </h1>

<?php $content = ob_get_clean();?>
<?php require_once WEB_ROOT . '/App/Views/inc/layout.php';?>