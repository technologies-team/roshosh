<?php

namespace App\DTOs;

class SearchQuery
{

    public static function fromJson(array $json): SearchQuery
    {
        $keyword = $json['keyword'] ?? null;
        $fields = $json['fields'] ?? [];
        $offset = $json['offset'] ?? 0;
        $limit = $json['limit'] ?? 10;
        $sort = $json['sort'] ?? null;
        return new SearchQuery($keyword, $fields, $offset, $limit, $sort);
    }

    /**
     *
     */
    public mixed $keyword=null;

    /**
     *
     */
    public array $fields;

    /**
     *
     */
    public int $offset;

    /**
     *
     */
    public int $limit;

    /**
     *
     */
    public mixed $sort;


    public function __construct( $keyword, array $fields = [], int $offset = 0, int $limit = 10,  $sort = null)
    {

        if ($keyword)
            $this->keyword = $keyword;
        $this->fields = $fields;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->sort = $sort;
    }
}
