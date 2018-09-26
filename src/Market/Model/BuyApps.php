<?php
namespace Market\Model;

use Illuminate\Database\Eloquent\Model;

class BuyApps extends Model
{
    /** db table */
    protected $table = 'buy_apps';
    /** The attributes that are mass assignable. */
    protected $fillable = ['id','app_id','store_id','date_init','date_end','date_renovation','type_plan','app_value','payment_status','plan_id','id_transaction'];
    /** The attributes that will be hidden */
    protected $hidden = [];
    /** Indicates if the model should be timestamped. */
    public $timestamps = false;

    public function app()
    {
        return $this->hasOne(Apps::class, 'id', 'app_id');
    }

    //TODO
    public function transation()
    {
    }

    public function store()
    {
    }
}
