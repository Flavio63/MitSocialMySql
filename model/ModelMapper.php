<?php

/**
 * Mapper for {@link ClientSocials} from array.
 * @see ModelValidator
 */
final class ModelMapper {

    private function __construct() {
    }

    /**
     * Maps array to the given {@link ClientSocials}.
     * <p>
     * Expected properties are:
     * <ul>
     *   <li>id</li>
     *   <li>idLong</li>
     *   <li>name</li>
     *   <li>created_by</li>
     *   <li>created_on</li>
     *   <li>last_modified_on</li>
     *   <li>status</li>
     *   <li>screen_name_facebook</li>
     *   <li>id_number_facebook</li>
     *   <li>screen_name_twitter</li>
     *   <li>hashtag_twitter</li>
     *   <li>screen_name_youtube</li>
     *   <li>id_gplus</li>
     *   <li>gplus_type</li>
     *   <li>screen_name_instagram</li>
     *   <li>id_number_instagram</li>
     *   <li>screen_name_pinterest</li>
     *   <li>screen_name_vimeo</li>
     *   <li>screen_name_tumblr</li>
     *   <li>lnk_company</li>
     * </ul>
     * @param ClientSocials $clientsocials
     * @param array $properties
     */
    public static function map(ClientSocials $clientsocials, array $properties) {
        if (array_key_exists('id', $properties)) {
            $clientsocials->setId($properties['id']);
        }
        // 20140917 inserito per la sicurezza fra un cliente e l'altro
        if (array_key_exists('id_long', $properties)){
            $clientsocials->setIdLong($properties['id_long']);
        }
        if (array_key_exists('name', $properties)) {
            $clientsocials->setName($properties['name']);
        }
        if (array_key_exists('created_by', $properties)) {
            $clientsocials->setCreatedBy($properties['created_by']);
        }
        if (array_key_exists('created_on', $properties)) {
            $createdOn = self::createDateTime($properties['created_on']);
            if ($createdOn) {
                $clientsocials->setCreatedOn($createdOn);
            }
        }
        if (array_key_exists('last_modified_on', $properties)) {
            $lastModifiedOn = self::createDateTime($properties['last_modified_on']);
            if ($lastModifiedOn) {
                $clientsocials->setLastModifiedOn($lastModifiedOn);
            }
        }
        if (array_key_exists('status', $properties)) {
            $clientsocials->setStatus($properties['status']);
        }
        if (array_key_exists('screen_name_facebook', $properties)) {
            $clientsocials->setScreenNameFacebook($properties['screen_name_facebook']);
        }
        if (array_key_exists('id_number_facebook', $properties)) {
            $clientsocials->setIdNumberFacebook($properties['id_number_facebook']);
        }
        if (array_key_exists('screen_name_twitter', $properties)) {
            $clientsocials->setScreenNameTwitter($properties['screen_name_twitter']);
        }
        if (array_key_exists('hashtag_twitter', $properties)) {
            $clientsocials->setHashtagTwitter($properties['hashtag_twitter']);
        }
        if (array_key_exists('screen_name_youtube', $properties)) {
            $clientsocials->setScreenNameYoutube($properties['screen_name_youtube']);
        }
        if (array_key_exists('id_gplus', $properties)) {
            $clientsocials->setIdGplus($properties['id_gplus']);
        }
        if (array_key_exists('gplus_type', $properties)) {
            $clientsocials->setGPlusType($properties['gplus_type']);
        }
        if (array_key_exists('screen_name_instagram', $properties)) {
            $clientsocials->setScreenNameInstagram($properties['screen_name_instagram']);
        }
        if (array_key_exists('id_number_instagram', $properties)) {
            $clientsocials->setIdNumberInstagram($properties['id_number_instagram']);
        }
        if (array_key_exists('screen_name_pinterest', $properties)) {
            $clientsocials->setScreenNamePinterest($properties['screen_name_pinterest']);
        }
        if (array_key_exists('screen_name_vimeo', $properties)) {
            $clientsocials->setScreenNameVimeo($properties['screen_name_vimeo']);
        }
        if (array_key_exists('screen_name_tumblr', $properties)) {
            $clientsocials->setScreenNameTumblr($properties['screen_name_tumblr']);
        }
        if (array_key_exists('lnk_company', $properties)) {
            $clientsocials->setLnkCompany($properties['lnk_company']);
        }
    }

    private static function createDateTime($input) {
        return DateTime::createFromFormat('Y-n-j H:i:s', $input);
    }

}

?>
