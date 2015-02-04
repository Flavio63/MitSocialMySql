<?php

$clientsocials = Utils::getClientSocialsByGetId();

$dao = new connManager();
$dao->delete($clientsocials->getId());
//Flash::addFlash('Work deleted successfully.');

Utils::redirect('list', array('status' => $clientsocials->getStatus()));

?>
