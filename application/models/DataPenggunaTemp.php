<?php
use Illuminate\Database\Eloquent\Model as Model;
class DataPenggunaTemp extends Model {
	protected $table = 'data_pengguna_temp';
    function jawaban_pengguna_temp() {
        return $this->hasMany('JawabanPenggunaTemp', 'pengguna_temp_id', 'id');
    }
	function prodiObject() {
        return $this->belongsTo('Prodi', 'prodi', 'ProdiID');
    }
}
