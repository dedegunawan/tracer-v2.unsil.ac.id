<?php
use Illuminate\Database\Eloquent\Model as Model;
class ValidPengguna extends Model {
	protected $table = 'cleaning_pengguna';
    protected $fillable = ['temp_pengguna_id', 'valid'];
    public $timestamps = false;
    function pengguna_temp() {
        return $this->belongsTo('DataPenggunaTemp', 'temp_pengguna_id', 'id');
    }

}
