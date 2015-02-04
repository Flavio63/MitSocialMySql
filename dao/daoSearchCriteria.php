<?php

/**
 * Search criteria for {@link ClientSocials}.
 * <p>
 * Can be easily extended without changing the {@link TodoDao} API.
 */
final class daoSearchCriteria {

    private $status = null;


    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return TodoSearchCriteria
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

}

?>
