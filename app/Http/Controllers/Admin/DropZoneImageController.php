<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DropZoneImageController extends Controller
{
    public function storeMedia(Request $request)
    {
        $path = Storage::path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim(str_replace(' ', '', $file->getClientOriginalName()));
        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function deleteFile(Request $request)
    {
        try {
            if(isset($request->path)) {
                $file = 'public/'.$request->path.'/'.$request->file_to_be_deleted;
                Storage::delete($file);

                return response()->json(true);
            }

            if(!isset($request->path)) {
                if(!is_null($request->file_to_be_deleted)) {
                    $file =  Storage::path('tmp/uploads/'.$request->file_to_be_deleted);
                    unlink($file);

                    return response()->json(true);
                }
            }

            return response()->json(false);

        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
