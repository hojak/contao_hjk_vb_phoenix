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
            'fields'                  => array('name'),
            'flag'                    => 1
        ),
        'label' => array
        (
            'fields'                  => array('name','phoenix_id'),
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
                'href'                => 'key=down_table&season='.$GLOBALS['TL_CONFIG']['hjk_vbphoenix_season'] ,
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
            'down_schedule' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['down_schedule'],
                'href'                => 'key=down_schedule&season='.$GLOBALS['TL_CONFIG']['hjk_vbphoenix_season'],
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
            'down_results' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['down_results'],
                'href'                => 'key=down_results&season='.$GLOBALS['TL_CONFIG']['hjk_vbphoenix_season'],
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
            'down_preview' => array (
                'label'               => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['down_preview'],
                'href'                => 'key=down_preview&season='.$GLOBALS['TL_CONFIG']['hjk_vbphoenix_season'],
                'icon'                => 'system/modules/hjk_vbphoenix/assets/images/xml_down.png',
            ),
        )
    ),


    // Palettes
    'palettes' => array
    (
        'default'                     => '{name_legend},name,phoenix_id'
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
        'name' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['name'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
            'sql'                     => "varchar(255) NOT NULL default ''",
        ),
        'phoenix_id' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_squadron']['phoenix_id'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array( 'mandatory' => true,'rgxp' => 'natural'),
            'sql'                     => "int(10) NOT NULL default '0'",
        ),
    ),
);




class tl_hjk_vbphoenix_squadron extends Backend
{


}
