<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    /** db table */
    protected $table = 'widgets';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'partner_id', 'title', 'slug', 'css', 'html', 'ejs', 'js', 'json_schema', 'icon'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;

    /**
     * Create partner relationship with app
     *
     * @return void
     */
    public function partner()
    {
        return $this->hasOne(Partner::class, 'id', 'partner_id');
    }
}
