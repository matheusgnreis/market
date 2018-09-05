<?php
namespace Market\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Partner extends Model
{
    /** db table */
    protected $table = 'partners';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'name', 'password_hash', 'member_since', 'avg_stars', 'evaluations', 'path_image', 'profile_json', 'credit'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;
}
