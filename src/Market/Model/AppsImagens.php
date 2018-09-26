<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class AppsImagens extends Model
{
    /** db table */
    protected $table = 'image_apps';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'app_id', 'alt', 'name', 'path_image', 'width_px', 'height_px'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;
}
