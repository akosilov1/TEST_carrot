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
					<?/*if(is_array($arItem['PROPERTIES']['SEZON']['VALUE'])){
						foreach ($arItem['PROPERTIES']['SEZON']['VALUE'] as $sezon) {
                        $sticker = '';
                        switch ($sezon)  {
                            case 'Лето':
                                $sticker = 'sticker1';
                                break;
                            case 'Зима':
                                $sticker = 'sticker2';
                                break;
                            case 'Осень':
                                $sticker = 'sticker3';
                                break;
                            case 'Весна':
                                $sticker = 'sticker4';
                                break;
                        }?>
                        <div class="sticker <?=$sticker?>"></div>
					<?}
					}else{
					switch ($arItem['PROPERTIES']['SEZON']['VALUE'])  {
                            case 'Лето':
                                $sticker = 'sticker1';
                                break;
                            case 'Зима':
                                $sticker = 'sticker2';
                                break;
                            case 'Осень':
                                $sticker = 'sticker3';
                                break;
                            case 'Весна':
                                $sticker = 'sticker4';
                                break;
                        }?>
                        <div class="sticker <?=$sticker?>"></div>
					<?}*/?>
                    <div class="thumb"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$thumbPicture['src']?>" alt=""></a></div>
                    <div class="name"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></div>
                    <div class="price left">
                        <?php if ($arItem['PRICES']['BASE']['DISCOUNT_DIFF']): ?>
                            <span class="old-price"><?= $arItem['PRICES']['BASE']['PRINT_VALUE_NOVAT'] ?></span>
                        <?php endif; ?>
                        
                        <?=$arItem['PRICES']['BASE']['PRINT_DISCOUNT_VALUE_NOVAT']?>
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
}