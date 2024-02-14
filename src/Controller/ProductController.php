<?php

namespace App\Controller;

use App\Controller\AppController;

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
        $product = $this->paginate($this->Product, ['limit' => 5]);

        $this->set(compact('product'));
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
        if (!empty($file)) {
            $path = WWW_ROOT . 'uploads' . DS . 'csv' . DS . $file->getClientFilename();
            $file->moveTo($path);
            $file = fopen($path, 'r');

            //transactional method para rollback if may error along the way

            $this->Product->getConnection()->transactional(function () use ($file) {
                $firstLine = true; // Flag to skip the first line

                while (!feof($file)) {
                    $content = fgetcsv($file);
                    // dd($content);
                    if ($firstLine) {
                        $firstLine = false;
                        continue;
                    }

                    $product = $this->Product->newEntity();
                    // dd(count($content));

                    // Look for better logic to validate the csv file. 
                    if (count($content) >= 6 || count($content) <= 4) {
                        $this->Flash->error(__('Invalid CSV file. Please, try again.'));
                        return false;
                    }

                    // $this->Product->patchEntity($product, $content);

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

                    if (!$this->Product->save($product)) {
                        $this->Flash->error(__('The product could not be saved. Please, try again.'));
                        return false;
                    }
                }
                $this->Flash->success(__('The products has been imported.'));
                return true;
            });

            fclose($file);

            $this->redirect(['action' => 'index']);
        }
        $this->set('file', $file);
    }

    public function export()
    {
        $this->response->withDownload('products.csv');
        $data = $this->Product->find('all')->toArray();
        $_serialize = 'data';
        $_header = ['product_id', 'name', 'description', 'price', 'stock_quantity', 'category', 'image_url', 'created_at'];
        $this->set(compact('data', '_serialize', '_header'));
        $this->viewBuilder()->setClassName('CsvView.Csv');
        return;
    }

    private function handleFile($file)
    {
        if ($file && $file->getError() === UPLOAD_ERR_OK) {
            $fileName = $file->getClientFilename();
            $file->moveTo(WWW_ROOT . 'uploads' . DS . 'images' . DS . $fileName);
            return $fileName;
        }
    }
}
