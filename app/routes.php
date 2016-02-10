<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{

});
Route::get('/', function()
{
    if(Sentry::check()){
        $user= Sentry::getUser();
        $email=$user->email;
        $name=$user->agent_Name;
        $project=$user->project_ID;
        return View::make('home')->with('user',$email)->with('name',$name)->with('project',$project);
    }
    return View::make("login")->with("title","Leave APP")->with('heading','LEAVE APP');
});
Route::get('/logout',function(){
    Sentry::logout();
    return View::make("login")->with("title","Leave APP")->with('heading','LEAVE APP');
});
Route::post('/login',array('as'=>'user.login','uses'=> 'UserController@user_login'));
Route::get('add', function()
{
	return View::make('create');
});
Route::get('projects', function()
{
	return Project::all();
});
Route::get('excel', function()
{
    DB::setFetchMode(PDO::FETCH_ASSOC);
    $leave=  DB::table('leave')
                ->join('users', 'leave.agent_ID', '=', 'users.agent_ID')
                ->join('Projects', 'users.project_ID', '=', 'Projects.Project_Name')
                ->select('leave.date', 'leave.agent_ID', 'users.agent_Name','Projects.project_Name')
                ->orderBy('agent_Name', 'asc')
                ->get();
    $mytime = Carbon\Carbon::now()->toDateTimeString();
    $myt="Leave Sheet(".$mytime.")";

    Excel::create($myt, function($excel) use($leave) {

    $excel->sheet('GAR2LeaveSheet', function($sheet) use($leave) {

        $sheet->fromArray($leave);

    });
})->export('xlsx');
});
Route::post('leave/delete',array('as'=>'leave.destroy','uses'=> 'LeaveController@destroy'));

Route::get('agents', function()
{
    $agents=  DB::table('users')
               ->join('Projects', 'users.project_ID', '=', 'Projects.Project_ID')
               ->select('users.agent_ID', 'users.agent_Name','Projects.project_Name')
               ->orderBy('Agent_Name', 'desc')
               ->get();
	return Response::json($agents);
});
Route::get('date', function()
{
    $fullyBooked = Leave::where('date', '=',Input::get('date'))->count();
	return $fullyBooked;
});
Route::get('leave','LeaveController@index');
Route::post('save',array('as'=>'leave.create','uses'=> 'LeaveController@create'));
Route::post('agentSave',array('as'=>'agent.create','uses'=> 'AgentController@create'));

