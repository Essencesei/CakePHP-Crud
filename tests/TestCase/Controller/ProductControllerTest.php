<?php

namespace App\Test\TestCase\Controller;

use App\Model\Entity\Product;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Laminas\Diactoros\UploadedFile;
use Symfony\Component\VarDumper\Cloner\Data;

class ProductControllerTest extends TestCase
{
    use IntegrationTestTrait;
    public $fixtures = ['app.Product'];
    public $Product;


    public function setUp()
    {
        parent::SetUp();
        $this->Product = TableRegistry::getTableLocator()->get('product');
        $this->enableCsrfToken();
    }

    public function testView()
    {
        $this->get('/product/view/1');
        $this->assertResponseOk();

        $expected =  $this->Product->find()->where(
            ["product_id" => 1]
        )->toArray();
        $dataInView = $this->_controller->viewVars;

        //CHECK IF MAY "PRODUCT" KEY (ETO UNG TABLE)
        $this->assertArrayHasKey('product', $dataInView);

        // debug($dataInView['product']->toArray());
        // debug($expected[0]->toArray());
        // CHECK IF MATCH RESULT
        $this->assertEquals($expected[0]->toArray(), $dataInView['product']->toArray());
    }

    public function testAdd()
    {
        $data = [
            'name' => 'TEST ADD',
            'description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'price' => 1.5,
            'stock_quantity' => 1,
            'category' => 'Lorem ipsum dolor sit amet',
            'image_url' => 'Lorem ipsum dolor sit amet',
        ];

        $this->post('/product/add', $data);

        $this->assertResponseSuccess();

        $filterCol = ['name', 'description', 'price', 'stock_quantity', 'category', 'image_url'];

        $expected = $this->Product->find()->where(['name' => 'TEST ADD'])->select($filterCol)->toArray();
        // debug($expected[0]->toArray());

        $this->assertEquals($expected[0]->toArray(), $data);
    }
    public function testEdit()
    {
        $editName = 'TEST EDIT';
        $this->get('product/edit/1');
        $this->assertResponseOk();

        $result = $this->_controller->viewVars['product']->toArray();

        $result['name'] = $editName;

        // debug($result);
        $this->put('product/edit/1', $result);
        $expected = $this->Product->find()->where(['product_id' => 1])->toArray();
        $this->assertEquals($expected[0]->toArray(), $result);
    }

    public function testDelete()
    {
        $this->delete('product/delete/1');
        $this->assertResponseSuccess();
        $expected = [];
        $actual = $this->Product->find()->where(['product_id' => 1])->toArray();
        $this->assertEquals($expected, $actual);
    }

    public function testImport()
    {

        $csv = new \Laminas\Diactoros\UploadedFile(
            WWW_ROOT . 'test_uploads/test_file.csv', // stream or path to file representing the temp file
            12345,                    // the filesize in bytes
            \UPLOAD_ERR_OK,           // the upload/error status
            'test_file.csv',             // the filename as sent by the client
            'text/csv'              // the mimetype as sent by the client
        );



        // debug($postData);

        // This is the data accessible via `$this->request->getData()`.
        $postData = [
            'file' => $csv,
        ];

        // debug($this->_request);

        $this->post('/product/import', $postData);

        $this->assertResponseSuccess();
        $expected = $this->Product->find()->where(['name' => 'Test CSV'])->toArray();

        // debug($expected);
        $this->assertEquals(1,  count($expected));
    }


    public function testExport()
    {
        $this->get('product/export');

        $this->assertResponseSuccess();
        // CHECK IF NAKA INDICATE SA CONTENTY TPYE IS CSV 
        $this->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
