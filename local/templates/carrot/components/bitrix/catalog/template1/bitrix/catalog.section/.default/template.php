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
?>

<?
if (!empty($arResult['ITEMS'])) {
?>
    <div class="products list">
    <div class="items">
    <?
    foreach ($arResult['ITEMS'] as $arItem) {
        $thumbPicture = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']['ID'],array('width'=>250,'height'=>250),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
        ?>
        <div class="product left">
            <div class="thumb"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$thumbPicture['src']?>" alt=""></a></div>
            <div class="name"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
            <div class="price left">
                <?$frame = $this->createFrame()->begin("Загрузка цен...");?>
                <?php if ($arItem['PRICES']['BASE']['DISCOUNT_DIFF']): ?>
                    <span class="old-price"><?= $arItem['PRICES']['BASE']['PRINT_VALUE_NOVAT'] ?></span>
                <?php endif; ?>
                
                <?=$arItem['PRICES']['BASE']['PRINT_DISCOUNT_VALUE_NOVAT']?>
                <?$frame->end();?>
            </div>
            <a  id="<? echo $arItemIDs['BUY_LINK']; ?>" href="/ajax/forms/addbasket.php?id=<?=$arItem['ID']?>" class="fancybox.ajax bx_add_basket buy_link right"><span>в корзину</span></a>
        </div>
        <?
    }
    ?>
        <div class="clear"></div>
    </div>
    </div>
    <?

	if ($arParams["DISPLAY_BOTTOM_PAGER"])
	{
		?><? echo $arResult["NAV_STRING"]; ?><?
	}
}?>

<?if($arResult['DESCRIPTION']){
	$arResult['DESCRIPTION'] = explode("<hr>",$arResult['DESCRIPTION']);
	if(!isset($arResult['DESCRIPTION'][1])) $arResult['DESCRIPTION'][1] = "";
	if(!isset($arResult['DESCRIPTION'][2])) $arResult['DESCRIPTION'][2] = "";
	if(!isset($arResult['DESCRIPTION'][3])) $arResult['DESCRIPTION'][3] = "";
	$SEZON = (is_array($_GET['SEZON']))?intval($_GET['SEZON'][0]):0;
	switch($SEZON){
		case 5: $SEZON = 1; break; // 5 - ЛЕТО
		case 3: $SEZON = 2; break; // 3 - ЗИМА
		case 4: $SEZON = 3; break; // 4 - ВЕСНА/ОСЕНЬ
		default: $SEZON = 0; //0 - ВСЕ СЕЗОНЫ 
	}
?>
	<div class="sectionDescription">
		<?=$arResult['DESCRIPTION'][$SEZON]?>
	</div><?}?>