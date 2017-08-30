<?php


/**
 * Table tl_hjk_vbphoenis_squadrons
 */
$GLOBALS['TL_DCA']['tl_hjk_vbphoenix_squadron'] = array
(
        
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => false,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
                'phoenix_id' => 'unique',
            )
        )
    ),

    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('year desc','name'),
            'flag'                    => 1,
            'panelLayout'             => 'filter;search,limit',
        ),
        'label' => array
        (
            'fields'                  => array('year','name','phoenix_id'),
            'format'                  => '%s',
            'showColumns'            => true,
        ),
        'global_operations' => array
        (
            'upload'    => array (
                'label' => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['upload'],
                'href'  => 'key=upload',
                'icon'  => 'edit.gif',
            ),
            
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'down_table' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['down_table'],
                'href'                => 'key=down_table',
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
            'down_schedule' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['down_schedule'],
                'href'                => 'key=down_schedule',
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
            'down_results' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['down_results'],
                'href'                => 'key=down_results',
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
            'down_preview' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['down_preview'],
                'href'                => 'key=down_preview',
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
        )
    ),


    // Palettes
    'palettes' => array
    (
        'default'                     => '{name_legend},year,name,phoenix_id'
    ),

    // Subpalettes
    'subpalettes' => array
    (
        ''                            => ''
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'year' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['year'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'rgxp' => 'natural', 'minValue' => 2015, 'maxValue' => 2050, 'tl_class' => 'w50' ),
            'sql'                     => "smallint(5) NOT NULL default '0'",
            'default'                 => date("Y"),
            'filter'                  => true,
            'search'                  => true,
        ),
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['name'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255,'tl_class' => 'clr w50'),
            'sql'                     => "varchar(255) NOT NULL default ''",
            'filter'                  => true,
            'search'                  => true,
        ),
        'phoenix_id' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['phoenix_id'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array( 'mandatory' => true,'rgxp' => 'natural','tl_class' => 'w50'),
            'sql'                     => "int(10) NOT NULL default '0'",
            'filter'                  => true,
            'search'                  => true,
        ),
    ),
);




class tl_hjk_vbphoenix_squadron extends Backend
{


}
