<?php

namespace App\Http\Controllers\UserManager;

use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\Users\StoreUser;
use App\Http\Requests\Users\UpdateUser;

use App\Helpers\EasyuiPagination;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the creation of new users as well as their
    | validation and creation throw admin panel.
    |
    */

    // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // allow creating through admin only
    }

    public function index()
    {
    	return view('auth.index');
    }

    public function list(Request $request)
    {
      $query = User::query();

      if($request->has('filterRules')) {

        $filterRules = json_decode($request->filterRules);

        foreach ($filterRules as $filterRule) {
          $query->where($filterRule->field, 'like', '%'. $filterRule->value .'%');
        }
      }

    	return EasyuiPagination::paginageData($request, $query);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(StoreUser $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
        ]);

        $user->assignRole($request->role);

        activity()->causedBy(\Auth::user())
                  ->performedOn($user)
                  ->withProperties(['model_activity_name' => $user::MODEL_ACTIVITY_NAME])
                  ->log('create');

        return ezReturnSuccessMessage('User created successfully!');
    }

    public function update(UpdateUser $request)
    {
    	$user = User::findOrFail($request->id);

    	$user->name = $request->name;
    	$user->email = $request->email;

    	$user->save();

    	$user->syncRoles([$request->role]);

        activity()->causedBy(\Auth::user())
                  ->performedOn($user)
                  ->withProperties(['model_activity_name' => $user::MODEL_ACTIVITY_NAME])
                  ->log('edit');

        return ezReturnSuccessMessage('User created successfully!');
    }

    public function destroy(Request $request)
    {

    	$user = User::findOrFail($request->id);

    	$user->delete();

        activity()->causedBy(\Auth::user())
                  ->performedOn($user)
                  ->withProperties(['model_activity_name' => $user::MODEL_ACTIVITY_NAME])
                  ->log('delete');

    	return ezReturnSuccessMessage('User removed successfully!');

    }

    public function toggleStatus(Request $request)
    {

    	$user = User::findOrFail($request->id);

    	$user->status = 1 - intval($user->status);

    	$user->save();

        $userStatus = ($user->status == 1) ? 'enabled' : 'disabled';
        activity()->causedBy(\Auth::user())
                  ->performedOn($user)
                  // ->withProperties(['model_activity_name' => $user::MODEL_ACTIVITY_NAME])
                  ->withProperties(['model_activity_name' => 'Test'])
                  ->log('Changed the user status to ' . $userStatus);

    	return ezReturnSuccessMessage('User staus changed successfully!');

    }


}
