<?php
namespace Market\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Apps extends Model
{
    /** db table */
    protected $table = 'apps';
    protected $primaryKey = 'app_id';
    /** The attributes that are mass assignable. */
    protected $fillable = [
        'app_id',
        'partner_id',
        'title',
        'slug',
        'category',
        'icon',
        'description',
        'short_description',
        'json_body',
        'paid',
        'version',
        'version_date',
        'type',
        'module',
        'load_events',
        'script_uri',
        'github_repository',
        'authentication',
        'auth_callback_uri',
        'redirect_uri',
        'auth_scope',
        'avg_stars',
        'evaluations',
        'downloads',
        'website',
        'link_video',
        'plans_json',
        'value_plan_basic',
    ];
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

    /**
     * Create comments relationship with app
     *
     * @return void
     */
    public function comments()
    {
        return $this->hasMany(AppsComments::class, 'app_id', 'app_id');
    }

    /**
     * Create imagens relationship with app
     *
     * @return void
     */
    public function imagens()
    {
        return $this->hasMany(AppsImagens::class, 'app_id', 'app_id');
    }

    /**
     * Create evaluations relationship with app
     *
     * @return void
     */
    public function evaluations()
    {
        return $this->hasMany(AppsEvaluation::class, 'app_id', 'app_id');
    }
}
