<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListMessagesRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(!empty($this->me)){
        return [
            'me'=>$this->me,
            'time'=>$this->created_at,
        ];
        }
        elseif(!empty($this->friend))
        {
            return [
                'friend'=>$this->friend,
                'time'=>$this->created_at,
            ];
        }
    }
}
