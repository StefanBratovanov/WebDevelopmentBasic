<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--    <title>Document</title>-->
</head>
<body>
<?= $this->getLayoutData('header'); ?>
<hr/>
<h3 style="font-weight: bold; color: #3c3c5c">Our Products:</h3>
<hr/>
<?= $this->getLayoutData('products'); ?>
<hr/>
<?= $this->getLayoutData('footer'); ?>

</body>
</html>
