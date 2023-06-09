<?php

namespace App\Models;

use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Class Product
 * @package App\Models
 */
class Product extends Model
{
    use Uploadable, HasTranslations;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Write down the fields that will be assignable
        // 'published',
        'title',
        'description',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        // Write down the default value of fields if necessary
        // 'published' => false,
    ];

    /**
     * The attributes that have multiple translation values
     *
     * @var array
     */
    public array $translatable = [
        // Write down the fields that will be translatable
        'title',
        'description',
    ];

    /**
     * The attributes that need to be resolved as file inputs.
     *
     * @var array
     */
    protected $uploadable = [
        // Write down the fields that will be resolved as file inputs.
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     * @noinspection NullPointerExceptionInspection
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            // $model->published = request()->has('published');
        });
    }

    /**
     * Method for json cast conversion.
     *
     * @param  mixed  $value
     *
     * @return bool|string
     */
    protected function asJson($value): bool|string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
