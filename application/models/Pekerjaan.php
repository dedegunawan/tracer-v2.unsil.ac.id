<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 *
 */
class Pekerjaan extends Eloquent
{
  public $timestamps = false;
  protected $table = 'master_pekerjaan';
  protected $primaryKey = 'id_pekerjaan';

}
