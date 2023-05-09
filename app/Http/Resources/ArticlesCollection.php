<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticlesCollection extends ResourceCollection
{
    /**
     * @param $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
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
