<?php

namespace HJK\VbPhoenix;


class CELeagueTable extends \ContentElement {

        /**
         * Template
         * @var string
         */
        protected $strTemplate = 'ce_hjk_vbphoenix_table';


        public function generate () {
            
            if ( TL_MODE == "BE") {
                $template = new \BackendTemplate('be_wildcard');

                $template->wildcard = 
                        "### (HJK) VB-Phoenix: Tabelle ###";
                
                $template->title = $this->headline;
                $template->id = $this->id;
                //$template->link = $this->name;
                //$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

                return $template->parse();
            } else {
                return parent::generate();
            }

        }


        protected function compile () {
            
            $squadron = SquadronModel::findById ( $this->hjk_vbphoenix_squadron);
            
            $download = $squadron->getCurrentDownload ( "table", $this->hjk_vbphoenix_season);
            
            $this->Template->squadron = $squadron;
            
            if ( $download ) {
                $this->Template->entries = $download->getDbEntries ();
                $this->Template->download = $download;
            } else {
                $this->Template->downloadError = true;
            }
        }

}