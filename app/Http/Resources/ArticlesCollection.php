<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class ArticlesCollection extends ResourceCollection
{
    /**
     * @param $request
     * @return array|JsonSerializable|Arrayable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return $this->collection->map(function($query) {

            return [
                'id' => $query['id'],
                'title' => $query['title'],
                'content' => $query['content'],
                'image' => $query['image'],
                'created_at' => $query['created_at']
            ];
        });
    }
}
