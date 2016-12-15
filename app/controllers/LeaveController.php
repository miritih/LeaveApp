<?php

class LeaveController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Sentry::check()){
        $user= Sentry::getUser();
        $project=$user->project_ID;
    }
        $leave=  DB::table('leave')
            ->join('users', 'leave.agent_ID', '=', 'users.agent_ID')
            ->join('Projects', 'users.project_ID', '=', 'Projects.Project_Name')
            ->select('leave.leave_ID','leave.date', 'leave.agent_ID', 'users.agent_Name','users.created_at','Projects.project_Name')
			->where('project_Name','=',$project)
            ->orderBy('agent_Name', 'asc')
            ->get();


      /*  $leave = DB::table('Agent')->leave
            ->orderBy('date', 'desc')
            ->get();*/
        return Response::json($leave);
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
        try {
			 if(Sentry::check()){
             $user= Sentry::getUser();
            $project=$user->project_ID;
			}
            $month=Input::get('qter');
            if($month<=3 && $month>=1){
                $q=Leave::whereBetween('date', array('2016-01-01', '2016-03-31'))->where('agent_ID', '=',Input::get('agent'))->count();
            }else if($month<=6 && $month>=4){
                $q=Leave::whereBetween('date', array('2016-04-01', '2016-06-30'))->where('agent_ID', '=',Input::get('agent'))->count();
            }else if($month<=9 && $month>=7){
                $q=Leave::whereBetween('date', array('2016-07-01', '2016-09-30'))->where('agent_ID', '=',Input::get('agent'))->count();
            }else if($month<=12 && $month>=10){
                $q=Leave::whereBetween('date', array('2016-10-01', '2016-12-31'))->where('agent_ID', '=',Input::get('agent'))->count();
            }
			$max_agents=DB::table('projects')
            ->select('Projects.max_agents')
			->where('project_Name','=',$project)->get();
			
            $fullyBooked = DB::table('leave')
            ->join('users', 'leave.agent_ID', '=', 'users.agent_ID')
            ->join('Projects', 'users.project_ID', '=', 'Projects.Project_Name')
            ->select('leave.leave_ID','leave.date', 'leave.agent_ID', 'users.agent_Name','users.created_at','Projects.project_Name')
			->where('date', '=',Input::get('date'))
			->where('project_Name','=',$project)
			->count();
            $agent=Leave::where('date', '=',Input::get('date'))->where('agent_ID', '=',Input::get('agent'))->count();
            $monthMax=Leave::where('date', 'like',Input::get('month').'%')->where('agent_ID', '=',Input::get('agent'))->count();
            $maxLeave=Leave::where('agent_ID', '=',Input::get('agent'))->count();
           
				foreach ($max_agents as $max_a)
				{
					$max_agent=$max_a->max_agents;
				}
		   if($fullyBooked>=$max_agent){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'Sorry!! This leave day is fully booked. Kindly select onother date to book.'
                );
            }else if($agent>=1){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'You have already booked this day!!'
                );
            }else if($q>=21){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'Sorry! You have exhausted your leave days for this Year(21 max allowed)'
                );
            }else if($monthMax>=21){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'Sorry! You can only take 5 leave days in a month!!'
                );
            }else if($maxLeave>=21){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'Sorry! You have exhausted your leave days for this Year(21 max allowed)'
                );
            }
            else{
                $leave= new Leave;
                $leave->date= Input::get('date');
                $leave->agent_ID = Input::get('agent');
                $leave->save();
                $response = array(
                    'status' => 'success',
                    'msg' => 'leave day successfully booked'
                );
            }
        }
        catch(\Illuminate\Database\Eloquent\MassAssignmentException $e){
            $response = array(
                'status' => 'Error',
                'msg' => 'mass assignment not allowed!!'
            );
        }
        catch(Illuminate\Database\QueryException $e){
            $response = array(
                'status' => 'Error',
                'msg' => $e
            );
        }
        return Response::json($response);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	public function destroy()
	{
        $id=Input::get('id');
       $del= DB::table('leave')->where('leave_id', '=',$id)->delete();
        if($del){
            $response=array(
                'status' =>'success',
                'msg'    =>'leave Day successfully Canceled!'
            );
        }
        else{
            $response=array(
                'status' =>'fail',
                'msg'    =>'something wrong happened!!'
                       );
        }
        return Response::json($response);
	}


}
