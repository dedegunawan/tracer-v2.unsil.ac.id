<?php
use Illuminate\Database\Eloquent\Model as Model;
class JawabanPenggunaTemp extends Model {
	protected $table = 'jawaban_pengguna_temp';
    protected $fillable = ['pengguna_temp_id', 'pertanyaan_id', 'jawaban'];
    function data_alumni_temp() {
        return $this->belongsTo('DataPenggunaTemp', 'alumni_temp_id', 'id');
    }


}
