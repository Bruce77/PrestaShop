<?php
/*
* 2007-2011 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 7048 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

// P3P Policies (http://www.w3.org/TR/2002/REC-P3P-20020416/#compact_policies)
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$iso.'" lang="'.$iso.'">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="NOFOLLOW, NOINDEX" />
		<link type="text/css" rel="stylesheet" href="'._PS_JS_DIR_.'jquery/datepicker/datepicker.css" />
		<link type="text/css" rel="stylesheet" href="'._PS_CSS_DIR_.'admin.css" />
		<link type="text/css" rel="stylesheet" href="'._PS_CSS_DIR_.'jquery.cluetip.css" />
		<link type="text/css" rel="stylesheet" href="themes/'.Context::getContext()->employee->bo_theme.'/admin.css" />
		<title>PrestaShop&trade; - '.translate('Administration panel').'</title>
		<script type="text/javascript">
			var helpboxes = '.Configuration::get('PS_HELPBOX').';
			var roundMode = '.Configuration::get('PS_PRICE_ROUND_MODE').';
		</script>
		<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/plugins/jquery.hoverIntent.js"></script>
		<script type="text/javascript" src="'._PS_JS_DIR_.'jquery/plugins/cluetip/jquery.cluetip.js"></script>
		<script type="text/javascript" src="'._PS_JS_DIR_.'admin.js"></script>
		<script type="text/javascript" src="'._PS_JS_DIR_.'toggle.js"></script>
		<script type="text/javascript" src="'._PS_JS_DIR_.'tools.js"></script>
		<script type="text/javascript" src="'._PS_JS_DIR_.'ajax.js"></script>
		<link rel="shortcut icon" href="'._PS_IMG_.'favicon.ico" />
		'.Module::hookExec('backOfficeHeader').'
		<!--[if IE]>
		<link type="text/css" rel="stylesheet" href="'._PS_CSS_DIR_.'admin-ie.css" />
		<![endif]-->
		<style type="text/css">
			div#header_infos, div#header_infos a#header_shopname, div#header_infos a#header_logout, div#header_infos a#header_foaccess {
				color:'.(Tools::getBrightness(empty(Context::getContext()->employee->bo_color) ? '#FFFFFF' : Context::getContext()->employee->bo_color) < 128 ? 'white' : '#383838').'
			}
		</style>
		<script type="text/javascript">
		function getPush()
		{
			$.post("ajax.php",{"getNotifications" : "1"}, function(data) {
				if (data)
				{
					json = jQuery.parseJSON(data);

					// Add orders notifications to the list
					html = "";
					nb_notifs = 0;
					$.each(json.order, function(property, value) {
						html += "<li>'.translate('A new order has been made on your shop.').'<br />'.translate('Order number : ').'<strong>#" + parseInt(value.id_order) + "</strong><br />'.translate('Total : ').'<strong>" + value.total_paid_real + "</strong><br />'.translate('From : ').'<strong>" + value.customer_name + "</strong><br /><a href=\"index.php?controller=AdminOrders&token='.Tools::getAdminTokenLite('AdminOrders').'&vieworder&id_order=" + parseInt(value.id_order) + "\">'.translate('Click here to see that order').'</a></li>";
					});
					if (html != "")
					{
						$("#list_orders_notif").prev("p").hide();
						$("#list_orders_notif").empty().append(html);
						nb_notifs = $("#list_orders_notif li").length;
						$("#orders_notif_value").text(nb_notifs);
						$("#orders_notif_number_wrapper").show();
					}
					else
					{
						$("#orders_notif_number_wrapper").hide();
					}

					// Add customers notifications to the list
					html = "";
					nb_notifs = 0;
					$.each(json.customer, function(property, value) {
						html += "<li>'.translate('A new customer registered on your shop.').'<br />'.translate('Customer name : ').'<strong>" + value.customer_name + "</strong><br /><a href=\"index.php?controller=AdminCustomers&token='.Tools::getAdminTokenLite('AdminCustomers').'&viewcustomer&id_customer=" + parseInt(value.id_customer) + "\">'.translate('Click here to see that customer').'</a></li>";
					});
					if (html != "")
					{
						$("#list_customers_notif").prev("p").hide();
						$("#list_customers_notif").empty().append(html);
						nb_notifs = $("#list_customers_notif li").length;
						$("#customers_notif_value").text(nb_notifs);
						$("#customers_notif_number_wrapper").show();
					}
					else
					{
						$("#customers_notif_number_wrapper").hide();
					}

					// Add messages notifications to the list
					html = "";
					nb_notifs = 0;
					$.each(json.message, function(property, value) {
						html += "<li>'.translate('A new message posted on your shop.').'<br />'.translate('From : ').'<strong>" + value.customer_name + "</strong><br />'.translate('Excerpt : ').'<strong>" + value.message_customer + "</strong><br /><a href=\"index.php?controller=AdminOrders&token='.Tools::getAdminTokenLite('AdminOrders').'&vieworder&id_order=" + parseInt(value.id_order) + "\">'.translate('Click here to see that message').'</a></li>";
					});
					if (html != "")
					{
						$("#list_messages_notif").prev("p").hide();
						$("#list_messages_notif").empty().append(html);
						nb_notifs = $("#list_messages_notif li").length;
						$("#messages_notif_value").text(nb_notifs);
						$("#messages_notif_number_wrapper").show();
					}
					else
					{
						$("#messages_notif_number_wrapper").hide();
					}

				}
				setTimeout("getPush()",60000);
			});
		}

		$().ready(function()
		{
			var hints = $(\'.translatable span.hint\');
			';
			if (Shop::isMultiShopActivated())
			{
				if (Context::shop() == Shop::CONTEXT_ALL)
					$youEditFieldFor = translate('A modification of this field will be applied for all shops');
				else if (Context::shop() == Shop::CONTEXT_GROUP)
					$youEditFieldFor = sprintf(translate('A modification of this field will be applied for all shops of group %s'), '<b>'.Context::getContext()->shop->getGroup()->name.'</b>');
				else
					$youEditFieldFor = sprintf(translate('A modification of this field will be applied for the shop %s'), '<b>'.Context::getContext()->shop->name.'</b>');
				echo 'hints.html(hints.html()+\'<br /><span class="red">'.addslashes($youEditFieldFor).'</span>\');';
			}

echo '		var html = "";
			var nb_notifs = 0;
			var wrapper_id = "";
			var type = new Array();

			$(".notifs").live("click", function(){
				wrapper_id = $(this).attr("id");
				type = wrapper_id.split("s_notif")
				$.post("ajax.php",{"updateElementEmployee" : "1", "updateElementEmployeeType" : type[0]}, function(data) {
					if(data)
					{
						if(!$("#" + wrapper_id + "_wrapper").is(":visible"))
						{
							$(".notifs_wrapper").hide();
							$("#" + wrapper_id + "_number_wrapper").hide();
							$("#" + wrapper_id + "_wrapper").show();
						}else
						{
							$("#" + wrapper_id + "_wrapper").hide();
						}
					}
				});
			});

			$("#main").click(function(){
				$(".notifs_wrapper").hide();
			});

			getPush();
		});
		</script>
	</head>
	<body '.((!empty(Context::getContext()->employee->bo_color)) ? 'style="background:'.Tools::htmlentitiesUTF8(Context::getContext()->employee->bo_color).'"' : '').'>
	<div id="top_container">
		<div id="container">
			<div id="header_infos"><span>
				<a id="header_shopname" href="index.php"><span>'.Configuration::get('PS_SHOP_NAME').'</span></a><div id="notifs_icon_wrapper">';
				if (Configuration::get('PS_SHOW_NEW_ORDERS') == 1)
				{
					echo '<div id="orders_notif" class="notifs"><span id="orders_notif_number_wrapper" class="number_wrapper"><span id="orders_notif_value">0</span></span>
							<div id="orders_notif_wrapper" class="notifs_wrapper">
								<h3>'.translate('Last orders').'</h3>
								<p class="no_notifs">'.translate('No new orders has been made on your shop').'</p>
								<ul id="list_orders_notif"></ul>
								<p><a href="index.php?controller=AdminOrders&token='.Tools::getAdminTokenLite('AdminOrders').'">'.translate('Show all orders').'</a></p>
							</div>
						</div>';
				}
				if (Configuration::get('PS_SHOW_NEW_CUSTOMERS') == 1)
				{
					echo '<div id="customers_notif" class="notifs notifs_alternate"><span id="customers_notif_number_wrapper" class="number_wrapper"><span id="customers_notif_value">0</span></span>
							<div id="customers_notif_wrapper" class="notifs_wrapper">
								<h3>'.translate('Last customers').'</h3>
								<p class="no_notifs">'.translate('No new customers registered on your shop').'</p>
								<ul id="list_customers_notif"></ul>
								<p><a href="index.php?controller=AdminCustomers&token='.Tools::getAdminTokenLite('AdminCustomers').'">'.translate('Show all customers').'</a></p>
							</div>
						</div>';
				}
				if (Configuration::get('PS_SHOW_NEW_MESSAGES') == 1)
				{
					echo '<div id="messages_notif" class="notifs"><span id="messages_notif_number_wrapper" class="number_wrapper"><span id="messages_notif_value">0</span></span>
							<div id="messages_notif_wrapper" class="notifs_wrapper">
								<h3>'.translate('Last messages').'</h3>
								<p class="no_notifs">'.translate('No new messages posted on your shop').'</p>
								<ul id="list_messages_notif"></ul>
								<p><a href="index.php?controller=AdminMessages&token='.Tools::getAdminTokenLite('AdminMessages').'">'.translate('Show all messages').'</a></p>
							</div>
						</div>';
				}
	echo		'</div><span id="employee_links">
				'.Tools::substr(Context::getContext()->employee->firstname, 0, 1).'.&nbsp;'.htmlentities(Context::getContext()->employee->lastname, ENT_COMPAT, 'UTF-8').'
				[ <a href="index.php?logout" id="header_logout"><span>'.translate('logout').'</span></a> ]';
				if (Context::getContext()->shop->getBaseURL())
					echo '- <a href="'.Context::getContext()->shop->getBaseURL().'" id="header_foaccess" target="_blank" title="'.translate('View my shop').'"><span>'.translate('View my shop').'</span></a>';
	echo '		- <a href="index.php?controller=AdminEmployees&id_employee='.(int)Context::getContext()->employee->id.'&updateemployee&token='.Tools::getAdminTokenLite('AdminEmployees').'" style="font-size: 10px;"><img src="../img/admin/employee.gif" alt="" /> '.translate('My preferences').'</a>
			</span></div>
			<div id="header_search">
				<form method="post" action="index.php?controller=AdminSearch&token='.Tools::getAdminTokenLite('AdminSearch').'">
					<input type="text" name="bo_query" id="bo_query"
						value="'.Tools::safeOutput(Tools::stripslashes(Tools::getValue('bo_query'))).'"
					/>
					<select name="bo_search_type" id="bo_search_type">
						<option value="0">'.translate('everywhere').'</option>
						<option value="1" '.(Tools::getValue('bo_search_type') == 1 ? 'selected="selected"' : '').'>'.translate('catalog').'</option>
						<option value="2" '.(Tools::getValue('bo_search_type') == 2 ? 'selected="selected"' : '').'>'.translate('customers').'</option>
						<option value="6" '.(Tools::getValue('bo_search_type') == 6 ? 'selected="selected"' : '').'>'.translate('ip address').'</option>
						<option value="3" '.(Tools::getValue('bo_search_type') == 3 ? 'selected="selected"' : '').'>'.translate('orders').'</option>
						<option value="4" '.(Tools::getValue('bo_search_type') == 4 ? 'selected="selected"' : '').'>'.translate('invoices').'</option>
						<option value="5" '.(Tools::getValue('bo_search_type') == 5 ? 'selected="selected"' : '').'>'.translate('carts').'</option>
					</select>
					<input type="submit" id="bo_search_submit" class="button" value="'.translate('Search').'"/>
				</form>
			</div>
			<div id="header_quick">
				<script type="text/javascript">
				function quickSelect(elt)
				{
					var eltVal = $(elt).val();
					if (eltVal == "0") return false;
					else if (eltVal.substr(eltVal.length - 6) == "_blank") window.open(eltVal.substr(0, eltVal.length - 6), "_blank");
					else location.href = eltVal;
				}
				</script>
				<select onchange="quickSelect(this);" id="quick_select">
					<option value="0">'.translate('Quick Access').'</option>';
foreach (QuickAccess::getQuickAccesses(Context::getContext()->language->id) AS $quick)
{
	preg_match('/controller=(.+)(&.+)?$/', $quick['link'], $adminTab);
	if (isset($adminTab[1]))
	{
		if (strpos($adminTab[1], '&'))
			$adminTab[1] = substr($adminTab[1], 0, strpos($adminTab[1], '&'));
		$quick['link'] .= '&token='.Tools::getAdminToken($adminTab[1].(int)(Tab::getIdFromClassName($adminTab[1])).(int)(Context::getContext()->employee->id));
	}
	echo '<option value="'.$quick['link'].($quick['new_window'] ? '_blank' : '').'">&gt; '.$quick['name'].'</option>';
}
echo '			</select>
			</div>';

		if (Shop::isMultiShopActivated())
			echo '<div id="header_shoplist">'.translate('Select your shop:').' '.generateShopList().'</div>';

		echo '<div class="flatclear">&nbsp;</div>';
			echo Module::hookExec('backOfficeTop');
			echo '<ul id="menu">';

if (empty($tab))
	echo '<div class="mainsubtablist" style="display:none"></div>';
// This is made to display the subtab list
$controllers = Dispatcher::getControllers(_PS_ADMIN_DIR_.'/tabs/');
$id_current_tab = (int)Tab::getIdFromClassName($controllers[$tab]);
$myCurrentTab = new Tab($id_current_tab);
$tabs = Tab::getTabs(Context::getContext()->language->id, 0);
$echoLis = '';
$mainsubtablist = '';

foreach ($tabs AS $t)
	if (checkTabRights($t['id_tab']) === true)
	{
		$img = (Tools::file_exists_cache(_PS_ADMIN_DIR_.'/themes/'.Context::getContext()->employee->bo_theme.'/img/t/'.$t['class_name'].'.gif') ? 'themes/'.Context::getContext()->employee->bo_theme.'/img/' : _PS_IMG_).'t/'.$t['class_name'].'.gif';
		if (trim($t['module']) != '')
			$img = _MODULE_DIR_.$t['module'].'/'.$t['class_name'].'.gif';
		$current = ((strtolower($t['class_name']) == $tab) OR ($myCurrentTab->id_parent == $t['id_tab']));
		echo '<li class="submenu_size '.($current ? 'active' : '').'" id="maintab'.$t['id_tab'].'">
			<a href="index.php?controller='.$t['class_name'].'&token='.Tools::getAdminToken($t['class_name'].(int)($t['id_tab']).(int)Context::getContext()->employee->id).'">
				<img src="'.$img.'" alt="" /> '.$t['name'].'
			</a>
		</li>';
		$echoLi = '';
		$subTabs = Tab::getTabs(Context::getContext()->language->id, (int)$t['id_tab']);
		foreach ($subTabs AS $t2)
			if (checkTabRights($t2['id_tab']) === true)
				$echoLi .= '<li><a href="index.php?controller='.$t2['class_name'].'&token='.Tools::getAdminTokenLite($t2['class_name']).'">'.$t2['name'].'</a></li>';

		if ($current)
			$mainsubtablist = $echoLi;
		$echoLis .= '<div id="tab'.(int)($t['id_tab']).'_subtabs" style="display:none">'.$echoLi.'</div>';
	}
echo '		</ul>'.$echoLis;
if (Context::getContext()->employee->bo_uimode == 'hover')
	echo '	<script type="text/javascript">
				$("#menu li").hoverIntent({over:hoverTabs,timeout:100,out:outTabs});
				function outTabs(){}
				function hoverTabs() {
					var content = $("#tab"+parseInt(this.id.substr(7, 3))+"_subtabs").html();
					$("#submenu").html(content);
					if (content.length == 0)
						$("#submenu").removeClass("withLeftBorder");
					else
						$("#submenu").addClass("withLeftBorder");
					$("#menu li").removeClass("active");
					$(this).addClass("active");
				}
			</script>';
echo '		<ul id="submenu" '.(strlen($mainsubtablist) ? 'class="withLeftBorder clearfix"' : '').'>'.$mainsubtablist.'</ul>
			<div id="main">
				<div id="content">'
			.(file_exists(_PS_ADMIN_DIR_.'/../install') ? '<div style="background-color: #FFEBCC;border: 1px solid #F90;line-height: 20px;margin: 0px 0px 10px;padding: 10px 20px;">'
				.translate('For security reasons, you must also:').' '.
				translate('delete the /install folder').
				'</div>' : '').'
				';
