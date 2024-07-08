<?php

namespace App\Repositories;

use App\Models\Package;
use App\Models\PackageService;
use App\Models\Service;
use Arr;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Validator;

/**
 * Class PackageRepository
 *
 * @version February 25, 2020, 1:10 pm UTC
 */
class PackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'discount',
        'total_amount',
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
        return Package::class;
    }

    public function getServicesList()
    {
        $service = Service::whereStatus(1)->get()->pluck('name', 'id')->sort();

        return $service;
    }

    public function getServices(): array
    {
        $result = Service::whereStatus(1)->orderBy('name', 'asc')->get()->pluck('name', 'id')->toArray();
        $services = [];
        foreach ($result as $key => $item) {
            $services[] = [
                'key' => $key,
                'value' => $item,
            ];
        }

        return $services;
    }

    public function store(array $input): Package
    {
        $servicePackageItemInputArray = array_values($input['session']);

        /** @var Package $package */
        $package = $this->create(Arr::except($input, ['session']));
        $totalAmount = 0;

        $packageServiceItemInput = $this->prepareInputForServicePackageItem($servicePackageItemInputArray);
        foreach ($packageServiceItemInput as $key => $data) {
            $validator = Validator::make($data, PackageService::$rules);

            if ($validator->fails()) {
                throw new UnprocessableEntityHttpException($validator->errors()->first());
            }

            $data['amount'] = $data['rate'] * $data['quantity'];
            $totalAmount += $data['amount'];

            /** @var PackageService $packageServiceItem */
            $packageServiceItem = new PackageService($data);
            $package->packageServicesItems()->save($packageServiceItem);
        }
        $package->total_amount = $totalAmount - (($totalAmount * $input['discount']) / 100);
        $package->save();

        return $package;
    }

    public function prepareInputForServicePackageItem(array $input): array
    {
        $items = [];
        foreach ($input as $key => $data) {
            
            foreach ($data['service_id'] as $index => $value) {
                $items[] = [
                    'service_id' => $input[$key]['service_id'][$index],
                    'quantity' => $input[$key]['quantity'][$index],
                    'id' => $input[$key]['id'][$index] ?? '',
                    'rate' => removeCommaFromNumbers($input[$key]['rate'][$index]),
                    'session_id' => $key,
                ];
            }
        }

        return $items;
    }

    /**
     * @throws Exception
     */
    public function updatePackage($packageId, $input): Package
    {
        $servicePackageItemInputArray = array_values($input['session']);

        /** @var Package $package */
        $package = $this->update($input, $packageId);
        $totalAmount = 0;

        $packageServiceItemInput = $this->prepareInputForServicePackageItem($servicePackageItemInputArray);
        foreach ($packageServiceItemInput as $key => $data) {
            $validator = Validator::make($data, PackageService::$rules, [
                'service_id.integer' => 'Please select service',
            ]);

            if ($validator->fails()) {
                throw new UnprocessableEntityHttpException($validator->errors()->first());
            }

            $data['amount'] = $data['rate'] * $data['quantity'];
            $packageServiceItemInput[$key] = $data;
            $totalAmount += $data['amount'];
        }
        /** @var PackageServiceItemsRepository $packageServiceItemRepo */
        $packageServiceItemRepo = app(PackageServiceItemsRepository::class);
        $packageServiceItemRepo->updatePackageServiceItem($packageServiceItemInput, $package->id);
        
        $package->total_amount = $totalAmount - (($totalAmount * $input['discount']) / 100);
        $package->save();

        return $package;
    }
}
