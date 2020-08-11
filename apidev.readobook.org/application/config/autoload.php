<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$autoload['packages'] = array();

$autoload['libraries'] = array('database', 'email', 'session');

$autoload['drivers'] = array();

$autoload['helper'] = array('url', 'file');

$autoload['config'] = array();

$autoload['language'] = array();

$autoload['model'] = array('Model_securityTokens');
