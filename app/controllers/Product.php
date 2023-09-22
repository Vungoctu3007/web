<?php
class Product extends Controller {

    public $data = [];
    public function index() {
        echo 'danh sach san pham';
    }

    public function list_product() {
        $product = $this->model('ProductModel');
        $dataProduct = $product->getProductLists();
        $this->data['product_list'] = $dataProduct;
        //render view
        $this->render('products/list', $this->data);
    }

    public function detail($id=0) {
        $product = $this->model('ProductModel');
        $this->data['info'] = $product->getDetail($id);
        $this->data['content'] = 'products/detail';
        $this->render('layout/client_layout', $this->data); 
    }
}