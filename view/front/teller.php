<!--koshnicata za productite na magazina-->
<?php //new - instancirane na class.Tazi instanciq moje da se prisvoi dynamic vs static
//$dynamicInstance = new TellerController();
//$productCollection = $dynamicInstance->index();
//$dynamicInstance->markProductForBuy();

//gornoto e ekvivalent na redirect ('teller') and mapping teller/buy
?>

<h2>Списък с продукти</h2>
<div class="product--collection">
    <?php foreach ($productCollection as $element): ?>
        <div class="product--element">
            <div class="w-px-210 display-inline-block"><?php echo $element['title']?></div>
            <div class="w-px-210 display-inline-block"><?php echo $element['price']?></div>
            <div class="w-px-210 display-inline-block"><?php echo $element['quantity']?></div>
            <div class="w-px-210 display-inline-block">
                
                <?php // link('Добави ви клоличка', [
//                    'action'    => 'mark',
//                    'id'        =>  $element['id']
//                ]); ?>
                
                <?php// $queryId ?>  
                <!-- <a href="/mark?id=<?php //echo $element['id']?>">Добави в количка</a> --> 
<!--                podavame  Id na elementa-->
            <?php a('teller/mark', 'Добави в количка', ['id' =>$element['id']]); ?>
            </div>
        </div>

    <?php endforeach; ?>
</div>
