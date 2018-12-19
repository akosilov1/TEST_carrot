<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!function_exists('PrintPropsForm'))
{
	function PrintPropsForm($arSource=Array(), $locationTemplate = ".default")
{

	if (!empty($arSource))
	{
		foreach($arSource as $arProperties)
		{?>
				<tr>
					<td colspan="2">
						<b><?= $arProperties["GROUP_NAME"] ?></b>
					</td>
				</tr>
			<tr>
				<td align="right" valign="top" width="25%">
					
					<?
					if($arProperties["REQUIED_FORMATED"]=="Y")
					{
						?><span class="sof-req">*</span><?
					}
					?>
					<?= $arProperties["NAME"] ?>:
				</td>
				<td class="props">
					<?
					if($arProperties["TYPE"] == "CHECKBOX")
					{
						?>
						
						<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
						<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
						<?
					}
					elseif($arProperties["TYPE"] == "TEXT")
					{
						if ($arProperties["IS_ZIP"] == "Y")
						{
						?>
							<input type="hidden" name="CHANGE_ZIP" id="change_zip_val" value="" />
							<input onChange="fChangeZip();" type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">
							<script>
								function fChangeZip () 
								{
									document.getElementById("change_zip_val").value = "Y";
									submitForm();
								}
							</script>
						<?
						}
						else
						{
						?>
							<input type="text" maxlength="250" size="<?=$arProperties["SIZE1"]?>" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>">
						<?
						}
					}
					elseif($arProperties["TYPE"] == "SELECT")
					{
						?>
						<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
						}
						?>
						</select>
						<?
					}
					elseif ($arProperties["TYPE"] == "MULTISELECT")
					{
						?>
						<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
							<?
						}
						?>
						</select>
						<?
					}
					elseif ($arProperties["TYPE"] == "TEXTAREA")
					{
						?>
						<textarea rows="<?=$arProperties["SIZE2"]?>" cols="<?=$arProperties["SIZE1"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea>
						<?
					}
					elseif ($arProperties["TYPE"] == "LOCATION")
					{
						$value = 0;
						foreach ($arProperties["VARIANTS"] as $arVariant) 
						{
							if ($arVariant["SELECTED"] == "Y") 
							{
								$value = $arVariant["ID"]; 
								break;
							}
						}

						CSaleLocation::proxySaleAjaxLocationsComponent(
							array(
								"AJAX_CALL" => "N",
								"COUNTRY_INPUT_NAME" => "COUNTRY_".$arProperties["FIELD_NAME"],
								"REGION_INPUT_NAME" => "REGION_".$arProperties["FIELD_NAME"],
								"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
								"CITY_OUT_LOCATION" => "Y",
								"LOCATION_VALUE" => $value,
								"ORDER_PROPS_ID" => $arProperties["ID"],
								"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
								"SIZE1" => $arProperties["SIZE1"],
							),
							array(
								"ID" => $value,
								"CODE" => "",

								"SHOW_DEFAULT_LOCATIONS" => "Y",

								"INITIALIZE_BY_GLOBAL_EVENT" => 'sboa-init-loc-selector',
								"GLOBAL_EVENT_SCOPE" => 'window',

								"JS_CALLBACK" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitFormProxy()" : "",
								"DISABLE_KEYBOARD_INPUT" => "Y",
								"PRECACHE_LAST_LEVEL" => "Y",
								"PRESELECT_TREE_TRUNK" => "Y",
								"SUPPRESS_ERRORS" => "Y"
							),
							$locationTemplate,
							true,
							'location-block-wrapper'
						);
					}
					elseif ($arProperties["TYPE"] == "RADIO")
					{
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<input type="radio" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>" value="<?=$arVariants["VALUE"]?>"<?if($arVariants["CHECKED"] == "Y") echo " checked";?>> <label for="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>"><?=$arVariants["NAME"]?></label><br />
							<?
						}
					}
					else if ($arProperties["TYPE"] == "DATE")
					{
						global $APPLICATION;

						$APPLICATION->IncludeComponent('bitrix:main.calendar', '', array(
							'SHOW_INPUT' => 'Y',
							'INPUT_NAME' => "ORDER_PROP_".$arProperties["ID"],
							'INPUT_VALUE' => $arProperties["VALUE"],
							'SHOW_TIME' => 'N'
						), null, array('HIDE_ICONS' => 'N'));
					}

					if (strlen($arProperties["DESCRIPTION"]) > 0)
					{
						?><br /><small><?echo $arProperties["DESCRIPTION"] ?></small><?
					}
					?>
					
				</td>
			</tr>
			<?
		}
		?>
		<?
		return true;
	}
	return false;
}
}
?>

<div class="checkout">
    <div class="title">Информация для оформления и доставки заказа</div>

   <?
   foreach ($arResult["ORDER_PROPS"]["USER_PROPS_Y"] as $prop) {
       $arProps[$prop['PROPS_GROUP_ID']][] = $prop;
       $arGroup[$prop['PROPS_GROUP_ID']] = $prop['GROUP_NAME'];
   }
   foreach ($arResult["ORDER_PROPS"]["USER_PROPS_N"] as $prop) {
       $arProps[$prop['PROPS_GROUP_ID']][] = $prop;
       $arGroup[$prop['PROPS_GROUP_ID']] = $prop['GROUP_NAME'];
   }
   ?>

    <?$pos = 'left';?>
    <?arsort($arGroup);?>
    <?foreach ($arGroup as $id=>$group){?>
    <div class="<?=$pos?>">
        <div class="title"><?=$group?><?if ($id == 1){?> <div class="exp right">Мы никому их не передадим и не рассылаем спам.</div><?}?></div>
        <?foreach ($arProps[$id] as $prop){?>

            <?if ($prop['CODE'] == 'city') {?>
                <div class="line">
                    <div class="name left">Страна, Город*</div>

                    <div class="city right">
                        <input type="radio" name="citycheck" checked id="citycheck1" onclick="changeCity('citycheck1');">
                        <label for="citycheck1" onclick="changeCity('citycheck1');">Москва</label>

                        <input type="radio" name="citycheck" id="citycheck2" onclick="changeCity('citycheck2');">
                        <label for="citycheck2"onclick="changeCity('citycheck2');">Другой город</label>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="line" id="otherCity" style="display: none;">
                    <div class="name left">&nbsp;</div>
                    <input type="text" name="<?=$prop["FIELD_NAME"]?>" id="<?=$prop["FIELD_NAME"]?>" value="<?=$prop["VALUE"]?>" class="input">
                </div>
                <script type="text/javascript">
                   function changeCity(t) {
                       if (t == 'citycheck2') {
                            $("#otherCity").show();
                           $("#<?=$prop["FIELD_NAME"]?>").val("");
                       } else {
                           $("#otherCity").hide();
                           $("#<?=$prop["FIELD_NAME"]?>").val("<?=$prop["DEFAULT_VALUE"]?>");
                       }
                       return false;
                   }
                </script>
                <?} else {?>
					<div class="line">
						<div class="name left"><?=$prop['NAME']?> <?if ($prop['REQUIED'] == 'Y'){?>*<?}?></div>

						<?php if ($prop['ID'] == '2'): ?>
								<div class="phone_mask_mode">
									<input type="radio" name="mode" id="is_world" value="world" checked>
									<label for="is_world">Страны мира</label>

									<input type="radio" name="mode" id="is_russia" value="ru">
									<label for="is_russia">Города России</label>

									<input type="text" name="<?= $prop["FIELD_NAME"] ?>" id="<?= $prop["FIELD_NAME"] ?>"
										   value="7<?= $prop["VALUE"] ?>" class="input">
								</div>
						<?php else: ?>
							<input type="text" name="<?=$prop["FIELD_NAME"]?>" id="<?=$prop["FIELD_NAME"]?>" value="<?=$prop["VALUE"]?>" class="input">
						<?php endif; ?>
					</div>
                <?}?>
        <?}?>
        <?if ($id == 2){?>
            <div class="name left">Примечание</div>
            <textarea rows="4" cols="40" name="ORDER_DESCRIPTION"><?=$arResult["ORDER_DESCRIPTION"]?></textarea>
        <?}?>
        </div>
    <?
    if ($pos == 'left') $pos = 'right';
    }?>

        <div class="clear"></div>

        <div class="left">
            <div class="title">Способ доставки</div>
            <div class="delivery_exp">Почта России</div>
            <input type="hidden" name="DELIVERY_ID" id="DELIVERY_ID" value="1">

            <?  foreach($arResult["DELIVERY"] as $val) {?>
                    <input type="radio" name="DELIVERY_ID_tmp" id="DELIVERY_ID_tmp" value="<?=$val["ID"]?>" <?if ($val["CHECKED"]=="Y") echo " checked";?>>
            <?}?>

        </div>

        <div class="right">
            <div class="title">Способ оплаты</div>

            <?

            foreach($arResult["PAYSYSTEM"] as $val)
            {
                if (empty($val['ID'])) continue;
                ?>
                <div class="line">
                    <input type="radio" name="PAYSYSTEM_ID" id="PAYSYSTEM_ID_<?=$val["ID"]?>" value="<?=$val["ID"]?>" <?if ($val["CHECKED"]=="Y") echo " checked";?> >
                    <label for="PAYSYSTEM_ID_<?=$val["ID"]?>"><?=$val["NAME"]?></label>
                </div>
            <?

            }
            ?>
        </div>
        <div class="clear"></div>

    <div class="order_submit submit"><input type="submit" class="submit_btn" value="ОФОРМИТь ЗАКАЗ" name="BasketOrder" id="basketOrderButton2" ></div>

</div>