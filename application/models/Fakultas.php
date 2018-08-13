<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 *
 */
class Fakultas extends Eloquent
{
  public $timestamps = false;
  protected $table = 'fakultas';
  protected $primaryKey = 'FakultasID';
  function prodi() {
    return $this->hasMany('Prodi', 'FakultasID');
  }

}
