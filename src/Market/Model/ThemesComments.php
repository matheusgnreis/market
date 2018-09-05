<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class ThemesComments extends Model
{
    /** db table */
    protected $table = 'comment_themes';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'store_id', 'theme_id', 'date_time', 'comment', 'parent_comment_id'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;
}
