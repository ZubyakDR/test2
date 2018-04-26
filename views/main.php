<? /**
 * @var $title
 * @var $styles
 * @var $content
 * @var $scripts
 **/

use resources\Config;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <base href="<?= Config::BASE_URL ?>"/>
    <meta name="viewport" content="initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no, width = device-width">
    <? foreach ($styles as $style): ?>
        <link rel="stylesheet" type="text/css" media="screen" href="<?= Config::CSS . $style ?>.css"/>
    <? endforeach; ?>
</head>
<body>
<?= $content ?>
<? foreach ($scripts as $script): ?>
    <script src="<?= Config::JS . $script ?>.js"></script>
<? endforeach; ?>
</body>
</html>



