<?php

namespace HJK\VbPhoenix;


class BESquadrons extends \Backend {
    
    const FORM_ID = 'hjk_squadron_upload';
    const TEMPLATE = 'be_hjk_vbphoenix_squad_upload';
    
    
    public function upload () {
        if (\Input::post('FORM_SUBMIT') == self::FORM_ID ) {
            
            if ( $csv = $_FILES[ 'csv_file'] ) {
                if ($csv['error']) {
                    \Message::addError ( "Fehler beim Datei-Upload: " . $csv['error']);
                } else {
                    $this->_import ( $csv['tmp_name'], \Input::post('clear'), \Input::post ('separator'));
                }
            }
        }
        
        $this->strTemplate = self::TEMPLATE;
        $this->Template  = new \BackendTemplate($this->strTemplate);
        
        $this->Template->action = ampersand(\Environment::get('request'));
        $this->Template->formId = self::FORM_ID;
        $this->Template->fileUpload = $fileUpload;
        
        return $this->Template->parse();
    }
    
    
    
    
    protected function _import ($file, $clear, $separator ) {
        $this->import ('Database');
        
        if ( $clear ) {
            $this->Database->prepare ('TRUNCATE tl_hjk_vbphoenix_squadron')->execute();
            \Message::addInfo ("Staffel-Tabelle wurde gelöscht!");
        }
        
        
        $fh = fopen ( $file, "r" );
        if ( ! $fh ) return $this->_importError( "Error opening upload file " . $file . "!");
        
        $lineNumber = $impored = $errors = $ignored = 0;
        while ( ! feof ( $fh ) && ( $line = fgetcsv ( $fh, 0, $separator ) ) ) {
            $lineNumber ++;
            if ( ! $line[0] && ! $line[1]) {
                \Message::addInfo ( "Zeile " . $lineNumber. ": ignoriert - " . implode ( $separator, $line));
                $ignored++;
            } else {
                if ( $line[0] && $line[1] && $line[2] ) {                
                    try {
                        $this->Database
                            ->prepare ( "INSERT INTO tl_hjk_vbphoenix_squadron (tstamp, name, phoenix_id, year) VALUES (?,?,?,?)")
                            ->execute ( time(), $line[2], $line[0], $line[1]);
                        $imported++;
                    } catch ( Exception $e ) {
                        $errors++;
                        \Message::addError ( "Zeile " . $lineNumber . ": Fehler beim Import: " . $e->getMessage() . " / " . implode ( $separator, $line));
                    }
                } else {
                    \Message::addError ( "Zeile " . $linenumber . ": Informationen fehlen. Zeile: " . implode ( $separator, $line) . '  Trenner: ' . $separator);
                }
            }
        }
        
        fclose ( $fh );
        
        \Message::addInfo ( $imported . " Staffeln wurden importiert, " . $ignored . " Zeile ignoriert. Es traten " . $errors . " Fehler auf.");
    }
    
    
    protected function _importError ( $message ) {
        \Message::addError ( $message );
        return false;
    }
    
    
}