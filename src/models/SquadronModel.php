<?php


namespace HJK\VbPhoenix;

class SquadronModel extends \Model {
    
    protected static $strTable = 'tl_hjk_vbphoenix_squadron';


    /**
     * @brief get the latest table download for this squadron from phoenix, if a table hasn't been loaded yet a download will be triggered and the result returned.  
     * 
     * @param string $season 
     * @return  DownloadModel
     */
    public function getLastTableDownload ( $season ) {
        $found = DownloadModel::findOneBy ( 
            array ( "squadron=?", "season=?", "type=?", 'status=?'),
            array ( $this->id, $season, "table",'ok'),
            array ( "order" => "date_download desc")
        );
        
        if ( $found )
            return $found;
        else
            return BEDownloads::fetchPhoenixData ( $this, $season, "table" );
    }
    
    
    
    /**
     * @brief get the current download or get a new one, if it is outdated or not yet loaded
     * @param string $type 
     * @param string/int $season 
     * @return  DownloadModel
     */
    public function getCurrentDownload ( $type, $season ) {
        $found = DownloadModel::findOneBy (
            array ( "squadron=?", "type=?", "season=?", "status=?"),
            array ( $this->id, $type, $season, "ok"),
            array ( "order" => "date_download desc")
        );
        
        if ( ! $found || $found->date_download < (time() - $GLOBALS['TL_CONFIG']['hjk_vbphoenix_interval']*3600 )) {
            // force new download
            $download = BEDownloads::fetchOrUpdatePhoenixData( $this, $season, $type );
            if ( $download ->status == "ok" ) 
                return $download;
            else
                return null;
        } else {
            return $found;
        }
    }

    
}