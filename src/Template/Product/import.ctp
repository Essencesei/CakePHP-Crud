<nav></nav>
<div class="container">

    <nav class="navbar navbar-expand-lg " id="actions-sidebar">
        <ul class="navbar-nav">

            <li class="nav-item"><?= $this->Html->link(__('Download Template'), ['action' => 'template'], ['class' => 'nav-link']) ?></li>

        </ul>
    </nav>
    <?= $this->Form->create($file, ['type' => 'file', 'class' => 'form-horizontal']) ?>
    <fieldset>
        <legend><?= __('Import CSV') ?></legend>
        <div class="form-group">
            <?= $this->Form->control('file', ['type' => 'file', 'class' => 'form-control']); ?>

        </div>
    </fieldset>
    <div class="form-group text-center">
        <?= $this->Form->submit('Upload CSV', ['class' => 'btn btn-primary']); ?>
    </div>
    <?= $this->Form->end(); ?>

</div>