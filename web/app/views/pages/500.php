<?php ob_start();?>

<h1>    Server Error    </h1>

<?php $content = ob_get_clean();?>
<?php require_once WEB_ROOT . '/App/Views/inc/layout.php';?>