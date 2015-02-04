<?php

$clientsocials = Utils::getClientSocialsByGetId();
$clientsocials->setStatus(Utils::getUrlParam('status'));

$dao = new connManager();
$dao->save($clientsocials);
//Flash::addFlash('Work status changed successfully.');

Utils::redirect('detail', array('id' => $clientsocials->getId()));

?>
