<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author flaviovilla
 */
final class Utils {

    private function __construct() {
    }

    /**
     * Generate link.
     * @param string $page target page
     * @param array $params page parameters
     */
    public static function createLink($page, array $params = array()) {
        if ($page == "showstream"){
            return 'localhost/MITsocialStreamBKD/index.php?'.http_build_query($params);
        } else {
        $params = array_merge(array('page' => $page), $params);
        // TODO add support for Apache's module rewrite
        return 'index.php?' .http_build_query($params);
        }
    }

    /**
     * Format date.
     * @param DateTime $date date to be formatted
     * @return string formatted date
     */
    public static function formatDate(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('d/m/Y');
    }

    /**
     * Format date and time.
     * @param DateTime $date date to be formatted
     * @return string formatted date and time
     */
    public static function formatDateTime(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('d/m/Y H:i');
    }

    /**
     * Redirect to the given page.
     * @param type $page target page
     * @param array $params page parameters
     */
    public static function redirect($page, array $params = array()) {
        header('Location: ' . self::createLink($page, $params));
        die();
    }

    /**
     * Get value of the URL param.
     * @return string parameter value
     * @throws NotFoundException if the param is not found in the URL
     */
    public static function getUrlParam($name) {
        if (!array_key_exists($name, $_GET)) {
            throw new NotFoundException('URL parameter "' . $name . '" not found.');
        }
        return $_GET[$name];
    }

    /**
     * Get {@link Todo} by the identifier 'id' found in the URL.
     * @return Todo {@link Todo} instance
     * @throws NotFoundException if the param or {@link Todo} instance is not found
     */
    public static function getClientSocialsByGetId() {
        $id = null;
        try {
            $id = self::getUrlParam('id');
        } catch (Exception $ex) {
            throw new NotFoundException('No ClientSocials identifier provided.');
        }
        if (!is_numeric($id)) {
            throw new NotFoundException('Invalid ClientSocials identifier provided.');
        }
        $dao = new connManager();
        $clientsocials = $dao->findById($id);
        if ($clientsocials === null) {
            throw new NotFoundException('Unknown work identifier provided.');
        }
        return $clientsocials;
    }

    /**
     * Capitalize the first letter of the given string
     * @param string $string string to be capitalized
     * @return string capitalized string
     */
    public static function capitalize($string) {
        return ucfirst(mb_strtolower($string));
    }

    /**
     * Escape the given string
     * @param string $string string to be escaped
     * @return string escaped string
     */
    public static function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }
    
    public static function changeIntoArray(ClientSocials $clientsocials) {
        $result = array(
            'name' => $clientsocials->getName(),
            'hashtag_twitter' => $clientsocials->getHashtagTwitter(),
            'screen_name_twitter' => $clientsocials->getScreenNameTwitter(),
            'id_number_facebook' => $clientsocials->getIdNumberFacebook(),
            'id_gplus' => $clientsocials->getIdGplus(),
            'screen_name_youtube' => $clientsocials->getScreenNameYoutube(),
            'screen_name_pinterest' => $clientsocials->getScreenNamePinterest(),
            'id_number_instagram' => $clientsocials->getIdNumberInstagram(),
            'screen_name_vimeo' => $clientsocials->getScreenNameVimeo(),
            'screen_name_tumblr' => $clientsocials->getScreenNameTumblr()
        );
        return $result;
    }

}
