<?php

namespace HJK\VbPhoenix;

abstract class AbstractResultModel extends \Model {
    

    private $aSetResults = array ();
    
    
    private function _initSetResults () {
        if ( $aSetResults ) return;
        
        $this->aSetResults = preg_split ('#\\s*,\\s*#', $this->result );
        
        for ( $i=0; $i<sizeof ( $this->aSetResults); $i++ ) {
            $this->aSetResults[$i] = explode ( ':', $this->aSetResults[$i]);
        }
    }


    public function getNumberOfSets () {
        $this->_initSetResults ();
        
        return sizeof ( $this->aSetResults );
    }
    
    
    public function getRalliesHome ( $set = false) {
        $this->_initSetResults();
        
        
        if ( ! $set ) {
            $result = 0;
            foreach ( $this->aSetResults as $setResult )
                $result += $setResult[0];
                
            return $result;
        } else {
            return @$this->aSetResults[ $set-1] [0];
        }
        
    }

    public function getRalliesGuest( $set = false) {
        $this->_initSetResults();

        if ( ! $set ) {
            $result = 0;
            foreach ( $this->aSetResults as $setResult )
                $result += $setResult[1];
                
            return $result;
        } else {
            return @$this->aSetResults[ $set-1] [1];
        }
    }
    
    
    public function hasGuestWon ( $set = false ) {
        $this->_initSetResults();

        if ( ! $set ) {
            return $this->setsGuest > $this->setsHome;
        } else {
            return $this->aSetResults[$set][1] > $this->aSetResults[$set][0];
        }
    }
    
    
    public function hasHomeWon ( $set = false ) {
        return ! $this->hasGuestWon ( $set );
    }


    
}
