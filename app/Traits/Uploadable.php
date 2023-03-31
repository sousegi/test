<?php /** @noinspection PhpUndefinedFieldInspection */

/**
 * Created by IntelliJ IDEA.
 * User: alex.cebotari@ourbox.org
 * Date: 04.10.2021
 * Time: 15:36
 */

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

/**
 * Trait Uploadable
 * @package Amigo\Cms\Traits
 */
trait Uploadable
{
    /**
     * @var string Storage disk
     */
    private string $disk = 'local';

    /**
     * @var string Model temp id
     */
    private string $tempId;

    /**
     * Recursive iterator
     * @var int|null
     */
    private int|null $recursiveIterator = null;

    /**
     * Image Relation
     *
     * @var int
     */
    private int $imageRelation;

    /**
     * Set Upload Attributes method
     *
     * @return void
     * @throws InvalidArgumentException
     */
    private function setUploadAttributes(): void
    {
        if (!is_array($this->uploadable)) {
            throw new InvalidArgumentException('Invalid attributes array.');
        }

        foreach ($this->uploadable as $attribute => $config) {
            if (is_numeric($attribute)) {
                unset($this->uploadable[$attribute]);
                $this->uploadable[$config] = [];
                $attribute = $config;
                $config = [];
            }

            $path = Arr::get($config, 'path', null);
            $url = Arr::get($config, 'url', null);

            if (!$path) {
                $path = $this->disk === 'local' ? 'public/' : '';
                $config['path'] = $path.$this->getClass();
            }
            if (!$url) {
                $config['url'] = 'storage/'.$this->getClass();
            }

            $this->uploadable[$attribute]['path'] = $this->normalizePath($config['path']);
            $this->uploadable[$attribute]['url'] = rtrim($config['url'], '/');
        }
    }

    /**
     * Normalize path function
     *
     * @param $path
     * @return string
     */
    private function normalizePath($path): string
    {
        $parts = array();
        $path = strtr($path, '\\', '/');
        $prefix = '';
        $absolute = false;

        // extract a prefix being a protocol://, protocol:, protocol://drive: or simply drive:
        if (preg_match('{^( [0-9a-z]{2,}+: (?: // (?: [a-z]: )? )? | [a-z]: )}ix', $path, $match)) {
            $prefix = $match[1];
            $path = substr($path, strlen($prefix));
        }
        if (str_starts_with($path, '/')) {
            $absolute = true;
            $path = substr($path, 1);
        }
        $up = false;
        foreach (explode('/', $path) as $chunk) {
            if ('..' === $chunk && ($absolute || $up)) {
                array_pop($parts);
                $up = !(empty($parts) || '..' === end($parts));
            } elseif ('.' !== $chunk && '' !== $chunk) {
                $parts[] = $chunk;
                $up = '..' !== $chunk;
            }
        }
        return $prefix.($absolute ? '/' : '').implode('/', $parts);
    }

    /**
     * Boot method for Uploadable trait.
     *
     * @return void
     */
    public static function bootUploadable(): void
    {
        self::saved(function ($model) {
            $attributes = array_keys($model->uploadable);

            if ($attributes) {
                foreach ($attributes as $attr) {
                    $file = $model->retrieveFile($attr);
                    if ($file) {
                        $file = is_array($file) ? data_get($file, 0) : $file;
                        $filename = Str::slug('image_'.time().'_'.Str::random(10)).'.'.$file->getClientOriginalExtension();

                        // Store New Files
                        $status = $file->storeAs($model->getPath($attr), $filename, $model->disk);
                        if ($status) {
                            $model->$attr = $filename;
                            $model->saveQuietly();
                        }
                    }
                }
            }
        });
    }

    /**
     * @param  string  $attribute
     *
     * @return array|\Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|mixed|null
     */
    private function retrieveFile(string $attribute): mixed
    {
        if (is_null($this->getRecursiveIterator())) {
            return request()->file($attribute);
        }

        $allFiles = request()->allFiles();

        return data_get($allFiles, $this->getImageRelation().'.'.$this->getRecursiveIterator().'.'.$attribute);
    }

    /**
     * Initializes Uploadable trait
     *
     * @return void
     */
    public function initializeUploadable(): void
    {
        $this->setUploadAttributes();
    }

    /**
     * @param  string  $attribute  Attribute name
     *
     * @return string Path to file
     */
    public function getPath(string $attribute): string
    {
        return $this->uploadable[$attribute]['path'].DIRECTORY_SEPARATOR.$this->getFolderId().DIRECTORY_SEPARATOR;
    }

    /**
     * @param  string  $attribute  Attribute name
     *
     * @return string Url to file
     */
    public function getUrl(string $attribute): string
    {
        return $this->uploadable[$attribute]['url'].DIRECTORY_SEPARATOR.$this->getFolderId().DIRECTORY_SEPARATOR;
    }

    /**
     * @param  string  $attribute  Attribute name
     *
     * @return string File path
     */
    public function fileDir(string $attribute): string
    {
        return $this->getPath($attribute).DIRECTORY_SEPARATOR.$this->getFolderId().DIRECTORY_SEPARATOR;
    }

    /**
     * Delete specified file.
     *
     * @param  string  $file  File path
     *
     * @return bool `true` if file was successfully deleted
     */
    protected function deleteFile(string $file): bool
    {
        if (is_file($file)) {
            return unlink($file);
        }

        return false;
    }

    /**
     * Get id of an element or temp id if an element is new
     *
     * @return int|null
     */
    public function getFolderId(): ?int
    {
        if ($this->id) {
            return $this->id;
        }

        if ($this->tempId) {
            return $this->tempId;
        }

        if (empty($this->id) && empty($this->tempId)) {
            $this->tempId = Str::random(32);
            return $this->tempId;
        }

        return null;
    }

    /**
     * Get class name of model.
     *
     * @return string
     */
    public function getClass(): string
    {
        $class = class_basename(get_class($this));

        return strtolower($class);
    }

    /**
     * Get file url method.
     *
     * @param $attribute
     *
     * @return string|null
     */
    public function getFile($attribute): ?string
    {
        if ($this->$attribute && Storage::disk($this->disk)->exists($this->getPath($attribute).$this->$attribute)) {
            return $this->getUrl($attribute).$this->$attribute;
        }

        return null;
    }

    /**
     * Get file path method
     *
     * @param $attribute
     *
     * @return string|null
     */
    public function getFilePath($attribute): ?string
    {
        if ($this->$attribute && Storage::disk($this->disk)->exists($this->getPath($attribute).$this->$attribute)) {
            return $this->getPath($attribute).$this->$attribute;
        }

        return null;
    }

    /**
     * Get recursive iterator method.
     *
     * @return int|null
     */
    public function getRecursiveIterator(): ?int
    {
        return $this->recursiveIterator;
    }

    /**
     * Set recursive iterator method.
     *
     * @param  int  $recursiveIterator
     *
     * @return void
     */
    public function setRecursiveIterator(int $recursiveIterator): void
    {
        $this->recursiveIterator = $recursiveIterator;
    }

    /**
     * Get Image Relation
     *
     * @return int
     */
    public function getImageRelation(): int
    {
        return $this->imageRelation;
    }

    /**
     * Set Image Relation
     *
     * @param  int  $relation
     */
    public function setImageRelation(int $relation): void
    {
        $this->imageRelation = $relation;
    }
}
