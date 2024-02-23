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



    <script type="text/javascript">
        //GLOBAL VARIABLE return neto ung mismong url para magamit sa dataTables.js para sa url
        let editUrl = "<?php echo $this->Url->build(['controller' => 'Product', 'action' => 'edit']); ?>";
        let viewUrl = "<?php echo $this->Url->build(['controller' => 'Product', 'action' => 'view']); ?>";
    </script>



</div>