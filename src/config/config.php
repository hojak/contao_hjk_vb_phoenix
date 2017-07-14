<?php

// standard configuration values
$GLOBALS['TL_CONFIG']['hjk_vbphoenix_interval'] = 10;
$GLOBALS['TL_CONFIG']['hjk_vbphoenix_season']   = date('Y');
$GLOBALS['TL_CONFIG']['hjk_vbphoenix_baseurl']  = 'https://wvv.it4sport.de/data/vbnw/aufsteiger/public/';

/**
 * Back End Modules
 */
array_insert ( $GLOBALS['BE_MOD'],1, array ( 'hjk_vbphoenix' => array (
    'hjk_vbphoenix_squadrons'    =>	array (
        'icon'          => 'system/modules/hjk_vbphoenix/assets/images/volleyball.png',
        'tables'        => array ('tl_hjk_vbphoenix_squadron'),
        'upload'        => array ('\\HJK\\VbPhoenix\\BESquadrons', 'upload'),
        'down_schedule' => array ('\\HJK\VbPhoenix\\BEDownloads', 'actionFetchSchedule'),
        'down_preview'  => array ('\\HJK\VbPhoenix\\BEDownloads', 'actionFetchPreview'),
        'down_results'  => array ('\\HJK\VbPhoenix\\BEDownloads', 'actionFetchResults'),
        'down_table'    => array ('\\HJK\VbPhoenix\\BEDownloads', 'actionFetchTable'),
	),

    'hjk_vbphoenix_downloads'    =>	array (
        'icon'        => 'system/modules/hjk_vbphoenix/assets/images/db_down.png',
        'tables'      => array ('tl_hjk_vbphoenix_download'),
        'details'        => array ('HJK\\VbPhoenix\\BEDownloads','showDownload'),
	),
)));

/**
 * Frontend Modules
 */
/*
array_insert($GLOBALS['FE_MOD']['hjk_vbphoenix'], 0, array
(
    'hjk_week_plan'    => '\\HJK\\Bookings\\FEWeekPlan',
));
 * */


/**
 * Content Elements 
 **/
array_insert ( $GLOBALS['TL_CTE']['hjk_vbphoenix'],1,array(
   'hjk_vbphoenix_table'    => '\\HJK\\VbPhoenix\\CELeagueTable',
   'hjk_vbphoenix_preview'  => '\\HJK\\VbPhoenix\\CEPreview',
   'hjk_vbphoenix_results'  => '\\HJK\\VbPhoenix\\CEResults',
   'hjk_vbphoenix_schedule' => '\\HJK\\VbPhoenix\\CESchedule',
));

/**
 * Model Mappings 
 **/
$GLOBALS['TL_MODELS']['tl_hjk_vbphoenix_squadron']       = 'HJK\VbPhoenix\SquadronModel';
$GLOBALS['TL_MODELS']['tl_hjk_vbphoenix_download']       = 'HJK\VbPhoenix\DownloadModel';
$GLOBALS['TL_MODELS']['tl_hjk_vbphoenix_table_entry']    = 'HJK\VbPhoenix\TableEntryModel';
$GLOBALS['TL_MODELS']['tl_hjk_vbphoenix_preview_entry']  = 'HJK\VbPhoenix\PreviewEntryModel';
$GLOBALS['TL_MODELS']['tl_hjk_vbphoenix_results_entry']  = 'HJK\VbPhoenix\ResultsEntryModel';
$GLOBALS['TL_MODELS']['tl_hjk_vbphoenix_schedule_entry'] = 'HJK\VbPhoenix\ScheduleEntryModel';

