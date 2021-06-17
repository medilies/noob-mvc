<!DOCTYPE html>
<html lang="<?=DEFAULT_LANG?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="/css/style.css">

    <?php if (!empty($data['stylesheets_array'])): ?>
        <?php foreach ($data['stylesheets_array'] as $stylesheet_name): ?>
            <link rel="stylesheet" href="/css/<?=$stylesheet_name?>.css">
        <?php endforeach;?>
    <?php endif;?>

    <?php if (!empty($data['title'])): ?>
        <title> <?=APP_NAME . ' | ' . $data['title']?>  </title>
    <?php else: ?>
        <title> <?=APP_NAME?>  </title>
    <?php endif;?>

</head>
<body>

<div id="body">

    <header>

        <nav>
            <div class="max-width-container">

            </div>
        </nav>

    </header>

    <main>
        <?=$content?>
    </main>

</div>

<footer>
    <div class="max-width-container">
        Copyright <i class="fal fa-copyright" ></i> 2021
    </div>
</footer>

</body>

<!-- SCRIPTS -->
<?php if (!empty($data['scripts_array'])): ?>
    <?php foreach ($data['scripts_array'] as $script_name): ?>
        <script src="/js/<?=$script_name?>.js"></script>
    <?php endforeach;?>
<?php endif;?>

</html>