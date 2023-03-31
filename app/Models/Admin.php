<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;
use Illuminate\Notifications\Notifiable;
use App\Traits\Uploadable;

/**
 * Class Admin
 * @package App\Models
 */
class Admin extends Authenticatable
{
    use Uploadable, HasTranslations, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';

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
        'name',
        'email',
        'password',
        'avatar',
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
}
