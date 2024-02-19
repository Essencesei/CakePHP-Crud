<?php

namespace App\Controller;

use App\Controller\AppController;
use DateTime;
use phpDocumentor\Reflection\Types\This;

/**
 * Product Controller
 *
 * @property \App\Model\Table\ProductTable $Product
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // $product = $this->Product->find('all');

        // $this->set(compact('product'));
    }

    public function getData()
    {
        $this->autoRender = false;

        //get the search value from dataTables request
        $searchQueryValue = $this->request->getQuery('search')['value'];

        //return to Array para array ang result 
        $product = $this->handleQuery($searchQueryValue)->toArray();
        //eto naman para sa count for pagination
        $count = $this->handleQuery($searchQueryValue)->count();

        //Modify data para sa structure ng datatables
        //array_values para ung "0": {data..} na structure ng data e maging array na lang.

        $modifiedData = [
            'draw' => $this->request->getQuery('draw'),
            'recordsTotal' => $this->Product->find()->count(),
            'recordsFiltered' => $count,
            'data' => array_values($product)
        ];

        // $this->response = $this->response->withType('application/json')->withStringBody(json_encode($modifiedData));
        //set muna response header application json then convert sa json ung modifieddata
        return $this->response->withType('application/json')->withStringBody(json_encode($modifiedData));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Product->get($id, [
            'contain' => [],
        ]);

        $this->set('product', $product);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */



    public function add()
    {
        $product = $this->Product->newEntity();

        if ($this->request->is('post')) {
            $product->image_url = $this->handleFile($this->request->getUploadedFile('image'));
            $product = $this->Product->patchEntity($product, $this->request->getData());

            if ($this->Product->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Product->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $product->image_url =  $this->handleFile($this->request->getUploadedFile('image'));
            $product = $this->Product->patchEntity($product, $this->request->getData());

            if ($this->Product->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Product->get($id);
        if ($this->Product->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'),);
        }

        return $this->redirect(['action' => 'index']);
    }

    public function import()
    {

        $file = $this->request->getUploadedFile('file');
        $isError = false; //EMPTY FLAG SET TO TRUE IF EMPTY TAS VALIDATE FOR ERROR FLASH
        $numberofloop = 0; // COUNTER FOR NUMBER OF LOOP PAG LESS THAN OR EQUAL 2 EMPTY YUNG FILE


        if (!empty($file)) {

            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                $path = WWW_ROOT . 'uploads' . DS . 'csv' . DS . $file->getClientFilename();
                $file->moveTo($path);
                $file = fopen($path, 'r');

                //transactional method para rollback if may error along the way
                //USE ISEMPTY PARA MAACCESS UNG IS EMPTY NA GINAWA SA TAAS SET AS &REFERENCE SINCE
                // BINABAGO YUNG VALUE NG VARIABLE
                $this->Product->getConnection()->transactional(function () use (&$file, &$isError, &$numberofloop) {
                    $firstLine = true; // Flag to skip the first line, since row 1 is header.


                    while (!feof($file)) {
                        $content = fgetcsv($file);
                        $numberofloop++;

                        if ($firstLine) {
                            $firstLine = false;
                            continue; // di mag pproceed ung first iteration mag loloop lang ulit.
                        }

                        if ($content == null) {
                            continue;
                        }


                        $product = $this->Product->newEntity();
                        // Look for better logic to validate the csv file. 
                        if (count($content) > 5 || count($content) < 5) {
                            $isError = true;
                            return false;
                        }

                        $this->handleCsvData($product, $content);


                        if (!$this->Product->save($product)) {
                            $isError = true;
                            return false;
                        }
                    }
                    return $isError ? false : true;
                });

                fclose($file);
            }

            // dd($isError || $numberofloop <= 2);
            // VALIDATE IF NUMBER OF LOOP IS LESS THAN 2 ITERATION FOR SURE EMPTY YUNG FILE
            if ($isError || $numberofloop <= 2) {
                $this->Flash->error(__('There was an error importing the file. Please try again.'));
            } else {
                $this->Flash->success(__('csv file has been imported successfully.'));
                $this->redirect(['action' => 'index']);
            }
        }

        $this->set('file', $file);
    }

    public function export()
    {
        $_header = ['product_id', 'name', 'description', 'price', 'stock_quantity', 'category'];
        $data = $this->Product->find('all')->select($_header)->toArray();
        $_serialize = 'data';
        $this->set(compact('data', '_serialize', '_header'));
        $this->viewBuilder()->setClassName('CsvView.Csv');

        $date = new DateTime();
        $this->response = $this->response->withDownload($date->format("Y-m-d") . '_products.csv');
    }

    public function template()
    {
        $_header = ['name', 'description', 'price', 'stock_quantity', 'category'];
        $data = [];
        $_serialize = 'data';
        $this->set(compact('data', '_serialize', '_header'));
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->response = $this->response->withDownload('product_template.csv');
    }

    private function handleFile($file)
    {
        if ($file && $file->getError() === UPLOAD_ERR_OK) {
            $fileName = $file->getClientFilename();
            $file->moveTo(WWW_ROOT . 'uploads' . DS . 'images' . DS . $fileName);
            return $fileName;
        } else {
            return null;
        }
    }

    private function handleCsvData($product, $content)
    {
        // Indexes of the csv file
        // 0 - name
        // 1 - description
        // 2 - price
        // 3 - stock_quantity
        // 4 - category
        // 5 - image_url
        // 6 - created_at

        $product->name = $content[0];
        $product->description = $content[1];
        $product->price = (int)$content[2];
        $product->stock_quantity = (int)$content[3];
        $product->category = $content[4];
    }

    private function handleQuery($searchQueryValue)
    {
        //PROCEED WITH THE MANUAL QUERY FOR THE DATATABLES
        //CHECK SA NETWORK TAB UNG PAYLOAD ANDON MGA DETAILS NG DATATABLES REQUEST
        // YUNG IBANG MGA GAMIT FOR SORTING PAGINATION ETC UN UNG MGA NAKA GETQUERY SA REQUEST LIKE ORDER START LENGTH ETC

        //COLUMNS
        // 0 - product_id
        // 1 - name
        // 2 - price
        // 3 - stock_quantity
        // 4 - category
        // 5 - none

        //get column index
        $columnIndex = $this->request->getQuery('order')[0]['column'];
        //get column name from column index 
        $columnName = $this->request->getQuery('columns')[$columnIndex]['data'];

        //CAST muna to char ung price, product_id, stock_quantity para ma search, mag error pag hindi cinast

        return  $this->Product->find()->where([
            'OR' => [
                ['name LIKE' => "%{$searchQueryValue}%"],
                ['CAST(price as char) LIKE' => "%{$searchQueryValue}%"],
                ['CAST(product_id as char) LIKE' => "%{$searchQueryValue}%"],
                ['CAST(stock_quantity as char) LIKE' => "%{$searchQueryValue}%"],
                ['category LIKE' => "%{$searchQueryValue}%"]
            ]
        ])->order([$columnName => $this->request->getQuery('order')[0]['dir']])->limit($this->request->getQuery('length'))->offset($this->request->getQuery('start'));
    }
}
