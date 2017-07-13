<?php


/**
 * Table tl_hjk_vbphoenix_download
 */
$GLOBALS['TL_DCA']['tl_hjk_vbphoenix_download'] = array
(
        
    // Config
    'config' => array (
        'dataContainer'               => 'Table',
        'enableVersioning'            => false,
        'notEditable'                 => true,
        'notCopyable'                 => true,
        'notCreatable'                => true,
        'sql' => array (
            'keys' => array (
                'id' => 'primary',
            ),
        ),
    ),

    // List
    'list' => array (
        'sorting' => array (
            'mode'                    => 12,
            'fields'                  => array('date_download'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit',
        ),
        'label' => array (
            'fields'                  => array('squadron','season','type','date_download','status'),
            //'format'                  => '%s',
            'showColumns'            => true,
            'label_callback'         => array ('tl_hjk_vbphoenix_download', 'getRowLabel'),
        ),
        'global_operations' => array (
        ),
        'operations' => array (
            'delete' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'details' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['details'],
                'href'                => 'key=details',
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/details.png',
            ),
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
        'tstamp' => array (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'season' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['season'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true,'rgxp' => 'natural','minval' => 2015, 'maxval' => 2040,),
            'sql'                     => "int(6) unsigned NOT NULL default '2016'",
            'filter'                  => true,
            'search'                  => true,
        ),
        'squadron' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['squadron'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'relation'                => array ('load' => 'eager', 'type' => 'hasOne'),
            'foreignKey'              => 'tl_hjk_vbphoenix_squadron.name',
            'eval'                    => array('mandatory'=>true),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'filter'                  => true,
            'search'                  => true,
        ),
        'type' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_label'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array (
                'table'    => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_options']['table'],
                'results'  => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_options']['schedule'],
                'schedule' => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_options']['results'],
                'preview'  => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_options']['preview'],
            ),
            'eval'                    => array('mandatory'=>true),
            'sql'                     => "varchar(20) NOT NULL default ''",
            'filter'                  => true,
            'search'                  => true,
        ),
        'date_download' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['date_download'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp' => 'datim', 'mandatory' => true,),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",        
            'filter'                  => true,
            'search'                  => true,
        ),
        'used_url' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['used_url'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array(),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'content' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['content'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array(),
            'sql'                     => "text NULL",
        ),
        'response_status' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['response_status'],
            'exclude'                 => true,
            'inputType'               => 'textarea',
            'eval'                    => array(),
            'sql'                     => "text NULL",
        ),
        'status' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['status_label'],
            'exclude'                 => true,
            'inputType'               => 'select',
            'options'                 => array (
                'ok'    => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['status_options']['ok'],
                'error' => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['status_options']['error'],
            ),
            'eval'                    => array(),
            'sql'                     => "varchar(30) NOT NULL default ''",
            'filter'                  => true,
            'search'                  => true,
        ),
        
    ),
);



class tl_hjk_vbphoenix_download extends \Backend {
    
        public function getRowLabel ($row, $label, DataContainer $dc, $args) {

            $squad = \HJK\VbPhoenix\SquadronModel::findById ( $row['squadron']);
            
            return array (
                $squad->name,
                $row['season'],
                $GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_options'][ $row['type']] ,
                $this->parseDate ('d.m.Y H:i:s', $row['date_download']),
                $GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['status_options'][ $row['status']]
            );
        }
}