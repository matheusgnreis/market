<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class Widgets extends Model
{
    /** db table */
    protected $table = 'widgets';
    /** The attributes that are mass assignable. */
    protected $fillable = ['app_id', 'partner_id', 'title', 'slug', 'url_css', 'template', 'url_js', 'config', 'icon', 'short_description', 'description', 'category', 'version', 'version_date', 'paid', 'active', 'website', 'downloads', 'plans_json'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    // primary key
    protected $primaryKey = 'app_id';

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
