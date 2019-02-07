<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class AppsEvaluation extends Model
{
    /** db table */
    protected $table = 'apps_evaluations';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'app_id', 'store_id', 'date_time', 'stars'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;
}
