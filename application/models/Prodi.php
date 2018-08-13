<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 *
 */
class Prodi extends Eloquent
{
  public $timestamps = false;
  protected $table = 'prodi';
  protected $primaryKey = 'ProdiID';
  function fakultas() {
    return $this->belongsTo('Fakultas', 'FakultasID');
  }
  function jenjang() {
    return $this->belongsTo('Jenjang', 'JenjangID');
  }

}
