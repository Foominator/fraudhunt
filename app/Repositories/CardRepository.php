<?php

namespace App\Repositories;

use App\Models\Card;
use App\Repositories\BaseRepository;

/**
 * Class CardRepository
 * @package App\Repositories
 * @version October 9, 2020, 7:22 am UTC
*/

class CardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'card_num'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Card::class;
    }
}
