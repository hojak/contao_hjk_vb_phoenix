<?php

/*
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['vbphoenix_reference'] = array (
    'sql' => 'varchar(255) NULL',
);
*/ 

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['vbphoenix_squadron'] = array (
    'sql'         => 'int(10) unsigned NULL',
    'relation'    => array ('type' => 'hasOne', 'load' =>'lazy', ),
    'foreignKey'  => 'tl_hjk_vbphoenix_squadron.name',
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['vbphoenix_gameid'] = array (
    'sql'         => 'int(10) unsigned NULL',
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['vbphoenix_guest_ours'] = array (
    'inputType'   => 'checkbox',
    'default'     => '',
    'sql'         => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['vbphoenix_home_ours'] = array (
    'inputType'   => 'checkbox',
    'default'     => '',
    'sql'         => "char(1) NOT NULL default ''",
);


/**

update tl_calendar_events set vbphoenix_squadron = substring_index(vbphoenix_reference,'/',1) where vbphoenix_reference is not null;
update tl_calendar_events set vbphoenix_gameid = substring_index(vbphoenix_reference,'/',-1) where vbphoenix_reference is not null;

*/