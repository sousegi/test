<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * @package App\Models\Amigo
 */
class Language extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'languages';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // Write down the fields that will be assignable
        'locale', 'title', 'site', 'admin',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        // Write down the default value of fields if necessary
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that have multiple translation values
     *
     * @var array
     */
    public array $translatable = [
        // Write down the fields that will be translatable
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
            $model->site = request()->has('site');
            $model->admin = request()->has('admin');
        });
    }
}
