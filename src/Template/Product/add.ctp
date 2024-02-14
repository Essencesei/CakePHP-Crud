<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="navbar navbar-expand-lg" id="actions-sidebar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <?= $this->Html->link(__('List Product'), ['action' => 'index'], ['class' => 'nav-link']) ?>
        </li>
    </ul>
</nav>
<div class="product-form col-lg-9 col-md-8 mx-auto">
    <?= $this->element('/Product/field', ['title' => 'Add Product']); ?>
</div>