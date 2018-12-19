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
<div class="main_slider">
    <ul>
<?foreach($arResult["ITEMS"] as $arItem):?>
    <li>
        <img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="">
        <div class="cont" style="position:absolute">
            <div class="info">
				
                <div class="title"><?=$arItem['PROPERTIES']['TEXT_1']['VALUE']?></div>
				
				<?if ($arItem['PROPERTIES']['TEXT_1']['VALUE'] || $arItem['PROPERTIES']['TEXT_2']['VALUE']) { ?>
                <div class="title2"><?=$arItem['PROPERTIES']['TEXT_2']['VALUE']?></div>
				<? } ?>
            </div>
        </div>
    </li>
<?endforeach;?>
</ul>
</div>
