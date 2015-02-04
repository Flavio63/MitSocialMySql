<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientSocials
 *
 * @author flaviovilla
 */
final class ClientSocials {
    // status
    const STATUS_PENDING = "PENDING";
    const STATUS_DONE = "DONE";
    const STATUS_SENT = "SENT";

    const PAGE_PROFESSIONAL = 0;
    const PAGE_PERSONAL = 1;

    private $id;
    private $idLong;
    /* @var string visible name */
    private $name;
    /* @var string */
    private $screenNameFacebook;
    private $idNumberFacebook;
    private $screenNameTwitter;
    private $hashtagTwitter;
    private $screenNameYoutube;
    private $idGplus;
    private $gPlusType;
    private $screenNameInstagram;
    private $idNumberInstagram;
    private $screenNamePinterest;
    private $screenNameVimeo;
    private $screenNameTumblr;
    private $lnkCompany;
    
    /* variabili di gestione */
    private $createdBy;
    private $createdOn;
    private $lastModifiedOn;
    private $status;
    private $deleted;
    
    /**
     * Create new {@link ClientSocials} with default properties set.
     */
    public function __construct() {
        $now = new DateTime();
        $this->setCreatedOn($now);
        $this->setLastModifiedOn($now);
        $this->setStatus(self::STATUS_PENDING);
        $this->setDeleted(false);
    }
    
    public static function allStatuses() {
        return array(self::STATUS_PENDING, self::STATUS_DONE, self::STATUS_SENT);
    }
    
    public static function typeOfGooglePages() {
        return array(self::PAGE_PROFESSIONAL, self::PAGE_PERSONAL);
    }

    // start getter & setter //
    
        /**
     * @return int <i>null</i> if not persistent
     */
    public function getId() {
        return $this->id;
    }
    // 20140917 per l'id codificato
    public function getIdLong(){
        return $this->idLong;
    }

    public function setId($id) {
        if ($this->id !== null && $this->id != $id) {
            throw new Exception('Cannot change identifier to ' . $id . ', already set to ' . $this->id);
        }
        $this->id = (int) $id;
    }
    // 20140917 per l'id codificato
    public function setIdLong($idLong){
        if (!isset($idLong)){
            $idLong = "";
        }
        $this->idLong = (string) $idLong;
    }

    /**
     * 
     * @return string the name published on front page
     */
    public function getName() {
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    
    /**
     * @return string the screen name of facebook
     */
    public function getScreenNameFacebook(){
        return $this->screenNameFacebook;
    }
    public function setScreenNameFacebook($screenNameFacebook) {
        $this->screenNameFacebook=$screenNameFacebook;
    }
    
    /**
     * @return number id number of facebook
     */
    public function getIdNumberFacebook(){
        return $this->idNumberFacebook;
    }
    public function setIdNumberFacebook($idNumberFacebook){
        $this->idNumberFacebook = $idNumberFacebook;
    }
    
    /**
     * @return string the screen name of twitter
     */
    public function getScreenNameTwitter() {
        return $this->screenNameTwitter;
    }
    public function setScreenNameTwitter($screenNameTwitter) {
        $this->screenNameTwitter = $screenNameTwitter;
    }
    
    /**
     * @return string hashtag of twitter
     */
    public function getHashtagTwitter(){
        if ($this->hashtagTwitter) {
            return implode(",", $this->hashtagTwitter);
        }
        return "";
    }
    public function setHashtagTwitter($hashtagTwitter) {
        if (is_array($hashtagTwitter)){
            $this->hashtagTwitter = $hashtagTwitter;
        } elseif (is_string($hashtagTwitter)) {
            $this->hashtagTwitter = explode(",", $hashtagTwitter);
        }
    }
    
    /**
     * @return string screen name of youtube
     */
    public function getScreenNameYoutube() {
        return $this->screenNameYoutube;
    }
    public function setScreenNameYoutube($screenNameYoutube) {
        $this->screenNameYoutube = $screenNameYoutube;
    }
    
    /**
     * @return mixed id number or screen name of google plus
     */
    public function getIdGplus() {
        return $this->idGplus;
    }
    public function setIdGplus($idGplus) {
        $this->idGplus = $idGplus;
    }
    
    /**
     * @return number type of page
     */
    public function getGPlusType(){
        return$this->gPlusType;
    }
    public function setGPlusType($gPlusType = 0) {
        $this->gPlusType = $gPlusType;
    }
    
    /**
     * @return string screen name instagram
     */
    public function getScreenNameInstagram() {
        return $this->screenNameInstagram;
    }
    public function setScreenNameInstagram($screenNameInstagram) {
        $this->screenNameInstagram = $screenNameInstagram;
    }
    
    /**
     * @return number id number of instagram
     */
    public function getIdNumberInstagram() {
        return $this->idNumberInstagram;
    }
    public function setIdNumberInstagram($idNumberInstagram) {
        $this->idNumberInstagram = $idNumberInstagram;
    }
    
    /**
     * @return string screen name vimeo
     */
    public function getScreenNameVimeo() {
        return $this->screenNameVimeo;
    }
    public function setScreenNameVimeo($screenNameVimeo) {
        $this->screenNameVimeo = $screenNameVimeo;
    }
    
    /**
     * @return string screen name Tumblr
     */
    public function getScreenNameTumblr() {
        return $this->screenNameTumblr;
    }
    public function setScreenNameTumblr($screenNameTumblr) {
        $this->screenNameTumblr = $screenNameTumblr;
    }
            
    /**
     * @return string screen name Link to client's site
     */
    public function getLnkCompany() {
        return $this->lnkCompany;
    }
    public function setLnkCompany($lnkCompany) {
        $this->lnkCompany = $lnkCompany;
    }

    
    /**
     * @return string screen name Pinterest
     */
    public function getScreenNamePinterest() {
        return $this->screenNamePinterest;
    }
    public function setScreenNamePinterest($screenNamePinterest) {
        $this->screenNamePinterest = $screenNamePinterest;
    }
    
    /**
     * @return string Description
     */

    /**
     * @return DateTime
     */
    public function getCreatedOn() {
        return $this->createdOn;
    }
    public function setCreatedOn(DateTime $createdOn) {
        $this->createdOn = $createdOn;
    }

    /**
     * @return DateTime
     */
    public function getLastModifiedOn() {
        return $this->lastModifiedOn;
    }
    public function setLastModifiedOn(DateTime $lastModifiedOn) {
        $this->lastModifiedOn = $lastModifiedOn;
    }
    
    /**
     * @return string one of PENDING/DONE
     */
    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        ModelValidator::validateStatus($status);
        $this->status = $status;
    }
    
    /**
     * @return string the owner
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }
    public function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }
    
    /**
     * @return boolean true if it is deleted false is it is still alive.
     */
    public function getDeleted() {
        return $this->deleted;
    }
    public function setDeleted($deleted) {
        $this->deleted = (bool) $deleted;
    }

}
