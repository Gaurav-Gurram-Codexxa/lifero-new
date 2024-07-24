<?php

namespace App\Repositories;

use App\Models\TaxModel;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class TaxRepository
 *
 * @version October 1, 2022, 7:18 pm UTC
 */
class TaxRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'name',
        'rate',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return TaxModel::class;
    }

    public function store($input)
    {
        try
        {
            $data = [
                'name' => $input['name'],
                'rate' => $input['rate'],
            ];
            $user = TaxModel::create($data);
        }
        catch (Exception $e)
        {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function updateTax($id, $input)
    {
        try {
            $tax = TaxModel::findOrFail($id);
            $tax->update($input);
            return true;
        } catch (Exception $e) {
            throw new \RuntimeException('Failed to update tax', 0, $e);
        }
    }


}
