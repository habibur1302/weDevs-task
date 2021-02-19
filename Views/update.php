<?php
include_once ('../vendor/autoload.php');
use weTask\Product\Product;
$obj = new Product();
$obj->prepare($_POST)->update();