<?php
//model kojto se griji za logikata za rabota s producti.
//kontrolera samo vika danni i vrushta dannite na view, a MODEL izpylnqva cqlata LOGIC i rabota
class ProductModel {
    
    //vzemame vsichki danni ot DB table products
    public static function getAllProducts(){
        return Database::select('tb_products')::fetch();
    }
    
    public static function isProductAvailable($dataCollection){
        echo 'Check product availability';
        
        //check if product quantity exist
        $fetchQuery = Database::select('tb_products')::where (array(
            //'id'    => $this->productId
            'id'    => $dataCollection['productId']
        )):: fetchSingle();
        
        //$fetchQuery = Database::fetch('tb_products');
        
        return $fetchQuery['quantity'] >= $dataCollection['quantity'];
    }
    
    // Insert data v tb user_product
    public static function  markProductToCustomer($dataCollection) {
        //promenliva, koqto sledi ima ili nqma zapis
        $productUserCollection = Database::select('tb_user_product')::where(array(
            'user_id'      => $dataCollection['userId'],       //User::getId(),
            'product_id'   => $dataCollection['productId']      //$this->productId
            )):: fetch();
        
        //ako ima zapis update call function updateUserProduct()
          if(count($productUserCollection) > 0){
              //return $this->updateUserProduct();
              self::updateUserProduct(array(
                  'pdocuctId'   =>  $dataCollection['productId'],
                  'quantity'    =>  $dataCollection['quantity']
              ));
          }  
           //ako nqma zapis insert - call function insertUserProduct() 
          //$this -> insertUserProduct();
          
          self::insertUserProduct(array(
              'userId'      =>  $dataCollection['userId'],
              'pdocuctId'   =>  $dataCollection['productId'],
              'quantity'    =>  $dataCollection['quantity']
          ));
    }
     
    //update user product
    
    //insert user product

    public static function insertUserProduct($dataCollection){
        
               //Insert new relation between user and product
        Database::insert('tb_user_product', array(
        'user_id'      =>  $dataCollection['userId'],
        'product_id'  => $dataCollection['productId'],        //$this-> productId,
        'quantity'     =>  $dataCollection['quantity']         //$this->quantity
    ));
    }

    public static function updateUserProduct($dataCollection){
        
        $userProductEntity = Database::select('tb_user_product')::where(array(
            'user_id'      => User::getId(),
            'product_id'   => $dataCollection['productId']          //$this-> productId
        ))::fetchSingle();

        //starata st-st koqto imame
        $userProductQuantity = $userProductEntity['quantity'];
        //starata st-st sybrana s novaat st-st
        $newUserProductQuantity = ($userProductQuantity + $dataCollection['quantity']);   //$this->quantity);
        
        Database::update('tb_user_product', array (
            'quantity'  => $newUserProductQuantity
        ))::where(array(
            'user_id'      => User::getId(),
            'product_id'   => $dataCollection['productId']  //$this-> productId
        ))::execute();
    }

    public static function updateProduct($dataCollection){
        //vzemamte za tekushtiq produkt quantity 
        $productEntity = Database::select('tb_products')::where(array(
            'id'        => $dataCollection['productId']               //$this->productId
        ))::fetchSingle();
        
        //ot tekushtiq product  vadim quantity na zaqvkata koqto sme napravili
        $productQuantity = $productEntity['quantity'];
        $newProductQuantity = $productQuantity - $dataCollection['quantity'];  //$this->quantity;
        
        Database::update('tb_products', array(
            'quantity'  => $newProductQuantity   
        ))::where(array(
             'id'   => $dataCollection['productId']     // $this->productId
        ))::execute();
    }
}

