<?php

/**
 *
 */
class DataMining
{
    function setData($data = array()) {
        $this->data = $data;
    }
    function mean($data = array()) {
        $dataCollection = collect($data);
        return $dataCollection->avg();
    }
    function meanData() {
        return $this->mean($this->data);
    }
    function standarDeviasi($data = array()) {
        $s2varian = $this->varian($data);
        return sqrt($s2varian);
    }
    function standarDeviasiData() {
        return $this->standarDeviasi($this->data);
    }
    function varian($data = array()) {
		//sum(x-x(mean))/(n-1)
        $mean = $this->mean($data);
        $count = count($data);
        $s2varian = collect();
        foreach ($data as $value) {
            $s2varian->push(($value-$mean)*($value-$mean));
        }
        return $s2varian->sum()/($count-1);
    }
    function varianData() {
        return $this->varian($this->data);
    }
}
