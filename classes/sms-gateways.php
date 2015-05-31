<?php

/**
 * @author woocommerce.ir
 */
class Woocommerceir_SMS_Gateways {

    private static $_instance;

    public static function init() {
        if ( !self::$_instance ) {
            self::$_instance = new Woocommerceir_SMS_Gateways();
        }

        return self::$_instance;
    }


    
	function novinpayamak( $sms_data ) {
        $response = false;

        $username = persianwoosms_get_option( 'persian_woo_sms_username', 'persianwoosms_gateway' );
        $password = persianwoosms_get_option( 'persian_woo_sms_password', 'persianwoosms_gateway' );
        $from = persianwoosms_get_option( 'persian_woo_sms_sender', 'persianwoosms_gateway' );
        $phone = $sms_data['number'];
		if(strlen($phone)== 10)
			$phone = '0'.$phone;

        if ( empty( $username ) || empty( $password ) ) {
            return $response;
        }

		$client = new SoapClient('http://www.novinpayamak.com/services/SMSBox/wsdl', array('encoding' => 'UTF-8'));
		$flash = false;
		$res = $client->Send(
			array(
				'Auth' 	=> array('number' => $username,'pass' => $password),
				'Recipients' => array($phone),
				'Message' => array($sms_data['sms_body']),
				'Flash' => $flash
				)
			);
		
		
        if ($res->Status == 1000) {
            $response = true;
        }

        return $response;
    }



}
