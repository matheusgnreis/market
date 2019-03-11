<?php
namespace Market\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Partner extends Model
{
    /** db table */
    protected $table = 'partners';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'name', 'member_since', 'avg_stars', 'evaluations', 'path_image', 'profile_json'];
    /** The attributes that will be hidden */
    protected $hidden = ['password_hash', 'credit'];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;

    public function applications()
    {
        return $this->hasMany(Apps::class, 'partner_id', 'id');
    }

    public function themes()
    {
        return $this->hasMany(Themes::class, 'partner_id', 'id');
    }

    public function components()
    {
        return $this->hasMany(Widgets::class, 'partner_id', 'id');
    }
}
