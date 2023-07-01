<?php

namespace wZm\QRcode\Actions;

class GenerateAction {

	public function __invoke(\Elgg\Request $request) {

		$entity = $request->getEntityParam();
		if (!$entity instanceof \ElggEntity) {
			return;
		}

		$dir = elgg_get_data_path() . '1/1/qrcodes/' . $entity->guid;

		if (!is_dir($dir)) {
			mkdir($dir, 0755, true);
		}
		
		$site = elgg_get_site_entity();
		
		if (file_exists($dir . '/qrcode.png')) {
			$file = new \ElggFile();
			$file->owner_guid = $site->guid;
			$file->setFilename('qrcodes/' . $entity->guid . '/qrcode.png');
			$file->open('read');
			$file->close();
			
			$data = [
				'url' => elgg_get_inline_url($file),
			];
			
			return elgg_ok_response($data, '');
		}
		
		
		$barcode = new \Com\Tecnick\Barcode\Barcode();
		
		$bobj = $barcode->getBarcodeObj(
			'QRCODE,H',                             // barcode type and additional comma-separated parameters
			$entity->getURL(),                     // data string to encode
			-16,                                  // bar width (use absolute or negative value as multiplication factor)
			-16,                                 // bar height (use absolute or negative value as multiplication factor)
			'black',                            // foreground color
			[-2, -2, -2, -2]			       // padding (use absolute or negative values as multiplication factors)
		)->setBackgroundColor('#ffffff');     // background color
		
		$imageData = $bobj->getPngData();
		
		if (empty($imageData)) {
			return elgg_error_response(elgg_echo('qrcode:generate:error'));
		}
		
		$file = new \ElggFile();
		$file->owner_guid = $site->guid;
		$file->setFilename('qrcodes/' . $entity->guid . '/qrcode.png');
		$file->open('write');
		$file->write($imageData);
		$file->close();
		unset($imageData);
		
		$data = [
			'url' => elgg_get_inline_url($file),
		];
		
		return elgg_ok_response($data, '');
	}
}