<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<nav class="navbar navbar-expand-lg" id="actions-sidebar">
    <ul class="navbar-nav">
        <li class="nav-item mb-2">
            <?= $this->Html->link(__('Edit Product'), ['action' => 'edit', $product->product_id], ['class' => 'nav-link']) ?>
        </li>

        <li class="nav-item mb-2">
            <?= $this->Form->postLink(__('Delete Product'), ['action' => 'delete', $product->product_id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->product_id), 'class' => 'nav-link']) ?>
        </li>

        <li class="nav-item mb-2">
            <?= $this->Html->link(__('List Product'), ['action' => 'index'], ['class' => 'nav-link']) ?>
        </li>

        <li class="nav-item mb-2">
            <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'nav-link']) ?>
        </li>
    </ul>
</nav>
<div class="product view large-9 medium-8 columns content">
    <h3><?= h($product->name) ?></h3>
    <div class="table-responsive">
        <table class="table">
            <tr>
                <td>
                    <img src="<?= $this->Url->image('/uploads/images/' . $product->image_url) ?>" alt="<?= h($product->name) ?>" class="img-fluid" style="max-width: 400px; height: auto;">
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($product->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Category') ?></th>
                <td><?= h($product->category) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Product Id') ?></th>
                <td><?= $this->Number->format($product->product_id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Price') ?></th>
                <td><?= $this->Number->format($product->price) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Stock Quantity') ?></th>
                <td><?= $this->Number->format($product->stock_quantity) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Date Created') ?></th>
                <td><?= $this->Time->format($product->created_at); ?></td>
            </tr>
        </table>
    </div>
    <div class="row mt-4 d-flex">
        <h4><?= __('Description') ?></h4>
        <p><?= h($product->description) ?></p>
    </div>
</div>