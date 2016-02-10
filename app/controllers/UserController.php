<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::paginate(5);
		return View::make('users.index', compact('users'));
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function user_login()
       	{
            if(Session::token() !==Input::get('_token')){
                $response=array(
                    'status'=>'fail',
                    'msg'=>'unauthorized login'
                );
            }
            try
            {
              		// Set login credentials
                $credentials = array( 'email'=> Input::get('username'), 'password'=> Input::get('password'));
               	// Try to authenticate the user
                $user = Sentry::authenticate($credentials, false);
                if($user){
                    $response=array(
                        'status' =>'success',
                        'msg'    =>'congratulations!!!!'
                    );
                }
            }
            catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
            {
                $response=array(
                    'status' =>'fail',
                    'msg'    =>'Login field is required.'
                );
            }
            catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
            {
                $response=array(
                    'status' =>'fail',
                    'msg'    =>'Password field is required.'
                );
            }
            catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
            {
                $response=array(
                    'status' =>'fail',
                    'msg'    =>'Wrong password, try again.'
                );
            }
            catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
            {
                $response=array(
                    'status' =>'fail',
                    'msg'    =>'Agent was not found.'
                );
            }
            catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
            {
                $response=array(
                    'status' =>'fail',
                    'msg'    =>'Sorry!! seams you are not activated to use the system.. please visit the system administrator.'
                );
            }
            catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
            {
                $response=array(
                    'status' =>'fail',
                    'msg'    =>'Sorry!! seams you are suspended from using the system.. please visit the system administrator.'
                );
            }
            catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
            {
                $response=array(
                    'status' =>'fail',
                    'msg'    =>'Sorry!! seams you are baned from using the system.. please visit the system administrator.'
                );
            }
            return Response::json($response);
       	}
	public function create()
	{
		return View::make('users.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        if(Session::token() !==Input::get('_token')){
            $response=array(
                'status'=>'fail',
                'msg'=>'unauthorized to create user'
            );
        }
        try
        {
            $email      =Input::get('email');
            $password   =Input::get('password');
            $first_name =Input::get('first_name');
            $last_name  =Input::get('last_name');
            $other_name =Input::get('other_name');
            $phone      =Input::get('phone');
            $role       =Input::get('role');
            $u          =Sentry::getUser();
            $created_by =$u->email;
            $hashed=Hash::make($password);
            $adminGroup = Sentry::findGroupByName($role);
            $groupPermissions = $adminGroup->getPermissions();
            if($adminGroup){
                        	// Create the user
                $user = Sentry::createUser(array(
                    'email'         => $email,
                    'password'      => $password,
                    'first_name'    => $first_name,
                    'last_name'     => $last_name,
                    'other_name'    => $other_name,
                    'created_by'    =>$created_by,
                    'phone'         => $phone,
                    'role'          => $role,
                    'permissions'   =>$groupPermissions,
                    'activated'     => true,
                ));
               		// Find the group using the group id
               		// Assign the group to the user
                $user->addGroup($adminGroup);
                $response=array(
                    'status'=>'success',
                    'msg'=>'User Successfully Created!!'
                );
            }
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            $response=array(
                'status'=>'Error',
                'msg'=>'Login field is required.'
            );
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            $response=array(
                'status'=>'Error',
                'msg'=>'Password field is required.'
            );
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $response=array(
                'status'=>'Error',
                'msg'=>'User with this USERNAME ('.$email.') already exists.'
            );
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            $response=array(
                'status'=>'Error',
                'msg'=>'Role '.$role.' not found in the system.'
            );
        }
        return Response::json($response);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		if (is_null($user))
		{
		return Redirect::route('users.index');
		}
		return View::make('users.edit', compact('user'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$validation = Validator::make($input, User::$rules);
		if ($validation->passes())
		{
		$user = User::find($id);
		$user->update($input);
		return Redirect::route('users.index', $id);
		}
		return Redirect::route('users.edit', $id)
		->withInput()
		->withErrors($validation)
		->with('message', 'There were validation errors.');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::find($id)->delete();
		return Redirect::route('users.index');
	}


}
