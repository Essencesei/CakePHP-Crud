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
    <table id="dataTable" class=" compact stripe" style="width:100%">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock Quantity</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Product ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock Quantity</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>

    <!-- <div class="table-responsive">
        <table id="dataTables" class="">
            <thead>
                <tr>
                    <th scope="col"><?= __('Product ID') ?></th>
                    <th scope="col"><?= __('Name') ?></th>
                    <th scope="col"><?= __('Price') ?></th>
                    <th scope="col"><?= __('Stock Quantity') ?></th>
                    <th scope="col"><?= __('Category') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($product as $product) : ?>
                    <tr>
                        <td><?= $this->Number->format($product->product_id) ?></td>
                        <td><?= h($product->name) ?></td>
                        <td><?= $this->Number->currency($product->price, 'PHP') ?></td>
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
    </div> -->

    <script type="text/javascript">
        //GLOBAL VARIABLE return neto ung mismong url para magamit sa dataTables.js para sa url
        var editUrl = "<?php echo $this->Url->build(['controller' => 'Product', 'action' => 'edit']); ?>";
        var viewUrl = "<?php echo $this->Url->build(['controller' => 'Product', 'action' => 'view']); ?>";
    </script>



</div>