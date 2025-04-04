<?php

$addon_dir = root_path() . 'addon';
$addons = array_diff(scandir($addon_dir), ['.', '..']);
foreach ($addons as $addon) {
    $install_php = $addon_dir . DIRECTORY_SEPARATOR . $addon . DIRECTORY_SEPARATOR . 'install.php';
    if (file_exists($install_php)) {
        $addon_info = json_decode(file_get_contents($addon_dir . DIRECTORY_SEPARATOR . $addon . DIRECTORY_SEPARATOR . 'info.json'), true);
        if (!isset($addon_info['type']) || $addon_info['type'] != 'app') continue;
        return include $install_php;
    }
}

return [
    'website_name' => 'NIUCLOUD-ADMIN',
    // logo
    'logo' => 'logo.jpg',
    // 官网地址
    'website_url' => 'https://www.niucloud.com',
    // 论坛地址
    'bbs_url' => 'http://bbs.niucloud.com',
    // 编译帮助手册
    'build_manual' => 'https://www.kancloud.cn/niushop/niucloud-admin-app/3199825',
    // 安装协议
    'agreement' => '<strong>版权所有 (c)2023，niucloud-admin保留所有权利。</strong>
		<p>
			感谢您选择niucloud-admin【以下简称niucloud】，niucloud-admin后台采用thinkphp6+php8+mysql,前端采用uniapp前后端分离的技术开发，全部源码开放。 <br/>
			为了使您正确并合法的使用本软件，请您在使用前务必阅读清楚下面的协议条款：
		</p>
		<p>
			<strong>一、本协议适用于niucloud-admin框架以及框架内所有应用，使用前请您务必仔细阅读本协议须知并勾选接受或者不接受，如不接受此协议，那么您无权利继续注册并使用本协议涉及的所有服务，如果您继续注册，登录，订阅等行为，则视为默认接受本协议。niucloud官方对本授权协议拥有最终解释权。</strong>
		</p>
		<p>
			<strong>二、协议许可权利 </strong>
			<ol>
				<li>1、用户接受并承诺遵守本协议才可登录niucloud-admin官网订购应用，如果用户不同意，那么不允许在niucloud-admin官网注册账号并登录体验。</li>
				<li>2、用户必须是具有独立民事责任行为能力的自然人、法人或其他组织个人。若用户不具备前述资格，那么该用户及其监护人应承担导致的一切后果。并且官方有权利对其账号进行冻结，对官方造成的利益损害有权进行申诉索赔。</li>
				<li>3、用户可登录niucloud-admin官网下载并安装免费版应用。</li>
				<li>4、若需要安装付费版应用，用户需要登录niucloud-admin官网付费并订购付费版应用后才可下载安装。</li>
				<li>5、在更新niucloud-admin框架到最新版时，请务必对原整站内容进行备份，否则niucloud官方对升级过程中造成的数据丢失等问题不承担任何责任。</li>
				<li>6、niucloud官方下架应用造成的无法更新，官方不承担任何责任。</li>
				<li>7、niucloud官方因商业需求，暂停应用的更新，官方不承担任何责任。</li>
				<li>8、niucloud官网有权根据需要不时地制订、修改本协议或各类规则，并以公示的方式进行公告，不再单独通知用户。变更后的协议和规则一经公布后，立即自动生效。如用户不同意相关变更，应当立即停止使用niucloud-admin付费应用。如果用户继续订阅、使用niucloud-admin付费应用，即表示用户接受经修订的协议。</li>
			</ol>
		</p>
		<p>
			<strong>三、协议规定的约束和限制</strong>
			<ol>
				<li>1、请尊重开发人员劳动成果，严禁对本框架进行转卖、销售或二次开发后转卖、销售等商业行为。</li>
				<li>2、任何企业和个人不允许对程序代码以任何形式任何目的再发布。</li>
				<li>3、基于niucloud-admin应用从事的任何商业行为，都与niucloud官方无关。</li>
				<li>4、授权niucloud-admin付费应用时，必须要确保授权信息主体录入的准确性，否则出现的法律纠纷与niucloud官方无关，需要自行解决。</li>
				<li>5、应用金额以最终结算价格为准，已售出的应用不做任何差价补偿。</li>
				<li>6、如果用户利用特殊手段以低价或者免费获得付费应用，niucloud官方有权对应用进行回收。</li>
				<li>7、niucloud-admin付费应用一旦完成交易下载源码，不得以任何形式和理由进行退款，请在购买前仔细阅读本协议。</li>
				<li>8、基于niucloud-admin框架进行应用的开发，必须保留框架版权信息。</li>
			</ol>
		</p>
		<p>
			<strong>四、知识产权声明</strong>
			<ol>
				<li>1、niucloud-admin框架应用源代码所有权和著作权归niucloud官方所有，基于niucloud-admin框架开发的应用，所有权和著作权归应用开发商所有。</li>
				<li>2、niucloud-admin框架所依托的代码、文字、图片等著作权、专利权及其他知识产权均归niucloud官方所有，除另外有特别声明。</li>
			</ol>
		</p>

		<p><strong>五、有限担保和免责声明</strong></p>
		<p>
			本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。<br/>
			用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。
			电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始确认本协议并安装niucloud-admin框架，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
		</p>',
    // 站点名称
    'admin_site_name' => 'NIUCLOUD ADMIN',
    // admin 端登录页默认图
    'admin_login_bg' => 'install/img/niushop_login_index_left.jpg',
    // admin 端默认logo
    'admin_logo' => 'install/img/logo.jpg'
];
