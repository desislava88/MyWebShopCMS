<?php

class Loader {
    
    //define na pravila 
    private static $viewMapping = array(
        'home'      => array(
            //'view'          => 'view/front/home.php',
            'controller'    => (FRONT_CONTROLLER_LOCATION . 'HomeController.php')
                                //'src/client/controllers/front/HomeController.php'
        ),
        'signin'            => array(
            //'view'          => 'view/front/signin.php',
            'controller'    => (FRONT_CONTROLLER_LOCATION . 'SignInController.php'),
                                    //'src/client/controllers/front/SignInController.php',
            'guard_rules'   => ['redirectIfAuthenticated']
        ),
        'signup'            => array(
            //'view'          => 'view/front/signup.php',
            'controller'    => (FRONT_CONTROLLER_LOCATION . 'SignUpController.php')
                                //'src/client/controllers/front/SignUpController.php'
         ),
        'logout'            => array(
            //'view'          => NULL,
            'controller'    => (FRONT_CONTROLLER_LOCATION .'LogoutController.php'),
                                //'src/client/controllers/front/LogoutController.php'
        ),
        
//        'teller'            => array(
//            'view'          => 'view/front/teller.php',
//            'controller'    => FRONT_CONTROLLER_LOCATION . 'TellerController.php'
//        ),

        'teller'            => array(
             //'view'          => 'view/front/teller.php',
            'controller'    => (FRONT_CONTROLLER_LOCATION . 'TellerController.php' ),
            'models'        => [(MODEL_LOCATION . 'ProductModel.php' )],
            'controllerClass' => 'TellerController',
            'method'        => 'index'
        ),
  
        'teller/mark'      => array(
            //'view'          => 'view/front/teller.php',
            'controller'        => (FRONT_CONTROLLER_LOCATION . 'TellerController.php' ),
            'controllerClass'   => 'TellerController',
            'models'        => [(MODEL_LOCATION . 'ProductModel.php' )],
            'method'        => 'markProductForBuy'
        ),        
        
//        'teller/mark/{id}'       => array(
//            //'view'          => 'view/front/teller.php',
//            'controller'    => (FRONT_CONTROLLER_LOCATION . 'TellerController.php'),
//            'models'        => [(MODEL_LOCATION .'ProductModel.php')],
//            'method'        => 'markProductForBuy'
//        ),
  
        'create_product'    => array(
            //'view'          => 'view/admin/product.php',
            'controller'    => (ADMIN_CONTROLLER_LOCATION .'ProductController.php'),
                                //'src/client/controllers/admin/ProductController.php',
            'guard_rules'  => ['adminOnly'] 
            //admin only
        ),
        
        'create_category'   => array (
            //'view'          => 'view/admin/category.php',
            'controller'    => (ADMIN_CONTROLLER_LOCATION .'CategoryController.php'),
                                //'src/client/controllers/admin/CategoryController.php',
            'guard_rules'  => ['adminOnly']
             //admin only
        )
    );

    private static $viewMapping404 = array(
        'page_not_found'    => array(
            //'view'  => 'view/layout/page_404.php',
            'controller' => (SYSTEM_CONTROLLER_LOCATION. 'Page404Controller.php')
                                //'src/client/controllers/system/Page404Controller.php'
        )
    );
    
    private static $DEFAULT_CONTROLLER = 'home';
    
    public static function isGuarded($controller) {
        
        if(!array_key_exists('guard_rules', self::getControllerConfig($controller))){
            return false;
        }
        $guardCollection = self::getControllerConfig($controller)['guard_rules'];
        
        foreach ($guardCollection as $guardRule) {
            if($guardRule()) return true;
        }
        return false;
    }


    public static function getView($controller) {
        return self::getControllerConfig($controller)['view'];
    }
    
    public static function getController($controller) {
        return self::getControllerConfig($controller)['controller'];     
    }  
    
    public static function getControllerClass($controller) {
        return self::getControllerConfig($controller)['controllerClass'];
    } 
    
     public static function getControllerMethod($controller) {
        return self::getControllerConfig($controller)['method'];     
    }

  public static function getModelCollection($controller) {
        return self::getControllerConfig($controller)['models'];
    }
    
    public static function getControllerIndex() {

        if(!array_key_exists('PATH_INFO', $_SERVER)) {
            return self::$DEFAULT_CONTROLLER;
        }

        $pageIndexCollection = explode('/', $_SERVER['PATH_INFO']);
        
        array_shift($pageIndexCollection);
        
        echo'<pre>';
        var_dump(implode('/', $pageIndexCollection));
        echo'</pre>';

        //return $pageIndexCollection[0];
        
        return implode('/', $pageIndexCollection);
    }
    
    private static function getControllerConfig($controller) {

        if(array_key_exists($controller, self::$viewMapping)) {
            return self::$viewMapping[$controller];
        }

        return self::$viewMapping404['page_not_found'];
    }        
} 

