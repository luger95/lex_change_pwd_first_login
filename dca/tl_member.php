<?php

$GLOBALS['TL_DCA']['tl_member']['subpalettes']['login'].= ',pwChange';
$GLOBALS['TL_DCA']['tl_member']['fields']['pwChange'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['MOD']['tl_member']['pwChange'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'filter'                  => true,
	'sql'                     => "char(1) NOT NULL default ''"
);

