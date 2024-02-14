<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $product
 */
?>
<nav class="navbar navbar-expand-lg " id="actions-sidebar">
    <ul class="navbar-nav">
        <li class="nav-item"><?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'nav-link']) ?></li>
        <li class="nav-item"><?= $this->Html->link(__('Import CSV'), ['action' => 'import'], ['class' => 'nav-link']); ?></li>
        <li class="nav-item"><?= $this->Html->link(__('Export CSV'), ['action' => 'export'], ['class' => 'nav-link']); ?></li>
    </ul>


</nav>
<div class="product index large-9 medium-8 columns content">
    <h3><?= __('Product') ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('stock_quantity') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('category') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $product) : ?>
                    <tr>
                        <td><?= $this->Number->format($product->product_id) ?></td>
                        <td><?= h($product->name) ?></td>
                        <td><?= $this->Number->format($product->price) ?></td>
                        <td><?= $this->Number->format($product->stock_quantity) ?></td>
                        <td><?= h($product->category) ?></td>
                        <td class="actions text-center">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $product->product_id], ['class' => 'btn btn-primary']) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->product_id], ['class' => 'btn btn-secondary']) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->product_id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $product->product_id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
        <p class="fs-4"><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ') ?>
            <?= $this->Paginator->prev('< ') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(' >') ?>
            <?= $this->Paginator->last(' >>') ?>
        </ul>

    </div>
</div>
</div>