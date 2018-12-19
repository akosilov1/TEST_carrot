<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<? 
$user = CUser::GetID();
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); 
?>
<div class="menu-wrapper">
<ul>
 <li><a href="/" class="home_link"></a></li>
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<li <?if($arItem["LINK"] == "/catalog/"){echo "class='catalog_dropdown'";}?>>
			<a href="<?=$arItem["LINK"]?>" class="selected"><?=$arItem["TEXT"]?></a>
			<?
				if($arItem["LINK"] == "/catalog/"){
			?>
				<?
					//if($user == 1){?>
						<div id="menu-catalog">
							<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"template2", 
	array(
		"ROOT_MENU_TYPE" => "left",
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "template2",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
						</div>	
					<? //} ?>		
				<? } ?>
		</li>
	<?else:?>
		<li <?if($arItem["LINK"] == "/catalog/"){echo "class='catalog_dropdown'";}?>>
			<a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
			<?
				if($arItem["LINK"] == "/catalog/"){
			?>
				<?
					//if($user == 1){?>
						<div id="menu-catalog">
							<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"template3", 
	array(
		"ROOT_MENU_TYPE" => "left",
		"MAX_LEVEL" => "4",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "template3",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
						</div>	
					<? //} ?>		
				<? } ?>			
		</li>
	<?endif?>
	
<?endforeach?>
</div>
</ul>
<?endif?>