<?php


namespace HJK\VbPhoenix;

class BEDownloads extends \Backend {
    

    public function showDownload () {
        $id = \Input ::get('id');
        $download = DownloadModel::findById ( $id );
        
        if ( ! $download ) {
            error_log ( "Download " . $id . " not found!");
            $this->redirect('contao/main.php?act=error');            
        }
 
        \System::loadLanguageFile ( 'tl_hjk_vbphoenix_download');
       
        $result = '
<div id="tl_buttons">
<a href="'.$this->addToUrl ('key=&season=').'" class="header_back" title="" accesskey="b">Zurück</a>
</div>

' . \Message::generate() .'

<div id="tl_soverview">
<div id="tl_moverview">
<h2>Daten</h2>
<table>
 <thead>
  <tr>
   <th>ID</th>
   <th>Staffel</th>
   <th>Saison</th>
   <th>Typ</th>
   <th>Datum</th>
   <th>Status</th>
  </tr>
 </thead>
 <tbody>
  <tr>
   <td>'.$download->id.'</td>
   <td>'.$download->getRelated('squadron')->name . '</td>
   <td>'.$download->season . '</td>
   <td>'.$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_options'][$download->type] . '</td>
   <td>'.$this->parseDate ('d.m.Y H:i:s', $download->date_download ). '</td>
   <td>'.$GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['status_options'][$download->status] . '</td>
  </tr>
 </table>    

<h2>Inhalt ('. $GLOBALS['TL_LANG']['tl_hjk_vbphoenix_download']['type_options'][$download->type] .', '. $download->id . ')</h2>
<pre>';

        if ( $download -> status == 'ok') {
            $dom = new \DOMDocument();

            // Initial block (must before load xml string)
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            // End initial block

            $dom->loadXML($download->content);
            $formatted = $dom->saveXML();

            $result .= htmlentities( $formatted );        
        } else {
            $result .= nl2br(  htmlentities ( $download->content));
        }


        $result .= '</pre>

<h2>Header</h2>
<pre>'.nl2br( htmlentities ( $download->response_status)).'</pre>
</div>
</div>
        ';
        
        $xml = simplexml_load_string($download->content);
        $result .=  "<pre>" . htmlentities( print_r ( $xml, 1)) . "</pre>";

        
        \Message::reset();
        
        return $result;            
        
    }
    
    
    public function actionFetchSchedule () {
        return $this->_fetchSomething ( "schedule"); 
    }
    
    
    public function actionFetchTable () {
         return $this->_fetchSomething ( "table"); 
    }
    
    
    public function actionFetchResults () {
        return $this->_fetchSomething ( "results"); 
    }

    public function actionFetchPreview () {
        return $this->_fetchSomething ( "preview"); 
    }

    
    protected function _fetchSomething ( $what ) {
        $season = \Input::get('season');
        if ( ! $season )
            $season = $GLOBALS['TL_CONFIG']['hjk_vbphoenix_season'];
            
        $id = \Input::get('id');
        $squad = SquadronModel::findById ( $id );
        
        if ( ! $squad ) {
            error_log ( "Squadron " . $id . " not found!");
            $this->redirect('contao/main.php?act=error');
        }
        
        $result = self::fetchPhoenixData ( $squad, $season, $what );
        
        if( $result->status == "old") {
            \Message::addInfo ( "Download enthielt keine neuen Daten!" );
        } elseif ( $result -> status == 'ok') {
            \Message::addInfo ( "Download erfolgreich gespeichert!");
            
            
        } else {
            \Message::addError ("Download fehlgeschlagen!");
        }

        $this->redirect ( $this->addToUrl ( 'do=hjk_vbphoenix_downloads&key=details&id=' . $result->id));
    }
    
    
    
    
    /**
     * @brief download data from the phoenix server and store it to the database
     * 
     * @param SquadronModel $squadron 
     * @param <unknown> $season 
     * @return DownloadModel   
     */
    public static function fetchPhoenixData ( SquadronModel $squadron, $season, $type ) {
        \Controller::loadDataContainer ('tl_hjk_vbphoenix_download');
        
        if ( ! in_array ( $type, array_keys( $GLOBALS['TL_DCA']['tl_hjk_vbphoenix_download']['fields']['type']['options']))) {
            throw new \Exception ( 'Unknown type: ' . $type );
        }
        
        $url = self::getUrl ( $type, $season, $squadron->phoenix_id );
            
        $response = self::getRemoteData ( $url );    
        
        $download = new DownloadModel();
        
        if ( $response['ok']) {            
            $old = self::_checkData ( $squadron, $type, $season, $response['content']);

            if ( $old ) {
                $result = new \stdclass;
                $result->id = $old->id;
                $result->status = "old";
                
                return $result;
            } else {
                $download -> status = 'ok';
            }
        } else {
            $download -> status = 'error';
        }
        
        $download->date_download = time();
        $download->tstamp = time();
        $download->season = $season;
        $download->squadron = $squadron->id;
        $download->type     = $type;
        $download->used_url = $url;
        $download->content = $response ['content'];
        $download->response_status = json_encode( $response['status'], JSON_PRETTY_PRINT);
        
        $download->save();
        
        $download->parseToDb ();
                
        return $download;
    }
    
    
    public static function fetchOrUpdatePhoenixData ( SquadronModel $squadron, $season, $type ) {
         \Controller::loadDataContainer ('tl_hjk_vbphoenix_download');
        
        if ( ! in_array ( $type, array_keys( $GLOBALS['TL_DCA']['tl_hjk_vbphoenix_download']['fields']['type']['options']))) {
            throw new \Exception ( 'Unknown type: ' . $type );
        }
        
        $url = self::getUrl ( $type, $season, $squadron->phoenix_id );
            
        $response = self::getRemoteData ( $url );    
        
        $download = new DownloadModel();
        
        if ( $response['ok'] ) {            
            $old = self::_checkData ( $squadron, $type, $season, $response['content']);

            if ( $old ) {
                $old->date_download = time();
                $old->save();
                return $old;
            } else {
                $download -> status = 'ok';
            }
        } else {
            $download -> status = 'error';
        }
        
        $download->date_download = time();
        $download->tstamp = time();
        $download->season = $season;
        $download->squadron = $squadron->id;
        $download->type     = $type;
        $download->used_url = $url;
        $download->content = $response ['content'];
        $download->response_status = json_encode( $response['status'], JSON_PRETTY_PRINT);
        
        $download->save();
        
        $download->parseToDb ();
                
        return $download;       
        
    }
    
    
    

    protected static function _checkData ( SquadronModel $squadron, $type, $season, $content ) {
        $found = DownloadModel::findOneBy ( 
            array ( 'squadron=?', 'type=?', 'season=?', 'content=?','status=?'),
            array ($squadron->id, $type, $season, $content, 'ok')
        );
        
        return $found;
    }
    
    
    public static function getUrl ( $type, $season, $phoenixId ) {
        if ( $type == 'table')
            $type_part = 'tabelle';
        elseif ( $type == 'schedule')
            $type_part = 'spielplan';
        elseif ( $type == 'results')
            $type_part = 'ergebnis';
        elseif ( $type == 'preview' )
            $type_part = 'vorschau';
        else {
            throw new \Exception ( "Unknown Type: " . $type );
        }
        
        return $GLOBALS['TL_CONFIG']['hjk_vbphoenix_baseurl'] . $type_part . "_" . $season . "_" . $phoenixId . ".xml";  
    }
    
    
    
    
    
    
    public static function getRemoteData($url)	{
        $curl = curl_init();
        
        $options = array (
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT      => 'Contao Module hjk/vb_phoenix',
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_FOLLOWLOCATION => ( ini_get('open_basedir') || ini_get('safe_mode')) ? 1 : 0,
            CURLOPT_CONNECTTIMEOUT => 10,
            //CURLOPT_REFERER        => '',
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_ENCODING       => 'gzip,deflate',
        );
        
        curl_setopt_array( $curl, $options );
        
        $data   = curl_exec($curl);
        $status = curl_getinfo($curl);
        curl_close($curl);
    
        if ( $status['http_code'] != 200 ) { 
            return array(
                'content'   => $data,
                'status'    => $status,
                'http_code' => $status['http_code'],
                'ok'        => false,
                'error'     => true,
            );  
                
        } else {
            return array(
                'content'   => $data,
                'status'    => $status,
                'http_code' => $status['http_code'],
                'ok'        => true,
                'error'     => false,
            );  
        }  
    }    
}