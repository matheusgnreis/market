<?php
namespace Market\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Apps extends Model
{
    /** db table */
    protected $table = 'apps';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id', 'partner_id', 'title', 'slug', 'category', 'thumbnail', 'description', 'json_body', 'paid', 'version', 'version_date', 'type', 'module', 'load_events', 'script_uri', 'github_repository', 'authentication', 'auth_callback_uri', 'auth_scope', 'avg_stars', 'evaluations', 'website', 'link_video', 'plans_json', 'value_plan_basic', 'active'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;
    
    /**
     *  Create evaluations relationship with app
     *
     * @return void
     */
    public function evaluations()
    {
        return $this->hasMany(AppsEvaluation::class);
    }
    
    /**
     * Create partner relationship with app
     *
     * @return void
     */
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
    
    /**
     * Create comments relationship with app
     *
     * @return void
     */
    public function comments()
    {
        return $this->hasMany(AppsComments::class);
    }

    /**
     * Create imagens relationship with app
     *
     * @return void
     */
    public function imagens()
    {
        return $this->hasMany(AppsImagens::class);
    }
}
