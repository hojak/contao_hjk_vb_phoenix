<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{hjk_vbphoenix_legend}'
    .',hjk_vbphoenix_baseurl,hjk_vbphoenix_interval,hjk_vbphoenix_season'
;    

$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_vbphoenix_baseurl'] = array (
  'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_vbphoenix_baseurl'],
  'exclude'       => true,
  'inputType'     => 'text',
  'eval'          => array('mandatory' => true, 'tl_class' => '','rgxp' => 'url'),
  'default'       => 'https://wvv.it4sport.de/data/vbnw/aufsteiger/public/',
);


$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_vbphoenix_interval'] = array (
    'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_vbphoenix_interval'],
    'exclude'       => true,
    'inputType'     => 'text',
    'eval'          => array('mandatory' => true, 'tl_class' => 'w50','minval' => 1, 'maxval' => 24*7, 'rgxp' => 'natural'),
    'default'       => 10,
);


$GLOBALS['TL_DCA']['tl_settings']['fields']['hjk_vbphoenix_season'] = array (
    'label'         => &$GLOBALS['TL_LANG']['tl_settings']['hjk_vbphoenix_season'],
    'exclude'       => true,
    'inputType'     => 'text',
    'eval'          => array('mandatory' => true, 'tl_class' => 'w50','minval' => 2015, 'maxval' => 2040, 'rgxp' => 'natural'),
    'default'       => date('Y'),
);
