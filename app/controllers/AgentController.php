<?php

class AgentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(Session::token() ==Input::get('_token')){
                    $response=array(
                        'status'=>'fail',
                        'msg'=>'unauthorized Action'
                    );
        }
        try
               	{
                       $email      =Input::get('agentId');
                       $password   =Input::get('password');
                       $agent_id =Input::get('agentId');
                       $agent_name  = Input::get('fullName');
                       $project_id =Input::get('project1');
                          	// Create the user
               		$user = Sentry::createUser(array(
                           'email'         => $email,
                           'password'      => $password,
                           'agent_ID'      => $agent_id,
                           'project_ID'    => $project_id,
                           'agent_Name'    => $agent_name,
               			   'activated'     => true,
               		));

                       $response=array(
                           'status'=>'success',
                           'msg'=>'User Successfully Created!!'
                       );


               	}
               	catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
               	{
                       $response=array(
                           'status'=>'Error',
                           'msg'=>'agent ID field is required.'
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
                           'msg'=>'Agent with ID ('.$email.') already exists.'
                       );
               	}

               return Response::json($response);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function change_pass()
	{
		if(Session::token() ==Input::get('_token')){
                    $response=array(
                        'status'=>'fail',
                        'msg'=>'unauthorized Action'
                    );
        }
        try
               	{
                       $email      =Input::get('agentId');
                       $password   =Input::get('password');
                $user =  Sentry::findUserByLogin($email);
                          	// Create the user
                         $user -> password = $password;
                 if ($user->save())
						{
							$response=array(
                           'status'=>'success',
                           'msg'=>'User Successfully Created!!'
                       );
						}
				else
					{
							$response=array(
                           'status'=>'fail',
                           'msg'=>'error!!'
                       );
					}
               
               	}
               
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
				{
					$response=array(
                           'status'=>'Error',
                           'msg'=>'User with this login already exists..'
                       );
				}
			catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
				{
					$response=array(
                           'status'=>'Error',
                           'msg'=>'Agent ID '. $email .' Not Found'
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
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
