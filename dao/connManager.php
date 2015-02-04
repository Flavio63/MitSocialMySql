<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of connManager
 *
 * @author flaviovilla
 */
final class connManager {

    /** @var PDO     */
    private $dbConn = null;

    public function __destruct() {
        // close db connection
        $this->dbConn = null;
    }
    private $tab = 'clientsocials';   // per database aziendale
    //static $tab = 'myfla1_clientsocials';

    /**
     * Find all {@link Todo}s by search criteria.
     * @return array array of {@link Todo}s
     */
    public function find(daoSearchCriteria $search = null) {
        $result = array();
        foreach ($this->query($this->getFindSql($search)) as $row) {
            $clientsocial = new ClientSocials();
            ModelMapper::map($clientsocial, $row);
            $result[$clientsocial->getId()] = $clientsocial;
        }
        return $result;
    }

    /**
     * @return array Results of a query on client's table.
     */
    public function viewClient() {
        $sql = "SELECT `name` FROM " . $this->tab . " WHERE `deleted` = 0";
        try {
            return $this->getDb()->query($sql);
        } catch (Exception $ex) {
            echo 'Error: ' . $ex->getMessage() . '</br>';
            echo 'Line: ' . $ex->getLine() . '</br>';
            echo 'File: ' . $ex->getFile() . '</br>';
        }
    }

    /**
     * Delete {@link ClientSocials} by identifier.
     * @param int $id {@link ClientSocials} identifier
     * @return bool <i>true</i> on success, <i>false</i> otherwise
     */
    public function delete($id) {
        $sql = '
            UPDATE ' . $this->tab . ' SET
                last_modified_on = :last_modified_on,
                deleted = :deleted
            WHERE
                id = :id';
        $statement = $this->getDb()->prepare($sql);
        $this->executeStatement($statement, array(
            ':last_modified_on' => self::formatDateTime(new DateTime()),
            ':deleted' => true,
            ':id' => $id,
        ));
        return $statement->rowCount() == 1;
    }


    /**
     * Find {@link ClientSocials} by identifier.
     * @return ClientSocials ClientSocials or <i>null</i> if not found
     */
    public function findById($id) {
        $row = $this->query('SELECT * FROM ' . $this->tab . ' WHERE id = ' . (int) $id)->fetch();
        if (!$row) {
            return null;
        }
        $clientsocials = new ClientSocials();
        ModelMapper::map($clientsocials, $row);
        return $clientsocials;
    }

    /**
     * @return PDO
     */
    private function getDb() {
        if ($this->dbConn !== null) {
            return $this->dbConn;
        }
        $config = Config::getConfig("MySQL_db");
        try {
            $this->dbConn = new PDO($config['dsn'], $config['username'], $config['password']);
            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            throw new Exception('DB connection error: ' . $ex->getMessage());
        }
        return $this->dbConn;
    }

    private function getFindSql(daoSearchCriteria $search = null) {
        $sql = 'SELECT * FROM ' . $this->tab . ' WHERE `deleted` = 0';
        $orderBy = ' id';
        if ($search !== null) {
            if ($search->getStatus() !== null) {
                $sql .= ' AND `status` = ' . $this->getDb()->quote($search->getStatus());
            }
        }
        $sql .= ' ORDER BY ' . $orderBy;
        return $sql;
    }
    /**
     * Save {@link Todo}.
     * @param ToDo $todo {@link Todo} to be saved
     * @return Todo saved {@link Todo} instance
     */
    public function save(ClientSocials $clientsocials) {
        if ($clientsocials->getId() === null) {
            return $this->insert($clientsocials);
        }
        return $this->update($clientsocials);
    }


    /**
     * @return Todo
     * @throws Exception
     */
    private function insert(ClientSocials $clientsocials) {
        $now = new DateTime();
        $clientsocials->setId(null);
        $idUltimo = $this->findLastId();
        $idFuturo = 1+(int)$idUltimo['id'];
        $clientsocials->setIdLong(md5($idFuturo));
        $clientsocials->setCreatedOn($now);
        $clientsocials->setLastModifiedOn($now);
        $clientsocials->setStatus(ClientSocials::STATUS_PENDING);
        $sql = '
            INSERT INTO ' . $this->tab . ' (id, id_long, created_on, last_modified_on, created_by, name, 
            screen_name_facebook, id_number_facebook, screen_name_twitter, hashtag_twitter, screen_name_youtube, 
            id_gplus, gplus_type, screen_name_instagram, id_number_instagram, screen_name_pinterest, screen_name_vimeo, 
            screen_name_tumblr, lnk_company, status, deleted) 
            VALUES (:id, :id_long, :created_on, :last_modified_on, :created_by, :name, :screen_name_facebook, 
            :id_number_facebook, :screen_name_twitter, :hashtag_twitter, :screen_name_youtube, :id_gplus, :gplus_type, 
            :screen_name_instagram, :id_number_instagram, :screen_name_pinterest, :screen_name_vimeo, :screen_name_tumblr, 
            :lnk_company, :status, :deleted)';
        return $this->execute($sql, $clientsocials);
    }
    
    private function findLastId(){
        $row = $this->query('SELECT id FROM ' . $this->tab . ' ORDER BY id DESC LIMIT 1')->fetch();
        if (!$row) {
            return null;
        }
        return $row;
        
    }

    /**
     * @return Todo
     * @throws Exception
     */
    private function update(ClientSocials $clientsocials) {
        $clientsocials->setLastModifiedOn(new DateTime());
        $sql = '
            UPDATE ' . $this->tab . ' SET
                last_modified_on = :last_modified_on,
                created_by = :created_by,
                name = :name,
                id_long = :id_long,
                screen_name_facebook = :screen_name_facebook,
                id_number_facebook = :id_number_facebook,
                screen_name_twitter = :screen_name_twitter,
                hashtag_twitter = :hashtag_twitter,
                screen_name_youtube = :screen_name_youtube,
                id_gplus = :id_gplus,
                gplus_type = :gplus_type,
                screen_name_instagram = :screen_name_instagram,
                id_number_instagram = :id_number_instagram,
                screen_name_pinterest = :screen_name_pinterest,
                screen_name_vimeo = :screen_name_vimeo,
                screen_name_tumblr = :screen_name_tumblr,
                lnk_company = :lnk_company,
                status = :status ,
                deleted = :deleted
            WHERE
                id = :id';
        return $this->execute($sql, $clientsocials);
    }

    /**
     * @return Todo
     * @throws Exception
     */
    private function execute($sql, ClientSocials $clientSocials) {
        $statement = $this->getDb()->prepare($sql);
        $this->executeStatement($statement, $this->getParams($clientSocials));
        if (!$clientSocials->getId()) {
            return $this->findById($this->getDb()->lastInsertId());
        }
        if (!$statement->rowCount()) {
            throw new NotFoundException('ClientSocials with ID "' . $$clientSocials->getId() . '" does not exist.');
        }
        return $clientSocials;
    }

    private function getParams(ClientSocials $clientSocials) {
        $params = array(
            ':id' => $clientSocials->getId(),
            ':id_long' => $clientSocials->getIdLong(),  //20140917 added
            ':created_on' => self::formatDateTime($clientSocials->getCreatedOn()),
            ':last_modified_on' => self::formatDateTime($clientSocials->getLastModifiedOn()),
            ':created_by' => $clientSocials->getCreatedBy(),
            ':name' => $clientSocials->getName(),
            ':screen_name_facebook' => $clientSocials->getScreenNameFacebook(),
            ':id_number_facebook' => $clientSocials->getIdNumberFacebook(),
            ':screen_name_twitter' => $clientSocials->getScreenNameTwitter(),
            ':hashtag_twitter' => $clientSocials->getHashtagTwitter(),
            ':screen_name_youtube' => $clientSocials->getScreenNameYoutube(),
            ':id_gplus' => $clientSocials->getIdGplus(),
            ':gplus_type' => $clientSocials->getGPlusType(),
            ':screen_name_instagram' => $clientSocials->getScreenNameInstagram(),
            ':id_number_instagram' => $clientSocials->getIdNumberInstagram(),
            ':screen_name_pinterest' => $clientSocials->getScreenNamePinterest(),
            ':screen_name_vimeo' => $clientSocials->getScreenNameVimeo(),
            ':screen_name_tumblr' => $clientSocials->getScreenNameTumblr(),
            ':lnk_company' => $clientSocials->getLnkCompany(),
            ':status' => $clientSocials->getStatus(),
            ':deleted' => $clientSocials->getDeleted()
        );
        if ($clientSocials->getId()) {
            // unset created date, this one is never updated
            unset($params[':created_on']);
        }
        return $params;
    }

    private function executeStatement(PDOStatement $statement, array $params) {
        if (!$statement->execute($params)) {
            self::throwDbError($this->getDb()->errorInfo());
        }
    }

    /**
     * @return PDOStatement
     */
    private function query($sql) {
        $statement = $this->getDb()->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            self::throwDbError($this->getDb()->errorInfo());
        }
        return $statement;
    }

    private static function throwDbError(array $errorInfo) {
        // TODO log error, send email, etc.
        throw new Exception('DB error [' . $errorInfo[0] . ', ' . $errorInfo[1] . ']: ' . $errorInfo[2]);
    }

    private static function formatDateTime(DateTime $date) {
        return $date->format(DateTime::ISO8601);
    }

}
