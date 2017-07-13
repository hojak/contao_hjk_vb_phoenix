<?php


/**
 * Table tl_hjk_vbphoenix_download
 */
$GLOBALS['TL_DCA']['tl_hjk_vbphoenix_table_entry'] = array
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
            'fields'                  => array('position'),
            'flag'                    => 11,
        ),
        'label' => array (
            'fields'                  => array('position','team','matches','p3_wins','p3_losses','sets_pos', 'sets_neg', 'rallies_pos', 'rallies_neg'),
            'showColumns'            => true,
            //'label_callback'         => array ('tl_hjk_vbphoenix_table_entry', 'getRowLabel'),
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
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['pid'],            
            'relation'                => array ('type' => 'hasOne', 'load' => 'lazy',),
            'foreignKey'              => 'tl_hjk_vbphoenix_download.id',
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'position' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['position'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
            'filter'                  => true,
            'search'                  => true,
        ),
        'team' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['team'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(255) NOT NULL default ''",
            'filter'                  => true,
            'search'                  => true,
        ),
        'matches' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['matches'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'sets_pos' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['sets_pos'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'sets_neg' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['sets_neg'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'rallies_pos' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['rallies_pos'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'rallies_neg' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['rallies_neg'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_points' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_points'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_position' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_position'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_points' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_position'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_wins' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_wins'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_losses' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_losses'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_wins_3031' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_wins_3031'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_wins_30' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_wins_30'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_wins_31' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_wins_31'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_wins_32' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_wins_32'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_wins_20' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_wins_20'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_wins_21' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_wins_21'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_losses_0313' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_losses_0313'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_losses_03' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_losses_03'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_losses_13' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_losses_13'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_losses_23' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_losses_23'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_losses_02' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_losses_02'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        'p3_losses_12' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_table_entry']['p3_losses_01'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'sql'                     => "smallint(5) unsigned NOT NULL default '0'",
        ),
        
    ),
        
        
);



class tl_hjk_vbphoenix_table_entry extends \Backend {
    
        public function getRowLabel ($row, $label, DataContainer $dc, $args) {
        }
}