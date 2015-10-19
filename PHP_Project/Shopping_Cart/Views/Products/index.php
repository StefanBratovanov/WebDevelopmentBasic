<?php
if (!$this->viewData) :?>
    <h1>No Products</h1>
<?php endif;
$products = $this->viewData;
foreach ($products as $product) :?>
    <div style="font-weight: 900; color:darkviolet"><?= htmlspecialchars($product['name']) ?></div>
    <div>Price: <?= htmlspecialchars($product['price']) ?>lv.</div>
    <div>Category: <?= htmlspecialchars($product['category']) ?></div>
    <p></p>
<?php endforeach; ?>

