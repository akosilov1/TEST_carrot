<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
\Bitrix\Main\Loader::includeModule('iblock');

$intRowsCount = count($arResult['ITEMS']);
$strRand = $this->randString();
$strContID = 'cat_top_cont_'.$strRand;
//echo "<!-- items::<pre>";print_r($arResult['ITEMS']);echo "</pre> -->";
//****
$n_arItemsTemp = array();
$n_rsSection = CIBlockSection::GetList(array("SORT"=>"ASC"),
    array('IBLOCK_ID'=>1, 'UF_SHOW_MAIN' => 1), false, 
    array("UF_*", 'IBLOCK_ID', "ID","DEPTH_LEVEL","NAME","IBLOCK_SECTION_ID","SECTION_PAGE_URL")
    );
//$n_rsSection->SelectedRowsCount() > 0){
while($n_arSection = $n_rsSection->GetNext()){
    $n_arItemsTemp[$n_arSection['ID']]['SECTION'] = $n_arSection;
    //echo $n_arSection["ID"].",";
    $n_arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM","DETAIL_PICTURE","DETAIL_PAGE_URL","CATALOG_GROUP_1");
    $n_arFilter = Array("IBLOCK_ID"=>$n_arSection['IBLOCK_ID'], "SECTION_ID"=>$n_arSection["ID"], "INCLUDE_SUBSECTIONS" => "Y", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
    $n_res = CIBlockElement::GetList(array("SORT"=>"ASC"), $n_arFilter, false, Array("nTopCount"=>10), $n_arSelect);//

    while($n_ob = $n_res->GetNextElement())
    {
        $n_arFields = $n_ob->GetFields();
        $arDiscounts = CCatalogProduct::GetOptimalPrice(
            $n_arFields['ID'],
            1,
            $USER->GetUserGroupArray(),
            "N",
            1,
            SITE_ID
        );

        $n_arItemsTemp[$n_arSection['ID']]['ITEMS'][$n_arFields['ID']] = $n_arFields;
        $n_arItemsTemp[$n_arSection['ID']]['ITEMS'][$n_arFields['ID']]['PRICE__']['DISCOUNT_PRICE'] = $arDiscounts['DISCOUNT_PRICE'];

        //echo"<!-- <pre>"; print_r($arDiscounts);
        //echo"</pre> -->";
    }

}
/*echo "<!-- test_items::<pre>";
print_r($n_arItemsTemp);
echo "</pre> -->";


//***
$arItemsTemp = array();
foreach ($arResult['ITEMS'] as $keyRow => $arOneRow) {
    foreach ($arOneRow as $keyItem => $arItem) {
        $rsSection = CIBlockSection::GetList(array("SORT"=>"ASC"),array('IBLOCK_ID'=>$arItem['IBLOCK_ID'],'ID'=>$arItem['IBLOCK_SECTION_ID'], 'UF_HOME' => 1), false, array("UF_*", 'IBLOCK_ID', "ID","DEPTH_LEVEL","NAME","IBLOCK_SECTION_ID","SECTION_PAGE_URL"));
        if($rsSection->SelectedRowsCount() > 0){
            $arSection = $rsSection->GetNext();
            if ($arSection['DEPTH_LEVEL'] > 1) {
                $rsSection = CIBlockSection::GetList(array("SORT"=>"ASC" ), array('IBLOCK_ID' => $arItem['IBLOCK_ID'], 'ID' => $arSection['IBLOCK_SECTION_ID'], 'UF_HOME' => 1), false, array("UF_*", 'IBLOCK_ID', "ID","DEPTH_LEVEL","NAME","IBLOCK_SECTION_ID","SECTION_PAGE_URL"));
                $arSection = $rsSection->GetNext();

            }

            $arItemsTemp[$arSection['ID']]['SECTION'] = $arSection;
            $arItemsTemp[$arSection['ID']]['ITEMS'][] = $arItem;
        }

    }
}
*/
$color = 1;
/*echo "!-- items:: <pre>";
print_r($arItemsTemp);
echo "</pre> -->";*/
foreach ($n_arItemsTemp as $section) {
?>
<div class="products">
    <div class="block_title color<?=$color?>">
        <div><?=$section['SECTION']['NAME']?></div>
    </div>
    <div class="carousel owl-carousel">
        
            <?foreach ($section['ITEMS'] as $arItem) {

                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strElementEdit);
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
$strMainID = $this->GetEditAreaId($arItem['ID']);

                $arItemIDs = array(
                    'ID' => $strMainID,
                    'PICT' => $strMainID.'_pict',
                    'SECOND_PICT' => $strMainID.'_secondpict',
                    'MAIN_PROPS' => $strMainID.'_main_props',

                    'QUANTITY' => $strMainID.'_quantity',
                    'QUANTITY_DOWN' => $strMainID.'_quant_down',
                    'QUANTITY_UP' => $strMainID.'_quant_up',
                    'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
                    'BUY_LINK' => $strMainID.'_buy_link',
                    'BASKET_ACTIONS' => $strMainID.'_basket_actions',
                    'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
                    'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
                    'COMPARE_LINK' => $strMainID.'_compare_link',

                    'PRICE' => $strMainID.'_price',
                    'DSC_PERC' => $strMainID.'_dsc_perc',
                    'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

                    'PROP_DIV' => $strMainID.'_sku_tree',
                    'PROP' => $strMainID.'_prop_',
                    'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
                    'BASKET_PROP_DIV' => $strMainID.'_basket_prop'
                );

                $thumbPicture = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'],array('width'=>250,'height'=>250),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);//$arItem['DETAIL_PICTURE']['ID']
                ?>
            
                    <div class="product">
                        <div class="thumb"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$thumbPicture['src']?>" alt=""></a></div>
                        <div class="name"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                        <div class="price left">
                            <?php if ($arItem['PRICE__']['DISCOUNT_PRICE'] < $arItem['CATALOG_PRICE_1']): ?>
                                <span class="old-price"><?=SaleFormatCurrency($arItem['CATALOG_PRICE_1'], "RUB");?></span>
                                <?=$arItem['PRICE__']['DISCOUNT_PRICE']." руб." ?>
                            <? else:?>
                                <?=SaleFormatCurrency($arItem['CATALOG_PRICE_1'], "RUB");?>
                            <?php endif; ?>
                            
                            <?//=$arItem['PRICES']['BASE']['PRINT_DISCOUNT_VALUE_NOVAT']?>
                        </div>
                            <a id="<? echo $arItemIDs['BUY_LINK']; ?>" href="/ajax/forms/addbasket.php?id=<?=$arItem['ID']?>" class="fancybox.ajax bx_add_basket buy_link right"><span>в корзину</span></a>
                    </div>
              
            <?}?>

     
    </div>
    <div class="all"><a href="<?=$section['SECTION']['SECTION_PAGE_URL']?>">все <?=$section['SECTION']['NAME']?></a></div>
    </div>
<?
   if ($color == 2) $color = 1; else $color++;
}
?>
