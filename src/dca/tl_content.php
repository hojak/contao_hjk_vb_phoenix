<?php

$GLOBALS['TL_DCA']['tl_content']['palettes']['hjk_vbphoenix_table']  =
    '{type_legend},type,headline;{hjk_vbphoenix_table_legend},hjk_vbphoenix_season,hjk_vbphoenix_squadron,hjk_vbphoenix_team;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
    
$GLOBALS['TL_DCA']['tl_content']['palettes']['hjk_vbphoenix_schedule']  =
    '{type_legend},type,headline;{hjk_vbphoenix_schedule_legend},hjk_vbphoenix_season,hjk_vbphoenix_squadron,hjk_vbphoenix_team,hjk_vbphoenix_games,hjk_vbphoenix_display;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
    
$GLOBALS['TL_DCA']['tl_content']['palettes']['hjk_vbphoenix_results']  =
    '{type_legend},type,headline;{hjk_vbphoenix_results_legend},hjk_vbphoenix_season,hjk_vbphoenix_squadron,hjk_vbphoenix_games,hjk_vbphoenix_team;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

/*
$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'hjk_vbphoenix_display';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['hjk_vbphoenix_display_phgamedays'] = '';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['hjk_vbphoenix_display_phtable'] = 'hjk_vbphoenix_games';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['hjk_vbphoenix_display_phlist']  = 'hjk_vbphoenix_games';
*/


$GLOBALS['TL_DCA']['tl_content']['fields']['hjk_vbphoenix_season'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_season'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array ('tl_content_vbphoenix', 'getSquadronSeasons'),
    'eval'                    => array (
        'mandatory'               => true, 
        'includeBlankOption'      => true, 
        'tl_class'                => 'w50', 
        'submitOnChange'          => true
    ),
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['hjk_vbphoenix_squadron'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_squadron'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array ('tl_content_vbphoenix', 'getSquadronOptions'),
    'eval'                    => array (
        'mandatory'               => true, 
        'includeBlankOption'      => true, 
        'tl_class'                => 'w50', 
        'submitOnChange'          => true
    ),
    'sql'                     => "int(10) unsigned NOT NULL default '0'",
);


$GLOBALS['TL_DCA']['tl_content']['fields']['hjk_vbphoenix_games'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_games_label'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array (
        'all'       => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_games_options']['all'],
        'team'      => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_games_options']['team'],
        'team_home' => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_games_options']['team_home'],
        'team_away' => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_games_options']['team_away'],
    ), 
    'default'                 => 'all',
    'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(10) NOT NULL default 'all'",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['hjk_vbphoenix_display'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_display_label'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options'                 => array (
        'phlist'       => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_display_options']['phlist'],
        'phtable'      => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_display_options']['phtable'],
        'phgamedays'   => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_display_options']['phgamedays'],
    ), 
    'default'                 => 'list',
    'eval'                    => array(
        'mandatory'      =>true, 
        'tl_class'       =>'w50',
        'submitOnChange' => true,
    ),
    'sql'                     => "varchar(30) NOT NULL default 'all'",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['hjk_vbphoenix_team'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['hjk_vbphoenix_team'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array ('tl_content_vbphoenix','getVbPhoenixTeams'),
    'sql'                     => "varchar(255) NULL",
    'eval'                    => array ('includeBlankOption' => true,'tl_class' => 'clr',)
);




class tl_content_vbphoenix extends \Backend {
    
    
    public function __construct () {
        $this->import ("Database");
    }
    
    
    public function getVbPhoenixTeams ( $currentDc ) {
        if ( !$currentDc->activeRecord->hjk_vbphoenix_season || ! $currentDc->activeRecord->hjk_vbphoenix_squadron ) {
            return array ( "0" => "Bitte wählen Sie zunächst eine Staffel und eine Saison aus!: " . $currentDc->activeRecord->hjk_vbphoenix_season . " / " . $currentDc->activeRecord -> hjk_vbphoenix_squadron);
        }
               
        $squadron = HJK\VbPhoenix\SquadronModel::findById ( $currentDc->activeRecord->hjk_vbphoenix_squadron);
        
        if ( ! $squadron ) {
            // somthings wrong, probable has the id table been updated!
            error_log ( "Staffel " . $currentDc->activeRecord->hjk_vbphoenix_squadron . " gibt es nicht (mehr) - Bitte die Staffel neu auswählen!");
            return array ();
        }
        
        $tableDl = $squadron->getLastTableDownload ( $currentDc->activeRecord->hjk_vbphoenix_season );
 
        if ( ! $tableDl || $tableDl->status != "ok") {
            error_log ( print_r ( $tableDl,1  ));
            return array ("0" => "Fehler beim Download der Staffel!");
        }
 
        $entries = $tableDl -> getDbEntries ();
        $result = array ();
        
        foreach ( $entries as $tableEntry ) {
            $result[] = $tableEntry->team;
        }
     
        sort ( $result );
        return $result;
    }
    
    
    public function getSquadronOptions ( $dc ) {
        $year = $dc->activeRecord->hjk_vbphoenix_season;
        
        if ( ! $year)
            return array ( "0" => "Bitte wählen Sie eine Saison aus, um die verfügbaren Staffeln angezeigt zu bekommen!");
        
        $dbResult = $this->Database->prepare ( "select id, name from tl_hjk_vbphoenix_squadron where year=? order by name")->execute( $year );
        
        if ( $dbResult->numRows == 0) {
            return array ( "0" => "Bitte fügen Sie die nötigen Staffel-Informationen hinzu oder wenden Sie sich an den Admin!");
        }
        
        $result = array ();
        while ( $dbResult->next () ) {
            $result[ $dbResult->id] = $dbResult->name;
        }
        
        return $result;
    }
    
    public function getSquadronSeasons () {
        $dbResult = $this->Database->prepare ('select distinct year from tl_hjk_vbphoenix_squadron order by year desc')->execute();
        
        if ( $dbResult->numRows == 0 ) {
            return array ("0" => "Keine Saisons gefunden. Bitte fügen Sie die nötigen Staffel-Informationen hinzu oder wenden Sich sich an den Admin!");
        }
        
        $result = array ();
        while ( $dbResult->next() )
            $result[] = $dbResult->year;
        
        return $result;
    }
    
}
    
    
    
    
    