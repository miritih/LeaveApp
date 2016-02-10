<?php

class LeaveController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

        $leave=  DB::table('leave')
            ->join('users', 'leave.agent_ID', '=', 'users.agent_ID')
            ->join('Projects', 'users.project_ID', '=', 'Projects.Project_Name')
            ->select('leave.leave_ID','leave.date', 'leave.agent_ID', 'users.agent_Name','users.created_at','Projects.project_Name')
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
            $month=Input::get('qter');
            if($month<=3 && $month>=1){
                $q=Leave::whereBetween('date', array('2016-01-01', '2016-03-31'))->where('agent_ID', '=',Input::get('agent'))->count();
            }else if($month<=4 && $month>=6){
                $q=Leave::whereBetween('date', array('2016-04-01', '2016-06-30'))->where('agent_ID', '=',Input::get('agent'))->count();
            }else if($month<=7 && $month>=9){
                $q=Leave::whereBetween('date', array('2016-07-01', '2016-09-30'))->where('agent_ID', '=',Input::get('agent'))->count();
            }else if($month<=10 && $month>=12){
                $q=Leave::whereBetween('date', array('2016-10-01', '2016-12-31'))->where('agent_ID', '=',Input::get('agent'))->count();
            }
            $fullyBooked = Leave::where('date', '=',Input::get('date'))->count();
            $agent=Leave::where('date', '=',Input::get('date'))->where('agent_ID', '=',Input::get('agent'))->count();
            $monthMax=Leave::where('date', 'like',Input::get('month').'%')->where('agent_ID', '=',Input::get('agent'))->count();
            $maxLeave=Leave::where('agent_ID', '=',Input::get('agent'))->count();
            if($fullyBooked>=1){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'Sorry!! This day is fully Booked..Please select another day'
                );
            }else if($agent>=1){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'You have already booked this day!!'
                );
            }else if($q>=5){
                $response = array(
                    'status' => 'Error',
                    'msg' => 'You\'re Not allowed to go for more than 5 days leave in three months.. please see your Team lead in case you want an extra leave for this quota'
                );
            }else if($monthMax>=5){
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
                'msg'    =>'leave successfully Removed'
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
