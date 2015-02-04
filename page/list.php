<?php

$status = Utils::getUrlParam('status');
ModelValidator::validateStatus($status);

$dao = new connManager();
$search = new daoSearchCriteria();
$search->setStatus($status);

// data for template
$name = Utils::capitalize($status) . ' Client Socials';
$client = $dao->find($search);

?>
