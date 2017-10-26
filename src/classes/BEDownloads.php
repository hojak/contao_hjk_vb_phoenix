<?php


namespace HJK\VbPhoenix;

class BEDownloads extends \Backend {
    
    
    const CREATE_FORM_ID = 'vbphoenix_create_dates';
    const CREATE_TEMPLATE = 'be_hjk_vbphoenix_create_dates';
    
    
    
    protected function _updateEvent ( $event, $entry, $team ) {
        $event->title     = $entry->team_home . " – " . $entry->team_guest;
        $event->location  = $entry->gym;
        $event->startTime = $entry->time_start;
        $event->startDate = $entry->time_start;
        $event->author    = $this->User->id;

        // just "enable" our flag, don't disable, to prevent unmarking team of matches inside the same club
        if ( $entry->team_home == $team) {
            $event->vbphoenix_home_ours = '1';
        } elseif ( $entry->team_guest == $team )  {
            $event->vbphoenix_guest_ours = '1';
        } else {
            \Message::addInfo ('no own team?!?!');
        }
        
        $event->save();
        
        \Message::addInfo ( "Spiel ID " . $entry->game_id . ", Event " . $event->id . " wurde aktualisiert");
    }
    
    
    protected function _createEvent ( $entry, $team, $download) {
        $newEntry = new \CalendarEventsModel();
        $newEntry->pid       = $calendar->id;
        $newEntry->tstamp    = time();
        $newEntry->title     = $entry->team_home . " – " . $entry->team_guest;
        $newEntry->addTime   = '1';
        $newEntry->startTime = $entry->time_start;
        $newEntry->startDate = $entry->time_start;
        $newEntry->location  = $entry->gym;
        $newEntry->published = '1';
        $newEntry->vbphoenix_squadron = $download->squadron;
        $newEntry->vbphoenix_gameid   = $entry->game_id;
        $newEntry->author    = $this->User->id;
        
        if ( $entry->team_home == $team)
            $newEntry->vbphoenix_home_ours = '1';
        elseif ( $entry->team_guest == $team ) 
            $newEntry->vbphoenix_guest_ours = '1';
        
        $newEntry->save();
        \Message::addInfo ( "Spiel ID " . $entry->game_id . " wurde neu angelegt");
    }
    
    
    
    public function actionCreateDates () {
        $this->import('BackendUser', 'User');
        
        $id = \Input::get('id');
        $download = DownloadModel::findById ( $id );
        
        if ( ! $download ) {
            error_log ( "Download " . $id . " not found!");
            $this->redirect('contao/main.php?act=error');            
        } else if ( $download->type != "schedule"){
            error_log ( "Download " . $id . " ist not a schedule!");
            $this->redirect('contao/main.php?act=error');            
        }
            
        $squad = $download->getRelated ('squadron');
        
        if (\Input::post('FORM_SUBMIT') == self::CREATE_FORM_ID ) {
            // do the generation
            
            $team = \Input::post ( 'team');
            $calendar = \CalendarModel::findById ( \Input::post ('calendar') );
            $home_only = \Input::post ( 'home_only');
            
            if ( ! $calendar) {
                \Message::addError ("Der angegebene Kalender existiert nicht oder es wurde kein Kalender angegeben!");
            } elseif ( ! $team ) {
                \Message::addError ( "Es wurde kein Team ausgewählt!");
            } else {
                $generated = $updated = 0;
                foreach ( $download -> getDbEntries() as $entry ) {
                    if ( $entry->team_home == $team || ( !$home_only && $entry->team_guest == $team )) {
                        $reference = $download->squadron . "/" . $download->season . "/" . $entry->game_id;
                        
                        $existing = \CalendarEventsModel::findOneBy ( array('vbphoenix_squadron = ?','vbphoenix_gameid = ?'), array ( $download->squadron, $entry->game_id) );
                        
                        if ( $existing ) {
                            $this->_updateEvent ( $existing, $entry, $team );
                            $updated ++;
                        } else {
                            $this->_createEvent ( $entry, $team, $download);
                            $generated ++;
                        }
                    }
                }
                
                if ( $generated )
                    \Message::addInfo ( $generated . " Einträge wurden angelegt.");
                if ( $updated )
                    \Message::addInfo ( $updated . " Einträge wurden aktualisiert.");
            }
            
        }
            
        
        $this->strTemplate = self::CREATE_TEMPLATE;
        $this->Template  = new \BackendTemplate($this->strTemplate);
        
        $this->Template->action = ampersand(\Environment::get('request'));
        $this->Template->formId = self::CREATE_FORM_ID;
        
        $this->Template->calendarOptions = $this->_getCalendarOptions ();
        $this->Template->teamOptions = $this->_getTeamOptions( $download );
        
        $this->Template->squadron  = $squad;
        
        return $this->Template->parse();        
    }
    
        
    
    protected function _getCalendarOptions () {
        $dbResult = $this->Database->prepare ('select id, title from tl_calendar order by title')->execute();
        
        if ( $dbResult->numRows == 0 ) {
            return array ("0" => "Bitte legen Sie erst einen entsprechenden Kalender an!");
        }
        
        $result = array ();
        while ( $dbResult->next() )
            $result[] =  array ( "value" => $dbResult->id, "label" => $dbResult->title) ;
            
        return $result;
    }
    
    
    protected function _getTeamOptions ( $download ) {
        $result = array ();
        foreach ( $download->getTeams() as $team )
            $result[] = array ( "value" => $team, "label" => $team );
            
        return $result;
    }
    

    

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
        $id = \Input::get('id');
        $squad = SquadronModel::findById ( $id );
        
        if ( ! $squad ) {
            error_log ( "Squadron " . $id . " not found!");
            $this->redirect('contao/main.php?act=error');
        }
        
        $season = $squad->year;
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