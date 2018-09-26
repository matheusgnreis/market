<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class ThemesImagens extends Model
{
    /** db table */
    protected $table = 'image_themes';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'theme_id', 'alt','name','path_image', 'width_px', 'height_px'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;
}
