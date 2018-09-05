<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class ThemesEvaluation extends Model
{
    /** db table */
    protected $table = 'themes_evaluations';
    /** The attributes that are mass assignable. */
    protected $fillable = ['theme_id', 'store_id', 'date_time', 'stars'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;
}
