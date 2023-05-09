<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait DropZoneTrait
{
    /**
     * @var string Storage disk
     */
    private string $disk = 'local';

    /**
     * @var string Model temp id
     */
    private string $tempId;

    public function moveImage($images, $delete_temp = true)
    {
        try {
            if (is_array($images)) {
                foreach ($images as $item) {
                    if (is_file(Storage::path('tmp/uploads/' . $item)) && !is_file(Storage::path('public/'.$this->model->getTable().'/'. $this->model->id . '/' . $item))) {
                        Storage::copy('tmp/uploads/'.$item, 'public/'.$this->model->getTable().'/'.$this->model->id.'/'.$item);
                    }
                }
            } else {
                if (is_file(Storage::path('tmp/uploads/' . $images)) && !is_file(Storage::path('public/' . $this->model->getTable() . '/' . $this->model->id . '/' . $images))) {
                    Storage::copy('tmp/uploads/' . $images, 'public/' . $this->model->getTable() . '/' . $this->model->id . '/' . $images);

                }
            }

            if ($delete_temp) {
                $old_temp_files = Storage::allFiles('tmp/uploads/');
                Storage::delete($old_temp_files);
            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

        return true;
    }


    /**
     * Get image.
     *
     * @param $images
     * @param $id
     *
     * @return bool|string
     */
    public function getImages($images, $id): bool|string
    {

        $path = $this->service->model->getTable() . DIRECTORY_SEPARATOR . $id;

        if (!is_dir(Storage::path('public/' . $path))) {
            mkdir(Storage::path('public/' . $path), 0777, true);
        }

        $data = [];

        $tableImages[] = $images;

        if (is_array($images)) {

            $tableImages = [];

            foreach ($images as $image) {
                $tableImages[] = $image;
            }
        }

        $storeFolder = Storage::path('public/' . $path);
        $files = scandir($storeFolder);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..' && in_array($file, $tableImages)) {
                $obj['name'] = $file;
                $file_path = Storage::path('public/' . $path . '/') . $file;
                $obj['size'] = filesize($file_path);
                $obj['path'] = url('storage/' . $path . '/' . $file);
                $obj['file_path'] = $path;

                $data[] = $obj;
            }
        }
        return json_encode($data);
    }

    /**
     * Get file url method.
     *
     * @param $attribute
     *
     * @return string|null
     */
    public function showImage($attribute): string|null
    {

        if ($attribute && Storage::disk($this->disk)->exists($this->getPath())) {
            return $this->getUrl() . $this->$attribute;
        }
        return null;
    }

    /**
     * @return string Path to file
     */
    public function getPath(): string
    {
        return 'public' . DIRECTORY_SEPARATOR . $this->getTable() . DIRECTORY_SEPARATOR . $this->id;
    }

    /**
     *
     * @return string Url to file
     */
    public function getUrl(): string
    {
        return 'storage' . DIRECTORY_SEPARATOR . $this->getTable() . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR;
    }
}
