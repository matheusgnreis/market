<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class Installations extends Model
{
    /** db table */
    protected $table = 'widgets_installed';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'widget_id', 'installed_at', 'store_id', 'state', 'status'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    // primary key
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;

    /**
     * Create partner relationship with app
     *
     * @return void
     */
    public function widgets()
    {
        return $this->hasMany(Widgets::class, 'app_id', 'id');
    }
}
