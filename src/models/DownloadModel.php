<?php

namespace HJK\VbPhoenix;

class DownloadModel extends \Model {

    protected static $strTable = 'tl_hjk_vbphoenix_download';
    
    
    /**
     * @brief parse the xml data of this download into the corresponding database table, if this hasn't been done before
     * @return  array database entry models
     */
    public function parseToDb () {
        if ( $this->status == "ok") {
            if ( $this->type == "schedule") {
                if ( $found = ScheduleEntryModel::findByPid ( $this->id))
                    return $found;
 
                return ScheduleEntryModel::parseDownload ( $this );
            } elseif ( $this->type == "table") {
                if ( $found = TableEntryModel::findByPid ( $this->id))
                    return $found;

                return TableEntryModel::parseDownload ( $this );
            } elseif ( $this->type == "results") {
                if ( $found = ResultsEntryModel::findByPid ( $this->id))
                    return $found;

                return ResultsEntryModel::parseDownload ( $this );
            } elseif ( $this->type == "preview") {
                if ( $found = PreviewEntryModel::findByPid ( $this->id))
                    return $found;

                return PreviewEntryModel::parseDownload ( $this );
            }
        }
        
    }



    /**
     * @brief get the database entries genereted from this download
     * @return  
     */
    public function getDbEntries () {
        if ( $this->status != "ok" )
            return array ();
            
        switch ( $this->type) {
            case "schedule":
                return ScheduleEntryModel::findByPid ( $this->id, array ("order" => "date, time_start, game_id"));
                break;
            case "table":
                return TableEntryModel::findByPid ( $this->id, array ( "order" => "position"));
                break;
            case "preview":
                return PreviewEntryModel::findByPid ( $this->id, array ( 'order' => 'date, time_start, game_id'));
                break;
            case "results":
                return ResultsEntryModel::findByPid ( $this->id, array ('order' => 'date, time_start, game_id'));
                break;
        }
        
        return array ();
    }
    
    
    
    
    /**
     * @brief get the game schedule in 'official' order
     * @return  collection of entries
     */
    public function getGamedaySchedule () {
        if ( $this->type != "schedule")
            throw new \Exception ("Gameday schedule can only be generated for schedule downloads!");
            
        return ScheduleEntryModel::findByPid ( $this->id, array ( "order" => "gameday, game_id, date, time_start"));
    }
    
    
    
}
