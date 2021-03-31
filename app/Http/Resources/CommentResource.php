<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $children = CommentResource::collection($this->whenLoaded('children'));
       
        return [
            'id'        => $this-> id,
            'body'      => $this->body,
            'parent_id' => $this->parent_id,
            'child'     => !is_null($this->parent_id),
            'user'      => new UserResource($this->user),
            'children'  => $children,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
