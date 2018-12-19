<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?\Bitrix\Main\Loader::includeModule('iblock');?>
<?if (count($arResult["ITEMS"]["AnDelCanBuy"])>0) {?>
<div class="cart_info">
    <table>
        <thead>
        <tr>
            <th></th>
            <th>Наименование</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
            <th>Удалить</th>
        </tr>
        </thead>

        <tbody>
        <?
        $i=0;
        foreach($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems)
        {
            $rsProduct = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>1,'ID'=>$arBasketItems['PRODUCT_ID']),false,false,
                array('ID','NAME','DETAIL_PAGE_URL','PROPERTY_MATERIAL','DETAIL_PICTURE','PROPERTY_COMPLECT'));
            if ($arProduct = $rsProduct->GetNext())
                $arBasketItems['PRODUCT'] = $arProduct;

            if ($arBasketItems['PRODUCT']['DETAIL_PICTURE']>0) {
                $arBasketItems['PICTURE'] = CFile::ResizeImageGet($arBasketItems['PRODUCT']['DETAIL_PICTURE'],
                    array('width'=>100,'height'=>100),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
            }
        ?>
        <tr>
            <td class="image">
                <div class="img">
                    <a href="/"><img src="<?=$arBasketItems['PICTURE']['src']?>" alt=""></a>
                </div>
            </td>
            <td class="info">
                <div class="name"><a href="<?=$arBasketItems["DETAIL_PAGE_URL"] ?>"><?=$arBasketItems["NAME"] ?></a></div>
                <pre>
                    <?//print_r($arBasketItems);?>
                </pre>
                <div class="features">
                    <?if (!empty($arBasketItems['PRODUCT']['PROPERTY_MATERIAL_VALUE'])) {?>
                    <div><b>Материал:</b> <?=$arBasketItems['PRODUCT']['PROPERTY_MATERIAL_VALUE']?></div>
                    <?}?>
                      <?
                      $gift = 'N';
                      foreach($arBasketItems["PROPS"] as $val)
                        {
                            if ($val['NAME'] == 'Подарочная упаковка') {
                                $gift = 'Y';
                                continue;
                            }
                            echo "<div><b>".$val["NAME"].":</b> ".$val["VALUE"]."</div>";
                        }
                      ?>

                </div>
                <?if (!empty($arBasketItems['PRODUCT']['PROPERTY_COMPLECT_VALUE'])) {?>
                <div class="gift">
                    <input type="checkbox" value="Y" name="gift_check[<?=$arBasketItems['ID']?>]" <?if ($gift == 'Y') echo 'checked';?> data-need="<?=$gift?>" onclick="addGiftBasket('<?=$arBasketItems['ID']?>');" id="gift_check<?=$arBasketItems['ID']?>">
                    <label for="gift_check<?=$arBasketItems['ID']?>"><a href="/podarochnaya-upakovka/">Бесплатная подарочная упаковка!</a></label>
                </div>
                <?}?>
            </td>
            <td class="price"><?=$arBasketItems["PRICE_FORMATED"]?></td>
            <td class="amount cart-item-quantity" >
                <a href="#" class="minus" onclick="minusBasket(this);return false;"></a>
                <input type="text" name="QUANTITY_<?=$arBasketItems["ID"] ?>" value="<?=$arBasketItems["QUANTITY"]?>"  data-minimum="1" data-maximum="999" maxlength="3">
                <a href="#" class="plus" onclick="plusBasket(this);return false;"></a>
            </td>
            <td class="price"><?=CurrencyFormat($arBasketItems["PRICE"]*$arBasketItems["QUANTITY"],"RUB")?></td>
            <td class="delete"><a href="<?=str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["delete"])?>"></a></td>
        </tr>
        <?}?>


        </tbody>
    </table>

    <div class="cart_total">
        <div class="total_price">
            Товаров на: <div class="price"><?=$arResult["PRICE_FORMATED"]?></div>
        </div>
        <div class="total">
            Итого: <div class="price"><?=$arResult["PRICE_FORMATED"]?></div>
            <div class="exp"><div>* без учёта стоимости доставки</div></div>
        </div>
    </div>
</div>

<?} else {?>

    <div style="height: 300px;">
В корзине нет товаров
    </div>
<?}?>

