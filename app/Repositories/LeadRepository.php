<?php

namespace App\Repositories;

use App\Models\Lead;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class LeadRepository
 *
 * @version February 17, 2020, 5:34 am UTC
 */
class LeadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'phone',
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
    public function model()
    {
        return Lead::class;
    }

    public function store(array $input): bool
    {
        try {

            Lead::create($input);


            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return bool|Builder|Builder[]|Collection|Model
     */
    public function update($lead, $input)
    {
        try {
            $lead->update($input);

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
