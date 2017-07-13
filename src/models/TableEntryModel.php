<?php

namespace HJK\VbPhoenix;

class TableEntryModel extends \Model {
    
    
    protected static $strTable = 'tl_hjk_vbphoenix_table_entry';
    
    
    


    public static function parseDownload ( DownloadModel $download ) {
        if ( $download->status != "ok" )
            throw new Exception ( "cannot parse error download!");
            
        if ( $download->type != "table" )
            throw new Exception ( "can only parse table downloads here!");
            
        $result = array ();
        $xml = simplexml_load_string($download->content);
    

        foreach ( $xml -> element as $element ) {
            $tableEntry = new TableEntryModel();
            $tableEntry -> setRow ( array ( 
                'pid'             => $download->id,
                'position'        => (string) $element->platz,
                'team'            => (string) $element->team,
                'matches'         => (string) $element->spiele,
                'sets_pos'        => (string) $element->plussaetze,
                'sets_neg'        => (string) $element->minussaetze,
                'rallies_pos'     => (string) $element->plusbaelle,
                'rallies_neg'     => (string) $element->minusbaelle,
                'p3_points'       => (string) $element->dppunkte,
                'p3_position'     => (string) $element->dpplatz,
                'p3_wins'         => (string) $element->dpsiege,
                'p3_losses'       => (string) $element->dpniederlagen,
                'p3_wins_3031'    => (string) $element->dpgewinn3031,
                'p3_wins_30'      => (string) $element->dpgewinn30,
                'p3_wins_31'      => (string) $element->dpgewinn31,
                'p3_wins_32'      => (string) $element->dpgewinn32,
                'p3_wins_20'      => (string) $element->dpgewinn20,
                'p3_wins_21'      => (string) $element->dpgewinn21,
                'p3_losses_0313'  => (string) $element->dpniederlage1303,
                'p3_losses_03'    => (string) $element->dpniederlage03,
                'p3_losses_13'    => (string) $element->dpniederlage13,
                'p3_losses_23'    => (string) $element->dpniederlage23,
                'p3_losses_02'    => (string) $element->dpniederlage12,
                'p3_losses_12'    => (string) $element->dpniederlage02,
            ));
            
            $tableEntry->save();
            $result[] = $tableEntry;
        }        
        
        return $result;
        
     }
}
