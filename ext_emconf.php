<?php
$EM_CONF[$_EXTKEY] = array (
  'title' => 'Icon Check: show registered icons',
  'description' => 'Module for listing (all) registered icons',
  'category' => 'be',
  'author' => 'Josef Glatz',
  'author_email' => 'jousch@gmail.com',
  'author_company' => '',
  'state' => 'stable',
  'version' => '2.0.3',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '8.7.17-9.3.99',
    ),
    'conflicts' => 
    array (
    ),
    'suggests' => 
    array (
    ),
  ),
  'autoload' => 
  array (
    'psr-4' => 
    array (
      'JosefGlatz\\Iconcheck\\' => 'Classes',
    ),
  ),
);
