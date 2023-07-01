<?php
/**
 * QR Code Generator
 * @author Nikolai Shcherbin
 * @package Plugin
 * @license GNU Affero General Public License version 3
 * @copyright (c) Nikolai Shcherbin 2023
 * @link https://wzm.me
**/
elgg_gatekeeper();

$guid = (int) get_input('guid');
$entity = get_entity($guid);
if (!$entity instanceof \ElggEntity) {
	return;
}

$modaltitle = elgg_format_element('h3', ['class' => 'modal-title'], elgg_echo('qrcode:view', [elgg_get_excerpt($entity->getDisplayName(), 70)]));

$header = elgg_format_element('div', ['class' => 'modal-header'], $modaltitle);

$form = elgg_format_element('form', [
	'class' => 'qrcode-container',
	'action' => elgg_generate_action_url('qrcode/generate', [
		'guid' => $guid,
	]),
]);

$content = elgg_format_element('div', ['class' => 'qrcode-content']);

echo elgg_format_element('div', ['class' => 'ui-front'], $header . $form . $content);
?>
<script>
	require(['jquery', 'elgg/Ajax', 'elgg/i18n'], function($, Ajax, i18n) {
		$().ready(function() {
			var $form = $('.qrcode-container');
			var $content = $('.qrcode-content');
			var ajax = new Ajax();

			ajax.action($form.attr('action')).done(function (response) {
				$content.append($('<div><img src='+ response.url +'></div><div><a class="elgg-button elgg-button-action" href='+ response.url +'>'+ i18n.echo('qrcode:download') +'</a></div>'));
			}).fail(function () {
				$.colorbox.close();
			});
		});
	});
</script>