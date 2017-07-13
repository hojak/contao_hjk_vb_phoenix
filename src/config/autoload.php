<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'HJK',
	'HJK\\VbPhoenix',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    //'DC_HJK_Applications'                           => 'system/modules/hjk_bookings/classes/DC_HJK_Applications.php',
    'HJK\\VbPhoenix\\AbstractResultModel' => 'system/modules/hjk_vbphoenix/models/AbstractResultModel.php',

    // Models
    'HJK\\VbPhoenix\\SquadronModel'      => 'system/modules/hjk_vbphoenix/models/SquadronModel.php',
    'HJK\\VbPhoenix\\DownloadModel'      => 'system/modules/hjk_vbphoenix/models/DownloadModel.php',
    'HJK\\VbPhoenix\\TableEntryModel'    => 'system/modules/hjk_vbphoenix/models/TableEntryModel.php',
    'HJK\\VbPhoenix\\ScheduleEntryModel' => 'system/modules/hjk_vbphoenix/models/ScheduleEntryModel.php',
    'HJK\\VbPhoenix\\ResultsEntryModel'  => 'system/modules/hjk_vbphoenix/models/ResultsEntryModel.php',
    
    // BE-Modules
    'HJK\\VbPhoenix\\BESquadrons'   => 'system/modules/hjk_vbphoenix/classes/BESquadrons.php',
    'HJK\\VbPhoenix\\BEDownloads'      => 'system/modules/hjk_vbphoenix/classes/BEDownloads.php',

    // FE-Modules
    //'HJK\\Bookings\\FEWeekPlan'   => 'system/modules/hjk_bookings/modules/FEWeekPlan.php',


    // ContentElements
    'HJK\\VbPhoenix\\CELeagueTable'      => 'system/modules/hjk_vbphoenix/elements/CELeagueTable.php',
    'HJK\\VbPhoenix\\CEResults'          => 'system/modules/hjk_vbphoenix/elements/CEResults.php',
    'HJK\\VbPhoenix\\CESchedule'         => 'system/modules/hjk_vbphoenix/elements/CESchedule.php',


    // other
    //'HJK\\Bookings\\DateHelpers' => 'system/modules/hjk_bookings/classes/DateHelpers.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array(
    'be_hjk_vbphoenix_squad_upload'  => 'system/modules/hjk_vbphoenix/templates',

	'ce_hjk_vbphoenix_table'         => 'system/modules/hjk_vbphoenix/templates',
	'ce_hjk_vbphoenix_schedule'      => 'system/modules/hjk_vbphoenix/templates',
	'ce_hjk_vbphoenix_results'       => 'system/modules/hjk_vbphoenix/templates',
));
