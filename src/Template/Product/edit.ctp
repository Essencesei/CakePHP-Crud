<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */

use function PHPSTORM_META\type;

?>
<nav class="navbar navbar-expand-lg " id="actions-sidebar">
    <ul class="navbar-nav">
        <li class="nav-item"><?= $this->Form->postLink(
                                    __('Delete'),
                                    ['action' => 'delete', $product->product_id],
                                    ['class' => 'nav-link', 'confirm' => __('Are you sure you want to delete # {0}?', $product->product_id)],

                                )
                                ?></li>
        <li class="nav-item"><?= $this->Html->link(__('List Product'), ['action' => 'index'], ['class' => 'nav-link']) ?></li>
    </ul>
</nav>
<div class="product-form col-lg-9 col-md-8 mx-auto">
    <?= $this->element('/Product/field', ['title' => 'Edit Product']); ?>
</div>