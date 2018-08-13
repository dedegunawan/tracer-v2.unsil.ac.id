<?php
use Illuminate\Database\Eloquent\Model as Model;
class JawabanAlumniTemp extends Model {
	protected $table = 'jawaban_alumni_temp';
    protected $fillable = ['alumni_temp_id', 'pertanyaan_id', 'jawaban'];
    function data_alumni_temp() {
        return $this->belongsTo('DataAlumniTemp', 'alumni_temp_id', 'id');
    }


}
