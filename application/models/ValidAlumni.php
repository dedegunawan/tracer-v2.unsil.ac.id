<?php
use Illuminate\Database\Eloquent\Model as Model;
class ValidAlumni extends Model {
	protected $table = 'cleaning_alumni';
    protected $fillable = ['temp_alumni_id', 'valid'];
    public $timestamps = false;
    function alumni_temp() {
        return $this->belongsTo('DataAlumniTemp', 'temp_alumni_id', 'id');
    }

}
