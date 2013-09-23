<?php

include_once('app/Mage.php');
Mage::app();

$object = Mage::getSingleton('catalog/product');

echo '<pre>';
var_dump($object);