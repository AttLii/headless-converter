<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once "mocks/WP_Post.php";
require_once "mocks/WP_Term.php";

define("UNIT_TESTING", true);

WP_Mock::bootstrap();