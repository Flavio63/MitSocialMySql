<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelValidator
 *
 * @author flaviovilla
 */
class ModelValidator {
    
        /**
     * Validate the given status.
     * @param string $status status to be validated
     * @throws Exception if the status is not known
     */
    public static function validateStatus($status) {
        if (!self::isValidStatus($status)) {
            throw new Exception('Unknown status: ' . $status);
        }
    }

    
    private static function isValidStatus($status) {
        return in_array($status, ClientSocials::allStatuses());
    }
    
    public static function validate(ClientSocials $clientsocials) {
        $errors = array();
        if (!$clientsocials->getCreatedOn()) {
            $errors[] = new Error('createdOn', 'Empty or invalid Created On.');
        }
        if (!$clientsocials->getLastModifiedOn()) {
            $errors[] = new Error('lastModifiedOn', 'Empty or invalid Last Modified On.');
        }
        if (!trim($clientsocials->getName())) {
            $errors[] = new Error('name', 'The client name cannot be empty.');
        }
        if (!$clientsocials->getCreatedBy()) {
            $errors[] = new Error('createdBy', 'The worker\'s name cannot be empty.');
        }
        if (!trim($clientsocials->getStatus())) {
            $errors[] = new Error('status', 'Status cannot be empty.');
        } elseif (!self::isValidStatus($clientsocials->getStatus())) {
            $errors[] = new Error('status', 'Invalid Status set.');
        }
        return $errors;
        
    }
}
