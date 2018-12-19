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
<div class="sub_cats sl_season">
<?
	$page = $APPLICATION->GetCurPage();
	$p = explode("/", $page);
	$path = "/".$p[1]."/" . $p[2] ."/" . $p[3] ."/";
	$count = count($p);

?>

<?foreach ($arResult['SECTIONS'] as &$arSection){
    $selected = '';
    if (strpos($APPLICATION->GetCurDir(),$arSection['CODE'])>0) $selected = 'class="active"';;?>
    	<a href="<?=$arSection['SECTION_PAGE_URL']?>" <?=$selected?>><?=$arSection['NAME']?></a>
<?}?>
</div>