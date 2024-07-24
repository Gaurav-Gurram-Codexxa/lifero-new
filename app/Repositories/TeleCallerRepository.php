<?php

namespace App\Repositories;

use App\Models\TeleCaller;
use App\Models\Address;
use App\Models\Department;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class TeleCallerRepository
 *
 * @version February 17, 2020, 5:34 am UTC
 */
class TeleCallerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'full_name',
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
        return TeleCaller::class;
    }

    public function store(array $input, bool $mail = true): bool
    {
        try {
            $input['department_id'] = Department::whereName('Tele Caller')->first()->id;
            $input['password'] = Hash::make($input['password']);
            /** @var User $user */
            // $input['phone'] = preparePhoneNumber($input, 'phone');
            $input['dob'] = (! empty($input['dob'])) ? $input['dob'] : null;
            if(!empty(getSuperAdminSettingValue()['default_language']->value)){
                $input['language'] = getSuperAdminSettingValue()['default_language']->value;
            }
            $user = User::create($input);
            if ($mail) {
                $user->sendEmailVerificationNotification();
            }

            if (isset($input['image']) && ! empty($input['image'])) {
                $mediaId = storeProfileImage($user, $input['image']);
            }
            $teleCaller = TeleCaller::create(['user_id' => $user->id]);
            $ownerId = $teleCaller->id;
            $ownerType = TeleCaller::class;

            /*
            $subscription = [
                'user_id'    => $user->id,
                'start_date' => Carbon::now(),
                'end_date'   => Carbon::now()->addDays(6),
                'status'     => 1,
            ];
            Subscription::create($subscription);
            */

            if (! empty($address = Address::prepareAddressArray($input))) {
                Address::create(array_merge($address, ['owner_id' => $ownerId, 'owner_type' => $ownerType]));
            }

            $user->update(['owner_id' => $ownerId, 'owner_type' => $ownerType]);
            $user->assignRole($input['department_id']);

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return bool|Builder|Builder[]|Collection|Model
     */
    public function update($teleCaller, $input)
    {
        try {
            unset($input['password']);

            /** @var User $user */
            $user = User::find($teleCaller->user->id);
            if (isset($input['image']) && ! empty($input['image'])) {
                $mediaId = updateProfileImage($user, $input['image']);
            }
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && ! empty($input['avatar_remove'])) {
                removeFile($user, User::COLLECTION_PROFILE_PICTURES);
            }

            /** @var TeleCaller $teleCaller */
            // $input['phone'] = preparePhoneNumber($input, 'phone');
            $input['dob'] = (! empty($input['dob'])) ? $input['dob'] : null;
            $teleCaller->user->update($input);
            $teleCaller->update($input);

            if (! empty($teleCaller->address)) {
                if (empty($address = Address::prepareAddressArray($input))) {
                    $teleCaller->address->delete();
                }
                $teleCaller->address->update($input);
            } else {
                if (! empty($address = Address::prepareAddressArray($input)) && empty($teleCaller->address)) {
                    $ownerId = $teleCaller->id;
                    $ownerType = TeleCaller::class;
                    Address::create(array_merge($address, ['owner_id' => $ownerId, 'owner_type' => $ownerType]));
                }
            }

            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
