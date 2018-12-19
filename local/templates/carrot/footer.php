<!-- Start ВИДЖЕТЫ СОЦСЕТЕЙ -->
<h3 class="zagolovok clear">Подписывайтесь на нас в социальных сетях:</h3>
<div class="wrap" style="display:table"><div class="cont" style="display:table">
<!-- <div class="all center" style=" display: table-cell;margin: 0 auto;text-align: center;"><br /> -->
<div class="raw center"><iframe src="//widget.stapico.ru/?q=ilove_carrot&s=95&w=2&h=3&b=0&p=5&title=%D0%9C%D1%8B%20%D0%B2%20instargram&effect=2" allowtransparency="true" frameborder="0" scrolling="no" style="border:none;overflow:hidden;width:240px;height:400px; border: 1px solid #c3c3c3; border-radius: 5px;"></iframe> </div><!--<div class="clear_right inline"></div>-->
<div class="raw center">

<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 0, width: "220", height: "400", color1: 'FFFFFF', color2: '000000', color3: '5E81A8'}, 24316022);
</script></div><!--<div class="clear_right inline"></div> -->
<div class="raw center">
<div class="fb-page" data-href="https://www.facebook.com/ilovecarrot.ru/" data-tabs="timeline" data-width="220" data-height="400" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/ilovecarrot.ru/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/ilovecarrot.ru/">Carrot</a></blockquote></div>
</div>
<!-- </div> -->
</div></div>
<div class="clear"></div><br />
<!-- End ВИДЖЕТЫ СОЦСЕТЕЙ -->

</div>
<!-- End Основная часть -->
</div>


<!-- Подвал -->
<footer>
    <div class="cont">
        <div class="left_col left">
            <div class="copyright"><?$APPLICATION->IncludeComponent('bitrix:main.include','',
                    array(
                        'AREA_FILE_SHOW'=>'file',
                        'PATH'=>'/include/area/copyright.php'
                    ));?></div>
            <?$APPLICATION->IncludeComponent(
	"bxsupport:sociallink", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"FACEBOOK" => "https://www.facebook.com/ilovecarrot.ru/",
		"TWITTER" => "https://ok.ru/group/54108949971186",
		"VKONTAKTE" => "https://vk.com/ilovecarrot",
		"ODNOKLASSNIKI" => "",
		"GOOGLE_PLUS" => "",
		"LIVEJOURNAL" => "",
		"INSTAGRAM" => "https://www.instagram.com/ilove_carrot/"
	),
	false
);?>
		<div class="header-enter-form <?=($USER->IsAuthorized())?"authorized":"";?>">
            <?
            global $USER;
            if($USER->IsAuthorized()):?>
            <p>Здравствуйте,&nbsp;<a href="/personal/cabinet/" title="Кабинет пользователя"><?=$USER->GetFirstName();?></a>
                <br/>
                <a class=".logout-btn" href="?logout=yes" title="Выйти">Выйти</a>
            </p>
            <?else:?>
            <button>Вход для оптовых клиентов</button>
            <?$APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
                 "REGISTER_URL" => "/personal/register.php",
                 "FORGOT_PASSWORD_URL" => "",
                 "PROFILE_URL" => "/personal/",
                 "SHOW_ERRORS" => "Y" 
                 )
            );?>
            <?endif?>
        </div>
        </div>

        <div class="links left">
            <div class="title"><a href="/o-nashey-produktsii/">О нашей продукции</a></div>
            <?
            $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"template1", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "bottom",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "template1",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
        </div>

        <div class="links left">
            <div class="title">Условия заказа</div>
            <?
            $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"template1", 
	array(
		"ROOT_MENU_TYPE" => "bottom2",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "bottom2",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "template1",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
        </div>

        <div class="adres right">
            <div class="title">Адрес самовывоза:</div>
            <div><?$APPLICATION->IncludeComponent('bitrix:main.include','',
                    array(
                        'AREA_FILE_SHOW'=>'file',
                        'PATH'=>'/include/area/address_bot.php'
                    ));?></div>
            <div class="in_map"><a href="/kontakty/">Карта проезда</a></div>
        </div>

        <div class="contacts right">
            <div class="title">Контакты</div>
            <div class="phone"><?$APPLICATION->IncludeComponent('bitrix:main.include','',
                    array(
                        'AREA_FILE_SHOW'=>'file',
                        'PATH'=>'/include/area/phone_bot.php'
                    ));?></div>
            <div class="email"><?$APPLICATION->IncludeComponent('bitrix:main.include','',
                    array(
                        'AREA_FILE_SHOW'=>'file',
                        'PATH'=>'/include/area/email_bot.php'
                    ));?></div>
        </div>
        <div class="clear"></div>
    </div>
</footer>
<!-- End Подвал -->

<!-- Подключение javascript файлов -->
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery-migrate.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/bxslider.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/fancybox.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/owl.carousel.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/scripts.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/phone_mask/jquery.inputmask.bundle.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/phone_mask/jquery.inputmask-multi.min.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/js/bitrix.js"></script>

</body>
</html>