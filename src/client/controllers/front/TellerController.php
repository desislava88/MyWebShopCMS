<?php
//class - opakovki obvivat function and datas/kashon v koito si slagame cenni neshta.
class TellerController {
    
    private $action;
    private $productId;
    private $quantity;
    
    private  $modelDataCollection = array();


    //spacial function when the class is call. Vika se kogato class se zaredi -onload
    public function __construct() {
        
        $this-> action = (array_key_exists('action', $_GET))       ? $_GET['action'] : null;
        $this-> productId = (array_key_exists('id', $_GET))        ? $_GET['id'] : null;
        $this-> quantity = (array_key_exists('quantity', $_GET))   ? $_GET['id'] : 1;
        
        $this->modelDataCollection = array(
            'productId' => ((array_key_exists('id', $_GET))        ? $_GET['id'] : null),
            'quantity'  => ((array_key_exists('quantity', $_GET))   ? $_GET['id'] : 1),
            'userId'    => User::getId()
        );
    }
    
    //za vizualizaciq na dannite
    public function index(){
        //return Database::fetch("tb_products");         //Database::query("SELECT * FROM tb_products")
        //return Database::select('tb_products')::fetch();
        return ProductModel::getAllProducts();
    }
    
    
    // za aktualizaciq na dannite
    public function  markProductForBuy() {
        
        if(!$this->isStateMark())   return;
        
       // $isProductAvailable = $this->isProductAvailable();
        
        $isProductAvailable = ProductModel::isProductAvailable($this->modelDataCollection);
        
        if($isProductAvailable){
            
            //$this->markProductToCustomer();
            ProductModel::markProductToCustomer($this->modelDataCollection);
            
            //$this->updateProduct();
            ProductModel::updateProduct($this->modelDataCollection);
            
            //to do refresh controller - data
        }
    }
    
    private function isStateMark() {
      return $this->action == 'mark';
}
}






//$action = (array_key_exists('action', $_GET))   ? $_GET['action'] : null;
//$productId = (array_key_exists('id', $_GET))           ? $_GET['id'] : null;
//$quantity = (array_key_exists('quantity', $_GET))           ? $_GET['id'] : 1;
//// get all products from  table
//

////
//if($action == 'mark'){
//    markProduct();
//}
//
////function za markirane na produktite, izpylnqva se ako ima action=mark.
//function markProduct(){
//        
//    //insert new relation betwen user and product
//    
// 
//}