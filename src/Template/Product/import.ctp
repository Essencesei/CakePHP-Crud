<nav></nav>
<div class="container">

    <?= $this->Form->create($file, ['type' => 'file', 'class' => 'form-horizontal']) ?>
    <fieldset>
        <legend><?= __('Import CSV') ?></legend>
        <div class="form-group">
            <?= $this->Form->label('file', 'Choose CSV File', ['class' => 'control-label']) ?>
            <?= $this->Form->control('file', ['type' => 'file', 'class' => 'form-control']); ?>
        </div>
    </fieldset>
    <div class="form-group text-center">
        <?= $this->Form->submit('Upload CSV', ['class' => 'btn btn-primary']); ?>
    </div>
    <?= $this->Form->end(); ?>
</div>