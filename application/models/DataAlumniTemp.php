<?php
use Illuminate\Database\Eloquent\Model as Model;
class DataAlumniTemp extends Model {
	protected $table = 'data_alumni_temp';
    function jawaban_alumni_temp() {
        return $this->hasMany('JawabanAlumniTemp', 'alumni_temp_id', 'id');
    }
    function prodiObject() {
        return $this->belongsTo('Prodi', 'prodi', 'ProdiID');
    }
}
