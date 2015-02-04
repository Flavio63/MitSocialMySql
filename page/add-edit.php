<?php

$errors = array();
$clientsocials = null;
//$edit = array_key_exists('id', $_GET);
$edit = filter_input(INPUT_GET, 'id');
$arrPost = filter_input_array(INPUT_POST);
if ($edit) {
    $clientsocials = Utils::getClientSocialsByGetId();
} else {
    // set defaults
    $clientsocials = new ClientSocials();
}

if ($arrPost) {
    if (array_key_exists('cancel', $arrPost)) {
        // redirect
        Utils::redirect('detail', array('id' => $clientsocials->getId()));
    } elseif (array_key_exists('save', $arrPost)) {
        // for security reasons, do not map the whole $_POST['clientsocials']
        $data = array(
            'name' => $arrPost['clientsocials']['name'],
            'created_by' => $arrPost['clientsocials']['created_by'],
        );
        // map
        ModelMapper::map($clientsocials, $data);
        // validate
        $errors = ModelValidator::validate($clientsocials);
        // validate
        if (empty($errors)) {
            $clientsocials->setScreenNameFacebook($arrPost['clientsocials']['screen_name_facebook']);
            $clientsocials->setIdNumberFacebook($arrPost['clientsocials']['id_number_facebook']);
            $clientsocials->setScreenNameTwitter($arrPost['clientsocials']['screen_name_twitter']);
            $clientsocials->setHashtagTwitter($arrPost['clientsocials']['hashtag_twitter']);
            $clientsocials->setScreenNameYoutube($arrPost['clientsocials']['screen_name_youtube']);
            $clientsocials->setIdGplus($arrPost['clientsocials']['id_gplus']);
            $clientsocials->setGPlusType($arrPost['clientsocials']['gplus_type']);
            $clientsocials->setScreenNameInstagram($arrPost['clientsocials']['screen_name_instagram']);
            $clientsocials->setIdNumberInstagram($arrPost['clientsocials']['id_number_instagram']);
            $clientsocials->setScreenNamePinterest($arrPost['clientsocials']['screen_name_pinterest']);
            $clientsocials->setScreenNameVimeo($arrPost['clientsocials']['screen_name_vimeo']);
            $clientsocials->setScreenNameTumblr($arrPost['clientsocials']['screen_name_tumblr']);
            $clientsocials->setLnkCompany($arrPost['clientsocials']['lnk_company']);
            // save
            $dao = new connManager();
            $clientsocials = $dao->save($clientsocials);
            //Flash::addFlash('TODO saved successfully.');
            // redirect
            Utils::redirect('detail', array('id' => $clientsocials->getId()));
        }
    }
}
?>
