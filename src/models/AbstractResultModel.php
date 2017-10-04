<?php

namespace HJK\VbPhoenix;

abstract class AbstractResultModel extends \Model {
    

    private $aSetResults = array ();
    
    
    private function _initSetResults () {
        if ( $this->aSetResults ) return;
        
        if ( $this->result ) {
        
            $this->aSetResults = preg_split ('#\\s*,\\s*#', $this->result );
            
            for ( $i=0; $i<sizeof ( $this->aSetResults); $i++ ) {
                $this->aSetResults[$i] = explode ( ':', $this->aSetResults[$i]);
            }
        } else {
            $this->aSetResults = array ();
        }
    }
    
    public function hasResult() {
        return true && $this->result;
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
            return $this->sets_guest > $this->sets_home;
        } else {
            return $this->aSetResults[$set-1][1] > $this->aSetResults[$set-1][0];
        }
    }
    
    
    public function hasHomeWon ( $set = false ) {
        return ! $this->hasGuestWon ( $set );
    }


    public function hasWon ( $team, $set = false ) {
        return ($this->team_home == $team && $this->hasHomeWon( $set ))
            || ($this->team_guest == $team && $this->hasGuestWon( $set ));
    }
    
    public function hasLost ( $team, $set = false ) {
        return ($this->team_guest == $team && $this->hasHomeWon( $set ))
            || ($this->team_home == $team && $this->hasGuestWon( $set ));
    }
    
    

    
}
