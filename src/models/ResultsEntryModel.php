<?php

namespace HJK\VbPhoenix;

class ResultsEntryModel extends AbstractResultModel {
    
    protected static $strTable = 'tl_hjk_vbphoenix_results_entry';







    public static function parseDownload ( DownloadModel $download ) {
        if ( $download->status != "ok" )
            throw new Exception ( "cannot parse error download!");
            
        if ( $download->type != "results" )
            throw new Exception ( "can only parse results downloads here!");
            
        
        $result = array ();
        $xml = simplexml_load_string($download->content);
        
        foreach ( $xml -> element as $element ) {
            
            $date = \DateTime::createFromFormat('d.m.Y', (string) $element->datum);
            $start = \DateTime::createFromFormat('d.m.Y H:i', (string) $element->datum . " " . (string) $element->spielbeginn);
            $opening = \DateTime::createFromFormat('d.m.Y H:i', (string) $element->datum . " " .(string) $element->hallenoeffnung);
            
            $resultsEntry = new ResultsEntryModel();
            $resultsEntry -> setRow ( array ( 
                'pid'          => $download->id,
                'game_id'      => (string) $element->nr,
                'date'         => $date ? $date->getTimestamp() : null,
                'time_opening' => $opening ? $opening->getTimestamp() : null,
                'time_start'   => $start ? $start->getTimestamp() : null,
                'team_home'    => (string) $element->heim,
                'team_guest'   => (string) $element->gast,
                'sets_home'    => (string) $element->sheim,
                'sets_guest'   => (string) $element->sgast,
                'result'       => (string) $element->result,
            ));
            
            $resultsEntry->save();
            $result[] = $resultsEntry;
        }        
        
        return $result;

    }


    
}
