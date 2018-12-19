<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Sale\DiscountCouponsManager;
if (!empty($arResult["ERROR_MESSAGE"]))
	ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;
?>
<!--<pre><? //print_r($arResult)?></pre>-->
<?php
if (count($arResult["ITEMS"]["AnDelCanBuy"]) <= 0) {
	echo GetMessage("SALE_NO_ITEMS");
}
?>

<div class="cart_info bx_ordercart bx_<?=$arParams['TEMPLATE_THEME']?>">
	<table>
		<thead>
			<tr>
				<th></th>
				<th><?= GetMessage("SALE_NAME_COLUMN") ?></th>
				<th><?= GetMessage("SALE_PRICE_COLUMN") ?></th>
				<th><?= GetMessage("SALE_QUANTITY_COLUMN") ?></th>
				<th><?= GetMessage("SALE_TOTAL_COLUMN") ?></th>
				<th><?= GetMessage("SALE_DELETE_COLUMN") ?></th>
			</tr>
		</thead>

		<?php foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $item) : ?>
			<tr>
				<td class="image">
					<div class="img">
						<a href="<?= $item["DETAIL_PAGE_URL"] ?>"><img src="<?= $item['PICTURE'] ?>" alt=""></a>
					</div>
				</td>
				<td class="info">
					<div class="name"><a href="<?= $item["DETAIL_PAGE_URL"] ?>"><?= $item["NAME"] ?></a></div>
					<pre> </pre>
					<div class="features">
						<?php if (!empty($item['PRODUCT']['PROPERTY_MATERIAL_VALUE'])): ?>
							<div><b><?= GetMessage("SALE_MATERIAL_PROPERTY") ?>:</b> <?= $item['PRODUCT']['PROPERTY_MATERIAL_VALUE'] ?></div>
						<?php endif; ?>

						<?php foreach ($item['PROPS'] as $prop): ?>
							<div><b><?= $prop['NAME'] ?>:</b> <?= $prop['VALUE'] ?></div>
						<?php endforeach; ?>
					</div>

					<? if (!empty($item['PRODUCT']['PROPERTY_COMPLECT_VALUE'])) { ?>
						<div class="gift">
							<input type="checkbox" value="Y"
								   name="gift_check[<?= $item['ID'] ?>]" <? if ($item['GIFT_SELECTED'] == 'Y') echo 'checked'; ?>
								   data-need="<?= $item['GIFT_SELECTED'] ?>" data-id="<?= $item['ID'] ?>"
								   id="gift_check<?= $item['ID'] ?>">
							<label for="gift_check<?= $item['ID'] ?>"><a href="/podarochnaya-upakovka/"><?= GetMessage("SALE_FREE_GIFT_WRAP") ?></a></label>
						</div>
					<? } ?>
				</td>
				<td class="price">
					<?= $item["PRICE_FORMATED"]; ?>
				</td>
				<td class="amount cart-item-quantity">
					<a href="#" class="minus"></a>
					<input type="text" name="QUANTITY_<?= $item["ID"] ?>"
						   value="<?= $item["QUANTITY"] ?>" data-minimum="1" data-maximum="999" maxlength="3">
					<a href="#" class="plus"></a>
				</td>
				<td class="price">
					<?= $item["SUM"]; ?>
				</td>
				<td class="delete">
					<a href="<?= str_replace("#ID#", $item["ID"], $arUrls["delete"]) ?>"></a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
	<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
	<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
	<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
	<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />
	<input type="hidden" id="auto_calculation" value="<?=($arParams["AUTO_CALCULATION"] == "N") ? "N" : "Y"?>" />
<? if ($USER->IsAdmin()):?>
<div class="bx_ordercart_order_pay">
<div class="bx_ordercart_order_pay_left" id="coupons_block">
	<?
		if ($arParams["HIDE_COUPON"] != "Y")
		{
		?>
			<div class="bx_ordercart_coupon">
				<span><?=GetMessage("STB_COUPON_PROMT")?></span><input type="text" id="coupon" name="COUPON" value="" onchange="enterCoupon();">&nbsp;<a class="bx_bt_button bx_big" href="javascript:void(0)" onclick="enterCoupon();" title="<?=GetMessage('SALE_COUPON_APPLY_TITLE'); ?>"><?=GetMessage('SALE_COUPON_APPLY'); ?></a>
			</div><?
				if (!empty($arResult['COUPON_LIST']))
				{
					foreach ($arResult['COUPON_LIST'] as $oneCoupon)
					{
						$couponClass = 'disabled';
						switch ($oneCoupon['STATUS'])
						{
							case DiscountCouponsManager::STATUS_NOT_FOUND:
							case DiscountCouponsManager::STATUS_FREEZE:
								$couponClass = 'bad';
								break;
							case DiscountCouponsManager::STATUS_APPLYED:
								$couponClass = 'good';
								break;
						}
						?>
						<div class="bx_ordercart_coupon">
							<input disabled readonly type="text" name="OLD_COUPON[]" value="<?=htmlspecialcharsbx($oneCoupon['COUPON']);?>" class="<? echo $couponClass; ?>">
								<span class="<? echo $couponClass; ?>" data-coupon="<? echo htmlspecialcharsbx($oneCoupon['COUPON']); ?>"></span>
							<div class="bx_ordercart_coupon_notes"><?
							if (isset($oneCoupon['CHECK_CODE_TEXT']))
							{
								echo (is_array($oneCoupon['CHECK_CODE_TEXT']) ? implode('<br>', $oneCoupon['CHECK_CODE_TEXT']) : $oneCoupon['CHECK_CODE_TEXT']);
							}
							?>
								
							</div>
						</div><?
					}
					unset($couponClass, $oneCoupon);
				}
		}
		else
		{
			?>&nbsp;<?
		}?>
</div>
</div>
<?endif;?>
	<div class="cart_total">
		<div class="total_price">
			<?= GetMessage("SALE_PRODUCTS_TO") ?>
			<div class="price"><?= $arResult["allSum_FORMATED"] ?></div>
		</div>

		<div class="total">
			<?= GetMessage("SALE_TOTAL") ?>
			<div class="price"><?= $arResult["allSum_FORMATED"] ?></div>
			<div class="exp">
				<div><?= GetMessage("SALE_WITHOUT_DELIVERY") ?></div>
			</div>
		</div>
	</div>
</div>