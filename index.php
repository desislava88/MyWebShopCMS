<?php
include './src/vendor/util/utils.php';
include basecontext ('src/client/route/paths.php');


include basecontext('src/vendor/database/Database.php'    );     
include basecontext('src/vendor/validation/Validator.php' );  
include basecontext('src/vendor/message/Message.php'      );       
include basecontext('src/vendor/user/User.php'            );         
include basecontext('src/vendor/loader/Loader.php'        );    

include basecontext('src/client/components/dropdown.php');
include basecontext('src/client/route/guards.php');

$controllerIndex = Loader::getControllerIndex();
$viewPath        = Loader::getView($controllerIndex);
$modelCollection = Loader::getModelCollection($controllerIndex);
$controllerPath  = Loader::getController($controllerIndex);



//dynamic release  Function - izpylnenie na dinamichna function, podavajki imeto i samo kato text, ako tq sushtestvuva nqkyde v sistemata!
//function dynamicExecute   
//    echo "Hello world from dynamic function";
//}
//'dynamicExecute'();

if(Loader::isGuarded($controllerIndex)) {
    redirect('home');
}

//*load baseview
include basecontext('view/layout/header.php');

//*load model
foreach ($modelCollection as $modelClass) {
    include basecontext($modelClass);
}

//*load controller
include basecontext($controllerPath);


//*load VIEW
if(!is_null($viewPath)){
    include basecontext($viewPath);
}

//*load base view
include basecontext('view/layout/footer.php');