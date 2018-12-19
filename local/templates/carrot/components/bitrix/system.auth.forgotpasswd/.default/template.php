<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?
$this->addExternalCss(SITE_TEMPLATE_PATH."/css/bootstrap.min.css");


?>
<p><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></p>
<div class=" col-md-4 offset-4">
<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
	<input type="hidden" name="AUTH_FORM" value="Y">
	<input type="hidden" name="TYPE" value="SEND_PWD">


<table class="data-table bx-forgotpass-table">
	<thead>
		<tr> 
			<td colspan="2"><b><?=GetMessage("AUTH_GET_CHECK_STRING")?></b></td>
		</tr>
	</thead>
	<tbody>
		<?/*tr>
			<td><?=GetMessage("AUTH_LOGIN")?></td>
			<td><input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" class="form-control" />
			</td>
		</tr>
        <tr>
            <td colspan="2" class="text-center"><?=GetMessage("AUTH_OR")?></td>
        </tr*/?>
		<tr> 
			<td><?=GetMessage("AUTH_EMAIL")?></td>
			<td>
				<input type="text" name="USER_EMAIL" maxlength="255" class="form-control"/>
			</td>
		</tr>
	<?if($arResult["USE_CAPTCHA"]):?>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			</td>
		</tr>
		<tr>
			<td><?echo GetMessage("system_auth_captcha")?></td>
			<td><input type="text" name="captcha_word" maxlength="50" value=""  class="form-control"/></td>
		</tr>
	<?endif?>
	</tbody>
	<tfoot>
		<tr>
            <td colspan="2" class="text-center">
                <?ShowMessage($arParams["~AUTH_RESULT"]);?>
            </td>
        </tr>
        <tr>
			<td colspan="2" class="text-center">
				<input type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" class="carrot-btn"/>
			</td>
		</tr>
	</tfoot>
</table>
<p class="text-center">
<a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a>
</p> 
</form>
</div>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
