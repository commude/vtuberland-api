<?php

namespace App\Http\Resources\Bases;

use Illuminate\Http\Resources\Json\JsonResource;

class DataTableResource extends JsonResource
{
    /**
     * Declare total records
     * 
     * @var $filteredCounts
     */
    protected $totalCounts;

    /**
     * Declare records filtered
     * 
     * @var $filteredCounts
     */
    protected $filteredCounts;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param $me
     */
    public function __construct($collection, $totalCounts, $filteredCounts)
    {
        parent::__construct($collection);
        $this->collection = $collection;

        $this->totalCounts = $totalCounts;
        $this->filteredCounts = $filteredCounts;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'draw' => $request->draw,
            'recordsTotal' => $this->totalCounts,
            'recordsFiltered' => $this->filteredCounts,
            'data' => $this->collection,
        ];
    }
}
