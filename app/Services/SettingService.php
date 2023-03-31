<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services;

use App\Models\Setting;
use App\Contracts\Service;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SimpleCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;
use TypeError;

/**
 * Class Setting
 * @package App\Services
 */
class SettingService implements Service
{
    /**
     * @var \App\Models\Setting
     */
    public Setting $model;

    /**
     * Array of settings for website
     *
     * @var array|string[]
     */
    private array $availableSettings = [
        'site.title',
        'site.description',
        'site.main.address',
        'site.secondary.address',
        'site.phone.number',
        'site.mobile.number',
        'site.email',
        'site.facebook',
        'site.linkedin',
        'site.instagram',
        'site.cover.image',
        'site.location.code',
        'site.google.analytics',
        'site.yandex.metrics',
        'site.facebook.pixel',
        'site.google.tag.manager',
        'site.google.remarketing',
    ];

    /**
     * Properties that need to be additionally checked, if they are set to null in the query, they will be ignored when saving the change
     *
     * @var array|string[]
     */
    private array $propertiesNotUpdatedOnNullValue = [
        'site.favicon',
        'site.cover.image',
    ];

    /**
     * @param  \App\Models\Setting  $setting
     */
    public function __construct(Setting $setting)
    {
        $this->model = $setting;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder(): Builder
    {
        return $this->model->select();
    }

    /**
     * @param  int  $limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllOrderByIdDescPaginated(int $limit = 20): LengthAwarePaginator
    {
        return $this->builder()->orderBy('id', 'DESC')->paginate($limit);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAll(): Collection
    {
        return $this->builder()->get();
    }

    /**
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id): Model
    {
        return $this->builder()->where('id', $id)->firstOrFail();
    }

    /**
     * @param  array  $params
     *
     * @return bool
     */
    public function store(array $params): bool
    {
        $this->model->fill($params);
        return $this->model->save();
    }

    /**
     * @param  int    $id
     * @param  array  $params
     *
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        return $this->builder()->where('id', $id)->update($params);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array                                $params
     *
     * @return bool
     * @noinspection PhpFieldAssignmentTypeMismatchInspection
     */
    public function updateResource(Model $model, array $params): bool
    {
        if (get_class($model) !== get_class($this->model)) {
            throw new TypeError('Cannot assign ' . get_class($this->model) . ' to property of type ' . get_class($this->model));
        }

        $this->model = $model;
        return $this->model->update($params);
    }

    /**
     * @param  int  $id
     */
    public function delete(int $id): void
    {
        $this->builder()->where('id', $id)->delete();
    }

    /**
     * Default settings values for project
     *
     * @return array
     * @noinspection PhpUnused
     */
    public function getDefaultSettingsList(): array
    {
        return with($this->availableSettings, function ($settings) {
            $data = [];

            foreach ($settings as $key) {
                $data[$key] = null;
            }

            return $data;
        });
    }

    /**
     * Method to update all settings for current project
     *
     * @param  array  $data
     *
     * @return bool
     */
    public function updateAllSettingsFromRequest(array $data): bool
    {
        try {
            $status = $this->validateDataArray($data);
            if ($status === false) {
                throw new Exception('Settings validation failed');
            }

            $collectionForUpdate = $this->prepareDataForInsert($data);

            DB::beginTransaction();
            foreach ($collectionForUpdate as $setting) {
                // prevent null update for image inputs
                if ($this->checkIfCantBeUpdated($setting->key, $setting->value)) {
                    continue;
                }

                $status = $this->updateSettingValue($setting->key, $setting->value);
                if ($status === false) {
                    throw new Exception('Settings update failed');
                }
            }
            DB::commit();

            return true;
        } catch (Exception $e) {
            Log::channel('single')->info($e->getMessage());
            DB::rollback();
            return false;
        }
    }

    /**
     * Method to validate data from request
     *
     * @param  array  $data
     *
     * @return bool
     */
    private function validateDataArray(array $data): bool
    {
        foreach ($data as $key => $value) {
            $setting = $this->getSettingNameFromRequestDataKey($key);
            if (!in_array($setting, $this->availableSettings, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Preparing provided data from request
     *
     * @param  array  $data
     *
     * @return \Illuminate\Support\Collection
     * @throws \Exception
     */
    private function prepareDataForInsert(array $data): SimpleCollection
    {
        $collection = new SimpleCollection([]);

        foreach ($data as $key => $value) {
            $setting = new stdClass();
            $setting->key = $this->getSettingNameFromRequestDataKey($key);
            $setting->value = $this->getSettingValueFromRequestDataValue($value);

            $collection->push($setting);
        }

        return $collection;
    }

    /**
     * Check if setting can be updated.
     * If setting is image, or file, preventing user to update setting with null value
     *
     * @param  string       $key
     * @param  string|null  $value
     *
     * @return bool
     */
    private function checkIfCantBeUpdated(string $key, ?string $value): bool
    {
        return (in_array($key, $this->propertiesNotUpdatedOnNullValue) && is_null($value));
    }

    /**
     * Method for
     *
     * @param  string  $name
     *
     * @return string
     */
    private function getSettingNameFromRequestDataKey(string $name): string
    {
        return str_replace('_', '.', $name);
    }

    /**
     * Method to get value from data
     *
     * @param  mixed  $value
     *
     * @return string|null
     * @throws \Exception
     */
    private function getSettingValueFromRequestDataValue(mixed $value): ?string
    {
        if ($value instanceof UploadedFile) {
            return $this->getUploadedFileValue($value);
        }

        return $value;
    }

    /**
     * Save file and return path in storage/app/public
     *
     * @param  \Illuminate\Http\UploadedFile  $value
     *
     * @return string
     * @throws \Exception
     */
    private function getUploadedFileValue(UploadedFile $value): string
    {
        $path = str_replace('public/', '', $value->store('public/settings'));
        if ($path === false) {
            throw new Exception('File could not be uploaded');
        }

        return $path;
    }

    /**
     * Method for update a setting by key
     *
     * @param  string       $key
     * @param  string|null  $value
     *
     * @return bool
     */
    private function updateSettingValue(string $key, ?string $value): bool
    {
        return $this->builder()->where('key', $key)->update(['value' => $value]);
    }

    /**
     * Clear Settings cache
     *
     * @return void
     */
    public function clearSettingsCache(): void
    {
        Cache::forget('settings');
    }

    /**
     * Get all Settings from cache
     *
     * @return array
     */
    public function getSettingsFromCache(): array
    {
        return Cache::rememberForever('settings', function () {
            return Setting::get()->pluck('value', 'key')->toArray();
        });
    }
}
