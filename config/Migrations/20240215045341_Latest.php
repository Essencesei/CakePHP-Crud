<?php
use Migrations\AbstractMigration;

class Latest extends AbstractMigration
{
    public function up()
    {

        $this->table('product', ['id' => false, 'primary_key' => ['product_id']])
            ->addColumn('product_id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 2,
            ])
            ->addColumn('stock_quantity', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('category', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('image_url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'current_timestamp()',
                'limit' => null,
                'null' => false,
            ])
            ->create();
    }

    public function down()
    {
        $this->table('product')->drop()->save();
    }
}
