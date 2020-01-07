<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $stock = 0;

    public static function boot()
    {
        parent::boot();

        // Generate slug before saving Model
        static::saving(function ($model) {
        });

        // create a event to happen on updating
        static::updating(function($model){
            
        });

        // create a event to happen on deleting
        static::deleting(function($model){
            $user = Auth::guard('admin')->user();
            $model->meta()->update([
                'updated_by' => $user->username,
            ]);
        });

        static::addGlobalScope('descending', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    static function scopePublished($query)
    {
      if ($query) $query->whereHas('meta', function ($metaQuery) {
            $metaQuery->where('published', 1)->orderBy('last_view', 'desc');
        });
    }

    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'model';
    }

    // public $primaryKey = ['id', 'model'];

    protected $casts = [
        // 'slug' => 'primaryKey',
    ];

    public function meta ()
    {
        return $this->hasOne('App\Models\Product\Meta', 'model', 'model');
    }
    
    public function tags ()
    {
        return $this->belongsToMany('App\Models\Product\Tag');
    }

    public function isPublished ()
    {
        return $this->meta()->wherePublished(1)->exists();
    }

    public function category ()
    {
        return $this->belongsTo('App\Models\Product\Category');
    }

    public function subcategory ()
    {
        return $this->belongsTo('App\Models\Product\Subcategory');
    }

    public function attributes ()
    {
        return $this->hasMany('App\Models\Product\Attribute');
    }

    public function attribute ($sku)
    {
        return $this->hasOne('App\Models\Product\Attribute')->where('sku', $sku)->first();
    }

    public function attributeFirst ()
    {
        return $this->hasOne('App\Models\Product\Attribute')->first();
    }

    public function attributeById ($id)
    {
        return $this->hasOne('App\Models\Product\Attribute')->where('id', $id)->first();
    }

    public function feature ()
    {
        return $this->belongsTo('App\Models\Product\Feature');
    }

    public function hasFeature ()
    {
        return $this->feature()->exists();
    }

    public function isNew ()
    {
        return $this->feature()->where('name', 'New')->exists();
    }

    public function isHot ()
    {
        return $this->feature()->where('name', 'Hot')->exists();
    }

    public function isOnSale ()
    {
        return $this->feature()->where('name', 'On Sale')->exists();
    }

    public function isFeatured ()
    {
        return $this->feature()->where('name', 'Featured')->exists();
    }

    public function isTopRated ()
    {
        return $this->feature()->where('name', 'Top Rated')->exists();
    }

    public function discount ()
    {
        return $this->hasOne('App\Models\Product\Discount', 'model', 'model');
    }

    public function hasDiscount(){
        return $this->discount()->exists();
    }

    public function isAvailable ($sku, $quantity)
    {
        return $this->stock($sku) > $quantity;
    }

    public function stock ($sku)
    {
        return $this->attribute($sku)->stock;
    }

    public function offer ()
    {
        return $this->belongsTo('App\Models\Frontend\Offer', 'model', 'model');
    }

    public function hasOffer(){
        return $this->offer()->exists();
    }

    public function wish ()
    {
        return $this->belongsTo('App\Models\Frontend\Customer\Wish', 'model', 'model');
    }

    public function belongsToOffer(){
        return $this->offer()->exists();
    }

    public function reviews ()
    {
        return $this->hasMany('App\Models\Product\Review')->approved();
    }

    public function report ()
    {
        return $this->hasOne('App\Models\Product\Report', 'model', 'model');
    }

    public function order_item ()
    {
        return $this->belongsTo('App\Models\Orders\OrderItem', 'model', 'model');
    }

    public function update_views ()
    {
        $this->meta->views++;
        $this->meta->last_view = Carbon::now();
        return $this->meta->save();
    }

    public function update_sales ($quantity, $price)
    {
        $this->report->increment('sales', $quantity);
        $this->report->increment('revenue', $price);
        return $this->report->save();
    }

    public function absolutePrice ()
    {
        if ($this->hasDiscount()) {
            return $this->price-($this->price*$this->discount()->first()->discount);
        } else if ($this->belongsToOffer()) {
            return $this->price-($this->price*$this->offer()->first()->discount);
        }

        return $this->price;
    }

    public function ratingAverage ()
    {
        $totalRating = 0;
        $totalReviews = count($this->reviews);

        foreach ($this->reviews as $review){
            $totalRating += $review->rating;
        }

        if (!$totalReviews == 0) {
            $averageRating = ($totalRating/$totalReviews);
        } else {
            $averageRating = 0;
        }
        
        return $averageRating;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'model', 'category_id', 'subcategory_id', 'feature_id', 'price', 'material', 'dimension', 'weight', 'fabrics', 'chamber', 'pockets', 'description',
    ];
}