<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
/** @var CBitrixBasketComponent $component */

foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $itemKey => &$item) {
	$arProduct = CIBlockElement::GetList(array(),
		array('IBLOCK_ID' => 1, 'ID' => $item['PRODUCT_ID']),
		false,
		false,
		array('ID', 'NAME', 'DETAIL_PAGE_URL', 'PROPERTY_MATERIAL', 'DETAIL_PICTURE', 'PROPERTY_COMPLECT')
	)->Fetch();

	$item['PRODUCT'] = $arProduct;

	if ($item['DETAIL_PICTURE'] > 0) {
		$picture = CFile::ResizeImageGet(
			$item['DETAIL_PICTURE'],
			array('width' => 100, 'height' => 100),
			BX_RESIZE_IMAGE_PROPORTIONAL_ALT
		);

		$item['PICTURE'] = $picture['src'];
	}

	$item['GIFT_SELECTED'] = 'N';

	foreach ($item['PROPS'] as $propKey => &$prop) {
		if ($prop['NAME'] == 'Подарочная упаковка') {
			unset($prop);
			unset($arResult["ITEMS"]["AnDelCanBuy"][$itemKey]['PROPS'][$propKey]);

			$item['GIFT_SELECTED'] = 'Y';
			break;
		}
	}
}
foreach ($arResult["GRID"]["ROWS"] as $r_key => $row) {
	
	$arProduct = CIBlockElement::GetList(array(),
		array('IBLOCK_ID' => 1, 'ID' => $row['PRODUCT_ID']),
		false,
		false,
		array('PROPERTY_MATERIAL', 'PROPERTY_COMPLECT')
	)->Fetch();
	//echo "<!--".$row['PRODUCT_ID'];print_r($arProduct);echo "-->";
	//$arResult["GRID"]["ROWS"][$row['ID']]["PROPS"][] = $arProduct;

	if($arProduct['PROPERTY_COMPLECT_VALUE'] == "Y")
		$arResult["GRID"]["ROWS"][$row['ID']]['PROPERTY_COMPLECT_VALUE'] = "Y";
	if($arProduct['PROPERTY_MATERIAL_VALUE'] != "")
		$arResult["GRID"]["ROWS"][$row['ID']]['PROPERTY_MATERIAL_VALUE'] = $arProduct['PROPERTY_MATERIAL_VALUE'];
	# code...
}
//$arResult["GRID"]["ROWS"]["PROPS"][]