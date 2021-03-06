<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect, Response, Auth;

class FullCalendarController extends Controller
{
  /**
   * Display full calendar data
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if(request()->ajax()) 
    {
      $start = request('start');
      $end   = request('end');

      // Public or individual events
      $data = Event::whereDate('start', '>=', $start)
        ->whereDate('end', '<=', $end)
        ->where(function($query) {
          // The user is logged in
          if (Auth::check() && request('page') != 'homepage') {
            $query->where('userId', Auth::id());
          }
        })
        ->with('user')
        ->get(['id','title','start', 'end', 'userId']);

      return Response::json($data);
    }
  }

  /**
  * Create a calendar event
  *
  * @param  \Illuminate\Http\Request $request
  * @return \Illuminate\Http\Response
  */
  public function create(Request $request)
  {  
    $insertArr = [ 
      'title' => $request->title,
      'start'   => $request->start,
      'userId'  => Auth::id(),
      'end'     => $request->end
    ];

    $event = Event::insert($insertArr);

    return Response::json($event);
  }

  /**
  * Update a calendar event
  *
  * @param  \Illuminate\Http\Request $request
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request)
  {   
    $where     = array('id' => $request->id);
    $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
    $event     = Event::where($where)->update($updateArr);

    return Response::json($event);
  } 

  /**
  * Delete a calendar event
  *
  * @param  \Illuminate\Http\Request $request
  * @return \Illuminate\Http\Response
  */
  public function destroy(Request $request)
  {
    $event = Event::where('id',$request->id)->delete();

    return Response::json($event);
  }    
}
