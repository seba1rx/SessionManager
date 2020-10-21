<?php

require('../src/sessionAdmin.php');

use Rx\SessionAdmin;

$rxSessionAdmin = new SessionAdmin();
$rxSessionAdmin->activateSession();

/**
 * this scripts simulates an authentication, you should implement your own validation 
 */

$validationResponse = array(
    'ok' => false,
    'msg' => null,
);

if(
    isset($_POST['useremail']) && !empty($_POST['useremail']) &&
    isset($_POST['userpassword']) && !empty($_POST['userpassword'])
){
    /** lets assume we query the system database and the data matching the credentials is the following: */
    $data = array(
        'id' => 123,
        'name' => 'Sebastian',
        'nickname' => 'seba1rx',
        'avatar' => 'https://thumbs.gfycat.com/BouncyWelcomeGrassspider-max-1mb.gif',
        'birthDate' => '1985-05-21',
        'country' => 'Chile',
        'email' => $_POST['useremail'],
    );

    /** 
     * up to now we are in guest mode...
     * lets call the method to create the user session 
     */
    $rxSessionAdmin->createUserSession($data['id']);

    /**
     * since $_SESSION is open, there is no poin in encapsulating the data with get and set...
     * lets add the data to SESSION['data']
     */
    foreach($data AS $dataName => $dataValue){
        $_SESSION['data'][$dataName] = $dataValue;
    }

    // here you woud iterate to add allowed urls according to assigned profile 
    // foreach($ProfileAllowedUrls AS $url){
    //    $_SESSION['allowedUrl'][] = $url;   
    // }

    $validationResponse['ok'] = true;
    $validationResponse['msg'] = 'Wellcome '.$_SESSION['data']['name'];

}else{
    $validationResponse['ok'] = false;
    $validationResponse['msg'] = 'Complete the form fields!';
}

echo json_encode($validationResponse);
