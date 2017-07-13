<?php

namespace HJK\VbPhoenix;


class CESchedule extends \ContentElement {

        const TPL_LIST     = 'ce_hjk_vbphoenix_game_list';
        const TPL_TABLE    = 'ce_hjk_vbphoenix_game_table';
        const TPL_GAMEDAYS = 'ce_hjk_vbphoenix_gamedays';
    
        /**
         * Template
         * @var string
         */
        protected $strTemplate = self::TPL_LIST;
        
        


        public function generate () {
            
            if ( TL_MODE == "BE") {
                $template = new \BackendTemplate('be_wildcard');

                $template->wildcard = 
                        "### (HJK) VB-Phoenix: Spielplan ###";
                
                $template->title = $this->headline;
                $template->id = $this->id;
                //$template->link = $this->name;
                //$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

                return $template->parse();
            } else {

                switch ( $this->hjk_vbphoenix_display ) {
                    case 'vbphoenix_gamedays':
                        $this->strTemplate = self::TPL_GAMEDAYS;
                        break;
                    case 'vbphoenix_table':
                        $this->strTemplate = self::TPL_TABLE;
                        break;
                    default:
                }
                
                 $GLOBALS['TL_CSS'][] = 'system/modules/hjk_vbphoenix/assets/css/phoenix.css';
                
                return parent::generate();
            }

        }



        protected function compile () {
            $squadron = SquadronModel::findById ( $this->hjk_vbphoenix_squadron);
            
            $download = $squadron->getCurrentDownload ( "schedule", $this->hjk_vbphoenix_season);
            $this->Template->squadron = $squadron;
            
            if ( $download ) {
                
                if ( $this->hjk_vbphoenix_display == "vbphoenix_gamedays") {
                    $schedule = $download->getGamedaySchedule ();
                    $entries = array ();
                    foreach ( $schedule as $entry ) {
                        $entries[ $entry->gameday ][] = $entry;
                    }
                } elseif ( $this->hjk_vbphoenix_games != "all" && $this->hjk_vbphoenix_team ) {
                    $entries= array ();
                    
                    $team = $this->hjk_vbphoenix_team;
                    $mode = $this->hjk_vbphoenix_games;
                    
                    foreach ( $download->getDbEntries() as $entry ) {
                        if ( ($entry->team_home == $team && ($mode == "team" || $mode == "team_home"))
                                || ( $entry->team_guest == $team && ( $mode == "team" || $mode == "team_away") ) ) {
                            $entries[] = $entry;
                        }
                    }
                } else {
                    $entries = $download->getDbEntries ();
                }
                
                $this->Template->entries = $entries;
                $this->Template->download = $download;
                $this->Template->team = $this->hjk_vbphoenix_team;
            } else {
                $this->Template->downloadError = true;
            }
        }

}