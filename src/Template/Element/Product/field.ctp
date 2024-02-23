<?= $this->Form->create($product, ['type' => 'file', 'class' => 'form']) ?>
<fieldset>
    <legend><?= __($title) ?></legend>
    <div class="form-group">
        <?= $this->Form->control('name', ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('description', ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('price', ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('stock_quantity', ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('category', ['class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('image', ['type' => 'file', 'class' => 'form-control']) ?>
    </div>
</fieldset>
<div class="text-center">
    <button type="submit" class="btn btn-primary"><?= __('Submit') ?></button>
</div>
<?= $this->Form->end() ?>