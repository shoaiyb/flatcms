<?php
/**
 * @package FlatCMS
 * @author shoaiyb sysa
 * @see https://www.flatcms.ml
 * @license GNU
 */

session_start();
define('VERSION', '1.0');
mb_internal_encoding('UTF-8');

if (defined('PHPUNIT_TESTING') === false) {
	$Fcms = new Fcms();
	$Fcms->init();
	$Fcms->render();
}
