<?php
$EM_CONF[$_EXTKEY] = [
  'title' => 'Icon Check: show registered icons',
  'description' => 'Module for listing (all) registered icons',
  'category' => 'be',
  'author' => 'Josef Glatz',
  'state' => 'stable',
  'version' => '1.0.2',
  'constraints' =>
  [
    'depends' =>
    [
      'typo3' => '8.7.0-9.3.99',
    ],
    'conflicts' =>
    [
    ],
    'suggests' =>
    [
    ],
  ],
  'autoload' =>
  [
    'psr-4' =>
    [
      'JosefGlatz\\Iconcheck\\' => 'Classes',
    ],
  ],
];
