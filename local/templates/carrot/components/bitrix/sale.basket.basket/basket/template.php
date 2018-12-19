<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if (!empty($_GET["ORDER_ID"])) {
	return;
}

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
);

$this->addExternalCss($templateData['TEMPLATE_THEME']);

$curPage = $arParams["PATH_TO_ORDER"] .'?'.$arParams["ACTION_VARIABLE"].'=';
$arUrls = array(
	"delete" => $curPage."delete&id=#ID#",
	"delay" => $curPage."delay&id=#ID#",
	"add" => $curPage."add&id=#ID#",
);

unset($curPage);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"],
	'EVENT_ONCHANGE_ON_START' => (!empty($arResult['EVENT_ONCHANGE_ON_START']) && $arResult['EVENT_ONCHANGE_ON_START'] === 'Y') ? 'Y' : 'N'
);
?>

<div class="basket">
	<script type="text/javascript">
		var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
	</script>

	<?
	$APPLICATION->AddHeadScript($templateFolder."/script.js");
	//if (!$USER->IsAdmin()) $APPLICATION->AddHeadScript($templateFolder."/script_1.js");

	if($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'TOP')
	{
		$APPLICATION->IncludeComponent(
			"bitrix:sale.gift.basket",
			".default",
			array(
				"SHOW_PRICE_COUNT" => 1,
				"PRODUCT_SUBSCRIPTION" => 'N',
				'PRODUCT_ID_VARIABLE' => 'id',
				"PARTIAL_PRODUCT_PROPERTIES" => 'N',
				"USE_PRODUCT_QUANTITY" => 'N',
				"ACTION_VARIABLE" => "actionGift",
				"ADD_PROPERTIES_TO_BASKET" => "Y",

				"BASKET_URL" => $APPLICATION->GetCurPage(),
				"APPLIED_DISCOUNT_LIST" => $arResult["APPLIED_DISCOUNT_LIST"],
				"FULL_DISCOUNT_LIST" => $arResult["FULL_DISCOUNT_LIST"],

				"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
				"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_SHOW_VALUE"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

				'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
				'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
				'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],
				'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
				'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
				'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
				'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
				'SHOW_NAME' => $arParams['GIFTS_SHOW_NAME'],
				'SHOW_IMAGE' => $arParams['GIFTS_SHOW_IMAGE'],
				'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
				'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
				'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
				'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
				'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

				"LINE_ELEMENT_COUNT" => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
			),
			false
		);
	}

	if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
	{
		?>
		<div id="warning_message">
			<?
			if (!empty($arResult["WARNING_MESSAGE"]) && is_array($arResult["WARNING_MESSAGE"]))
			{
				foreach ($arResult["WARNING_MESSAGE"] as $v)
					ShowError($v);
			}
			?>
		</div>
		<?

		$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
		$normalHidden = ($normalCount == 0) ? 'style="display:none;"' : '';

		$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
		$delayHidden = ($delayCount == 0) ? 'style="display:none;"' : '';

		$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
		$subscribeHidden = ($subscribeCount == 0) ? 'style="display:none;"' : '';

		$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
		$naHidden = ($naCount == 0) ? 'style="display:none;"' : '';

		?>
			<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form" onsubmit="return false;">
				<div id="basket_form_container" class="bx_ordercart <?=$templateData['TEMPLATE_CLASS']; ?>">
					<?
						include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items__.php");
					?>
				</div>

				<input type="hidden" name="BasketOrder" value="BasketOrder" />
				<input class="input-refresh-form" type="hidden" name="BasketRefresh" value="">
				<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
			</form>
		<?

		if($arParams['USE_GIFTS'] === 'Y' && $arParams['GIFTS_PLACE'] === 'BOTTOM')
		{
			?>
			<div style="margin-top: 35px;"><? $APPLICATION->IncludeComponent(
				"bitrix:sale.gift.basket",
				".default",
				array(
					"SHOW_PRICE_COUNT" => 1,
					"PRODUCT_SUBSCRIPTION" => 'N',
					'PRODUCT_ID_VARIABLE' => 'id',
					"PARTIAL_PRODUCT_PROPERTIES" => 'N',
					"USE_PRODUCT_QUANTITY" => 'N',
					"ACTION_VARIABLE" => "actionGift",
					"ADD_PROPERTIES_TO_BASKET" => "Y",

					"BASKET_URL" => $APPLICATION->GetCurPage(),
					"APPLIED_DISCOUNT_LIST" => $arResult["APPLIED_DISCOUNT_LIST"],
					"FULL_DISCOUNT_LIST" => $arResult["FULL_DISCOUNT_LIST"],

					"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_SHOW_VALUE"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

					'BLOCK_TITLE' => $arParams['GIFTS_BLOCK_TITLE'],
					'HIDE_BLOCK_TITLE' => $arParams['GIFTS_HIDE_BLOCK_TITLE'],
					'TEXT_LABEL_GIFT' => $arParams['GIFTS_TEXT_LABEL_GIFT'],
					'PRODUCT_QUANTITY_VARIABLE' => $arParams['GIFTS_PRODUCT_QUANTITY_VARIABLE'],
					'PRODUCT_PROPS_VARIABLE' => $arParams['GIFTS_PRODUCT_PROPS_VARIABLE'],
					'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
					'SHOW_NAME' => $arParams['GIFTS_SHOW_NAME'],
					'SHOW_IMAGE' => $arParams['GIFTS_SHOW_IMAGE'],
					'MESS_BTN_BUY' => $arParams['GIFTS_MESS_BTN_BUY'],
					'MESS_BTN_DETAIL' => $arParams['GIFTS_MESS_BTN_DETAIL'],
					'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
					'CONVERT_CURRENCY' => $arParams['GIFTS_CONVERT_CURRENCY'],
					'HIDE_NOT_AVAILABLE' => $arParams['GIFTS_HIDE_NOT_AVAILABLE'],

					"LINE_ELEMENT_COUNT" => $arParams['GIFTS_PAGE_ELEMENT_COUNT'],
				),
				false
			); ?>
			</div><?
		}
	}
	else
	{
	?>
		<div style="height: 300px;">
			<?= $arResult["ERROR_MESSAGE"] ?>
		</div>
	<?
		//ShowError($arResult["ERROR_MESSAGE"]);
	}
	?>
</div>
