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
CModule::IncludeModule('iblock');
$APPLICATION->SetTitle("О нашей продукции");
$title = $APPLICATION->GetTitle(true);
$APPLICATION->SetTitle($title);
?>

<div class="product_info" itemscope itemtype="http://schema.org/Product">
    <div class="images left">
        <div class="big">
            <ul>
                <li><a href="<?=$arResult['DETAIL_PICTURE']['SRC']?>" class="fancy_img" data-fancybox-group="gallery"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt=""></a></li>
                <?foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $idPhoto) {
                    $fPic = CFile::GetFileArray($idPhoto);
                    ?>
                    <li><a href="<?=$fPic['SRC']?>" class="fancy_img" data-fancybox-group="gallery"><img src="<?=$fPic['SRC']?>" alt=""></a></li>
                <?}?>
            </ul>
        </div>

        <div class="thumbs" id="bx-pager">
            <ul>
                <li><a href="" data-slide-index="0"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="" itemprop="image" ></a></li>
                <?$iPic = 1;?>
                <?foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $idPhoto) {
                    $fPic = CFile::GetFileArray($idPhoto);
                    ?>
                    <li><a href="" data-slide-index="<?=$iPic?>"><img src="<?=$fPic['SRC']?>" alt=""></a></li>
                <?$iPic++;}?>
            </ul>
        </div>
    </div>

    <div class="info right">
        <h1 itemprop="name"><?=$arResult['NAME']?></h1>

        <div class="features left">
            <?if (!empty($arResult['PROPERTIES']['MATERIAL']['VALUE'])) {?>
            <div><b>Материал:</b> <?=$arResult['PROPERTIES']['MATERIAL']['VALUE']?></div>
            <?}?>
            <?if (is_array($arResult['PROPERTIES']['SIZE']['VALUE']) && count($arResult['PROPERTIES']['SIZE']['VALUE'])>0) {
                $i = 1;
                ?>
            <div>
                <b>Размер:</b>
                <?foreach ($arResult['PROPERTIES']['SIZE']['VALUE'] as $key=>$val) {?>
                <div class="item">
                    <input type="radio" name="size_group" <?if ($i==1) echo 'checked';?> value="<?=$arResult['PROPERTIES']['SIZE']['VALUE_ENUM'][$key]?>" id="size_radio<?=$val?>">
                    <label for="size_radio<?=$val?>"><?=$arResult['PROPERTIES']['SIZE']['VALUE_ENUM'][$key]?></label>
                </div>
<?$i++;}?>
            </div>
            <?}?>

            <?if (is_array($arResult['PROPERTIES']['SEZON']['VALUE']) && count($arResult['PROPERTIES']['SEZON']['VALUE'])>0) {
                $i = 1;
                ?>
                <div>
                    <b>Сезон:</b>
                    <? foreach ($arResult['PROPERTIES']['SEZON']['VALUE'] as $key => $val) { ?>
                        <div class="item">
                            <input type="radio" name="season_group" <? if ($i == 1) echo 'checked'; ?>
                                   value="<?= $arResult['PROPERTIES']['SEZON']['VALUE_ENUM'][$key] ?>"
                                   id="size_radio<?= $val ?>">
                            <label
                                for="size_radio<?= $val ?>"><?= $arResult['PROPERTIES']['SEZON']['VALUE_ENUM'][$key] ?></label>
                        </div>
                        <? $i++;
                    } ?>
                </div>
            <? } ?>
        </div>

        <div class="socials right">
            <a href="https://new.vk.com/ilovecarrot" target="_blank" class="vk"></a>
            <a href="https://www.facebook.com/ilovecarrot.ru/" target="_blank" class="fb"></a>
            <a href="https://www.instagram.com/ilove_carrot/" target="_blank" class="inst"></a>
            <a href="https://ok.ru/group/54108949971186" target="_blank" class="twitter"></a>
        </div>
        <div class="clear"></div>

        <div class="price left" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <meta itemprop="price" content="<?=$arResult['PRICES']['BASE']['PRINT_DISCOUNT_VALUE_NOVAT'] ?>">
            <meta itemprop="priceCurrency" content="RUB">
            <?php if ($arResult['PRICES']['BASE']['DISCOUNT_DIFF']): ?>
                <span class="old-price"><?= $arResult['PRICES']['BASE']['PRINT_VALUE_NOVAT'] ?></span>
            <?php endif; ?>

            <b><?= $arResult['PRICES']['BASE']['PRINT_DISCOUNT_VALUE_NOVAT'] ?></b>
        </div>

        <a href="javascript:void(0);" onclick="addBasketElement();" class="buy_link left"><img src="<?=SITE_TEMPLATE_PATH?>/images/buy_link_icon.png" alt="">Добавить в корзину</a>
        <a href="javascript:void(0);" onclick="addBasketOneClick();" class="quike_buy left">купить в один клик</a>
        <!-- <a href="javascript:void(0);" onclick="addBasketOneClick();"  class="quike_buy left">купить в один клик</a>-->
        <div class="clear"></div>

        <div class="description">
            <div class="title">Описание:</div>
        <div itemprop="description"><?=$arResult['DETAIL_TEXT']?></div>
        </div>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    function addBasketElement() {
        var sizeVal = $('input[name=size_group]:checked').val();
        var seasonVal = $('input[name=season_group]:checked').val();
        if(yaCounter45214521) yaCounter45214521.reachGoal("ADD_TO_BASKET");
        $.fancybox({
            href: '/ajax/forms/addbasket.php?id=<?=$arResult['ID']?>&type=express&size='+encodeURIComponent(sizeVal) + '&season='+encodeURIComponent(seasonVal),
            type: 'ajax'
        }).open();
    }

    function addBasketOneClick() {
        var sizeVal = $('input[name=size_group]:checked').val();
        var seasonVal = $('input[name=season_group]:checked').val();
        $.fancybox({
            href: '/ajax/forms/click.php?id=<?=$arResult['ID']?>&size='+encodeURIComponent(sizeVal) + '&season='+encodeURIComponent(seasonVal),
            type: 'ajax',
        }).open();
    }
</script>




<?
if (is_array($arResult['PROPERTIES']['SIMILAR']['VALUE']) && count($arResult['PROPERTIES']['SIMILAR']['VALUE'])>0) {
    $rsElements = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>1,'ID'=>$arResult['PROPERTIES']['SIMILAR']['VALUE'], 'ACTIVE'=>'Y','ACTIVE_DATE'=>'Y'),false,false,
        array('NAME','ID','PROPERTY_SEZON','CATALOG_GROUP_1','DETAIL_PAGE_URL','DETAIL_PICTURE'));

    $arElements = array();
    while ($arItem = $rsElements->GetNext()) {
        $arElements[] = $arItem;
    }

    $uniqueIds = array();
    foreach ($arElements as $key => $arItem) {
        if (!in_array($arItem['ID'], $uniqueIds)) {
            $uniqueIds[] = $arItem['ID'];
        } else {
            unset($arElements[$key]);
        }
    }
    ?>
    <div class="products">
        <div class="block_title color2"><div>идеально подходят</div></div>

        <div class="carousel owl-carousel">
          
                <?foreach ($arElements as $arItem) {
                    $thumbPicture = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'],array('width'=>250,'height'=>250),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                    CModule::IncludeModule("sale");
                    $arDiscounts = CCatalogDiscount::GetDiscountByProduct($arItem['ID'], $USER->GetUserGroupArray(), "N", 1, SITE_ID);
                    $discountPrice = CCatalogProduct::CountPriceWithDiscount($arItem["CATALOG_PRICE_1"], $arItem["CATALOG_CURRENCY_1"], $arDiscounts);
                    ?>
                    
                        <div class="product">
                            <div class="thumb"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$thumbPicture['src']?>" alt=""></a></div>
                            <div class="name"><a href="<?=$arItem['NAME']?>"><?=$arItem['NAME']?></a></div>
                            <div class="price left">
                                <?php if ($arDiscounts): ?>
                                    <div class="old-price"><?= CurrencyFormat($arItem['CATALOG_PRICE_1'], $arItem['CATALOG_CURRENCY_1']) ?></div>
                                <?php endif; ?>

                                <?= $discountPrice ?> руб.
                            </div>
                            <a  id="<? echo $arItemIDs['BUY_LINK']; ?>" href="/ajax/forms/addbasket.php?id=<?=$arItem['ID']?>" class="fancybox.ajax bx_add_basket buy_link right"><span>в корзину</span></a>
                        </div>
                  
                <?}?>
          
        </div>
    </div>
<?}?>


<?
if (is_array($arResult['PROPERTIES']['BESTSELLER']['VALUE']) && count($arResult['PROPERTIES']['BESTSELLER']['VALUE'])>0) {
    $rsElements = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 1, 'ID' => $arResult['PROPERTIES']['BESTSELLER']['VALUE'], 'ACTIVE'=>'Y','ACTIVE_DATE'=>'Y'), false, false,
        array('NAME', 'ID', 'PROPERTY_SEZON', 'CATALOG_GROUP_1', 'DETAIL_PAGE_URL', 'DETAIL_PICTURE'));

    $arElements = array();
    while ($arItem = $rsElements->GetNext()) {
        $arElements[] = $arItem;
    }

    $uniqueIds = array();
    foreach ($arElements as $key => $arItem) {
        if (!in_array($arItem['ID'], $uniqueIds)) {
            $uniqueIds[] = $arItem['ID'];
        } else {
            unset($arElements[$key]);
        }
    }
    ?>
    <div class="products">
        <div class="block_title color3"><div>Бестстселлеры</div></div>

        <div class="carousel owl-carousel">

                <? foreach ($arElements as $arItem) {
                    $thumbPicture = CFile::ResizeImageGet($arItem['DETAIL_PICTURE'],array('width'=>250,'height'=>250),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                    CModule::IncludeModule("sale");
                    $arDiscounts = CCatalogDiscount::GetDiscountByProduct($arItem['ID'], $USER->GetUserGroupArray(), "N", 1, SITE_ID);
                    $discountPrice = CCatalogProduct::CountPriceWithDiscount($arItem["CATALOG_PRICE_1"], $arItem["CATALOG_CURRENCY_1"], $arDiscounts);
                    ?>
                        <div class="product">
                            <div class="thumb"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img src="<?=$thumbPicture['src']?>" alt=""></a></div>
                            <div class="name"><a href="<?=$arItem['NAME']?>"><?=$arItem['NAME']?></a></div>
                            <div class="price left">
                                <?php if ($arDiscounts): ?>
                                    <div class="old-price"><?= CurrencyFormat($arItem['CATALOG_PRICE_1'], $arItem['CATALOG_CURRENCY_1']) ?></div>
                                <?php endif; ?>

                                <?= $discountPrice ?> руб.
                            </div>
                            <a  id="<? echo $arItemIDs['BUY_LINK']; ?>" href="/ajax/forms/addbasket.php?id=<?=$arItem['ID']?>" class="fancybox.ajax bx_add_basket buy_link right"><span>в корзину</span></a>
                        </div>
                <?}?>
        </div>
    </div>
<?}?>