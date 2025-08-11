<?php

/**
 * Description of firebase
 *
 * @author dito
 */
class Firebase {

    function __construct() {
        
    }

    
    public function SendNotification($title = '', $message = '', $emp_id) {
        $ci = & get_instance();
        $url = 'https://fcm.googleapis.com/fcm/send';
        $registrationIDs = $ci->db->get_where('tmst_devices', array('emp_id' => $emp_id))->row();

        if($registrationIDs){
        $headers = array(
            'Authorization:key = AIzaSyAzQM0BzSIC_WLWpZRtoxaQDSGfR5SafqY', //Server key from firebase
            'Content-Type: application/json'
        );


        // $registrationIDs='eXh9gqql6I4:APA91bGhDYQgLzKEcI_UcQ5AkRAqjiLY2WA8KRhWCUbPSoJIN22gssGaq5XSEDu7kmKEiLMLqyP2sFssmddHd26aCXPnFvNgTXPJYHQycsHDePzdFT-QCk9kaXq3-rzoZgISWd7u-82u';

        $fields = array(
            'registration_ids' => array($registrationIDs->token),
            'notification' => array("body" => $message, "title" => $title),
        );

        //  echo json_encode($fields) ;
        // die();
        $ch = curl_init();
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);

        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);

        //  echo $result;

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //Now close the connection
        curl_close($ch);
        }else{
            
            $result=TRUE;
        }
        return $result;
    }

    //put your code here
}
