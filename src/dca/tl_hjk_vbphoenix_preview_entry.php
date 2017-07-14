<?php


/**
 * Table tl_hjk_vbphoenix_download
 */
$GLOBALS['TL_DCA']['tl_hjk_vbphoenix_preview_entry'] = array
(
        
    // Config
    'config' => array (
        'dataContainer'               => 'Table',
        'enableVersioning'            => false,
        'ptable'                      => 'tl_hjk_vbphoenix_download',
        'notEditable'                 => true,
        'notCopyable'                 => true,
        'notCreatable'                => true,
        
        'doNotDeleteRecords'          => false, /* delete entries when corresponding download is removed */
        
        'sql' => array (
            'keys' => array (
                'id' => 'primary',
            ),
        ),
    ),

    // List
    'list' => array (
        'sorting' => array (
            'mode'                    => 1,
            'fields'                  => array('gameday', 'date', 'time_start'),
            'flag'                    => 11,
        ),
        'label' => array (
            'fields'                  => array('gameday','date','time_start','team_home','team_guest'),
            'showColumns'             => true,
            //'label_callback'         => array ('tl_hjk_vbphoenix_preview_entry', 'getRowLabel'),
        ),
        'global_operations' => array (
        ),
        'operations' => array (
        ),
    ),


    // Palettes
    'palettes' => array (
        'default'                     => '{name_legend},name,phoenix_id'
    ),

    // Subpalettes
    'subpalettes' => array (
        ''                            => ''
    ),

    // Fields
    'fields' => array (
        'id' => array (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['pid'],            
            'relation'                => array ('type' => 'hasOne', 'load' => 'lazy',),
            'foreignKey'              => 'tl_hjk_vbphoenix_download.id',
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'game_id' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['game_id'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
            'filter'                  => true,
            'search'                  => true,
        ),
        'gameday' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['game_id'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
            'filter'                  => true,
            'search'                  => true,
        ),
        'date' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['date'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'eval'                    => array ('rgxp' => 'date'),
            'filter'                  => true,
            'search'                  => true,
        ),
        'time_opening' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['time_opening'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "int(10) unsigned NULL",
            'eval'                    => array ('rgxp' => 'time'),
            'filter'                  => true,
            'search'                  => true,
        ),
        'time_start' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['time_start'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'eval'                    => array ('rgxp' => 'time'),
            'filter'                  => true,
            'search'                  => true,
        ),
        'team_home' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['team_home'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(255) NOT NULL default ''",
            'filter'                  => true,
            'search'                  => true,
        ),
        'team_guest' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['team_guest'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(255) NOT NULL default ''",
            'filter'                  => true,
            'search'                  => true,
        ),
        'gym' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_preview_entry']['gym'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
               
    ),
        
);



class tl_hjk_vbphoenix_preview_entry extends \Backend {
    
        
}                    