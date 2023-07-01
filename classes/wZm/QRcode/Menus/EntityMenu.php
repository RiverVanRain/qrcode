<?php

namespace wZm\QRcode\Menus;

class EntityMenu {
	
	public function __invoke(\Elgg\Event $event) {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggEntity) {
			return;
		}
		
		$return = $event->getValue();

		$return[] = \ElggMenuItem::factory([
			'name' => 'qrcode',
			'text' => elgg_echo('qrcode:show'),
			'href' => elgg_http_add_url_query_elements('ajax/view/qrcode/generate', [
				'guid' => $entity->guid,
			]),
			'icon' => 'qrcode',
			'class' => 'elgg-lightbox',
			'data-colorbox-opts' => json_encode([
				'width' => '1000px',
				'height' => '98%',
				'maxWidth' => '98%',
			]),
			'deps' => ['elgg/lightbox'],
		]);
		
		return $return;
	}
}
