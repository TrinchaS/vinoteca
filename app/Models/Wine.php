<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\ImageUrl;
use App\Traits\WithCurrencyFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wine extends Model
{
    use HasSlug;
    use ImageUrl;
    use WithCurrencyFormatter;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'year',
        'price',
        'stock',
        'image'
    ];

    protected function casts():array{
        return [
            'year' => 'integer',
            'price' => 'decimal:2',
            'stock' => 'integer'
        ];
    }

    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }

    //formatted_price
    public function formattedPrice():Attribute{
        return Attribute::make(
            get : fn () => $this->formatCurrency($this->price)
        );
    }
}
