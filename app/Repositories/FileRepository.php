<?php

namespace App\Repositories;

use App\Models\File;
use App\Repositories\BaseRepository;

class FileRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'path',
        'hidden'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return File::class;
    }
}
