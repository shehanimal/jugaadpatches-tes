<?php

namespace Drupal\store_product\Plugin\Block;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'QrCodeBlock' Block.
 *
 * @Block(
 *   id = "qr_code_block",
 *   admin_label = @Translation("QR_Code_Block"),
 *   category = @Translation("Store Products"),
 * )
 */


class QrCodeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
	  
	  $qrcode_data = $this->printQrCode();
	  //$qrcode_data = '1233131';
	  
    return [
     '#theme' => 'qrcode_block',
	 '#qrcode_data' => $qrcode_data,
	 '#cache' => [
	       'max-age' => 0,
	 ]
    ];
  }



private function printQrCode(){
	
	$node = \Drupal::routeMatch()->getParameter('node');
	if ($node instanceof \Drupal\node\NodeInterface) {
	   
		$node->field_app_purches_link->value;
		$purchaselink = $node->field_app_purches_link->uri;
		$qrcode = $this->getQrcode($purchaselink);
		return $qrcode;
	
	}
}

private function getQrcode($qrurl){
	if($qrurl != ''){
		$data = 'otpauth:'.$qrurl;
		$qrcode = new QRCode;
		$qrcode = $qrcode->render($data);
		return $qrcode;
	}else{
		return false;
	}

 }
}