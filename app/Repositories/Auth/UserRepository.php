<?php

namespace App\Repositories\Auth;

use App\Notifications\UserNeedsConfirmation;
use App\Repositories\BaseRepository;
use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
  /**
   * @return string
   */
  public function model()
  {
    return User::class;
  }

  public function create(array $data): User
  {
    // for create user
    return DB::transaction(function () use ($data) {

      $user = parent::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'confirmation_code' => md5(uniqid(mt_rand(), true)),
        'password' => $data['password'],
        'confirmed' => 0,
      ]);


      // User Roles

      // User Notification
      if ($user->confirmed === '0' or $user->confirmed === 0) {
        $user->notify(new UserNeedsConfirmation($user->confirmation_code));
      }

      return  $user;

      // // See if adding any additional permissions
      // if (!isset($data['permissions']) || !count($data['permissions'])) {
      //   $data['permissions'] = [];
      // }

      // if ($user) {
      //   // User must have at least one role
      //   if (!count($data['roles'])) {
      //     throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
      //   }

      //   // Add selected roles/permissions
      //   $user->syncRoles($data['roles']);
      //   $user->syncPermissions($data['permissions']);

      //   //Send confirmation email if requested and account approval is off
      //   if (isset($data['confirmation_email']) && $user->confirmed == 0 && !config('access.users.requires_approval')) {
      //     $user->notify(new UserNeedsConfirmation($user->confirmation_code));
      //   }

      //   event(new UserCreated($user));

      //   return $user;
      // }

      // throw new GeneralException(__('exceptions.backend.access.users.create_error'));
    });
  }
}