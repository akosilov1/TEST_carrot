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

		/*$code = explode("/", $arItem["LINK"]);
		$key = count($code) - 2;
		$sect = $code[$key];
		$arFilter = Array('IBLOCK_ID'=>1, '=CODE'=>$sect, 'GLOBAL_ACTIVE'=>'Y'); 
		$db_list = CIBlockSection::GetList(Array("timestamp_x"=>"DESC"), $arFilter, false, Array("UF_VISIBLE")); 
		if($uf_value = $db_list->GetNext()): 
			$visible = $uf_value["UF_VISIBLE"]; //подменяем ссылку и используем её в дальнейшем 
		endif; */

?><div class="sub_cats sl_def">
<?foreach ($arResult['SECTIONS'] as &$arSection){
    /*$selected = '';
		$sect = $arSection['CODE'];
		$arFilter = Array('IBLOCK_ID'=>1, '=CODE'=>$sect, 'GLOBAL_ACTIVE'=>'Y'); 
		$db_list = CIBlockSection::GetList(Array("timestamp_x"=>"DESC"), $arFilter, false, Array("UF_VISIBLE")); 
		if($uf_value = $db_list->GetNext()): 
			$visible = $uf_value["UF_VISIBLE"]; //подменяем ссылку и используем её в дальнейшем 
		endif; 
		echo "asdasd ".$visible." sdfsdfsdfsd ".$arSection['CODE'];*/
    if (strpos($APPLICATION->GetCurDir(),$arSection['CODE'])>0) $selected = 'class="active"';;?>
		<?//if($visible == 1){?>
			<a href="<?=$arSection['SECTION_PAGE_URL']?>" <?=$selected?>><?=$arSection['NAME']?></a>
		<? //} ?>
<?}?>
    </div>