<?php
$EM_CONF[$_EXTKEY] = array (
  'title' => 'Icon Check: show registered icons',
  'description' => 'Module for listing all registered icons',
  'category' => 'be',
  'author' => 'Josef Glatz',
  'state' => 'stable',
  'version' => '1.0.1',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '8.7.0-8.7.99',
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
      'JosefGlatz\\IconCheck\\' => 'Classes',
    ),
  ),
);
