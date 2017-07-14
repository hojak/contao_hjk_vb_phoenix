<?php

namespace HJK\VbPhoenix;


class CEPreview extends \ContentElement {

        /**
         * Template
         * @var string
         */
        protected $strTemplate = 'ce_hjk_vbphoenix_game_list';
        
        


        public function generate () {
            
            if ( TL_MODE == "BE") {
                $template = new \BackendTemplate('be_wildcard');

                $template->wildcard = 
                        "### (HJK) VB-Phoenix: Vorschau ###";
                
                $template->title = $this->headline;
                $template->id = $this->id;
                //$template->link = $this->name;
                //$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

                return $template->parse();
            } else {
                $GLOBALS['TL_CSS'][] = 'system/modules/hjk_vbphoenix/assets/css/phoenix.css';
                
                return parent::generate();
            }

        }



        protected function compile () {
            $squadron = SquadronModel::findById ( $this->hjk_vbphoenix_squadron);
            
            $download = $squadron->getCurrentDownload ( "schedule", $this->hjk_vbphoenix_season);
            $this->Template->squadron = $squadron;
            
            if ( $download ) {
                $entries = $download->getDbEntries ();
                                
                $this->Template->entries = $entries;
                $this->Template->download = $download;
                $this->Template->team = $this->hjk_vbphoenix_team;
            } else {
                $this->Template->downloadError = true;
            }
        }

}