<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Redirect,Response;
use Illuminate\Support\Facades\Auth;

class FullCalendarController extends Controller
{

  public function index()
  {
    if(request()->ajax()) 
    {
      $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
      $end   = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

      // Public or individual events
      $data = Event::whereDate('start', '>=', $start)
        ->whereDate('end',   '<=', $end)
        ->get(['id','title','start', 'end']);

      return Response::json($data);
    }

    return view('fullcalendar');
  }


  public function create(Request $request)
  {  
    $insertArr = [ 'title' => $request->title,
    'start'   => $request->start,
    'userId'  => Auth::id(),
    'end'     => $request->end
    ];

    $event = Event::insert($insertArr);

    return Response::json($event);
  }


  public function update(Request $request)
  {   
    $where     = array('id' => $request->id);
    $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
    $event     = Event::where($where)->update($updateArr);

    return Response::json($event);
  } 


  public function destroy(Request $request)
  {
    $event = Event::where('id',$request->id)->delete();

    return Response::json($event);
  }    
}
// public function index()
// {
//    $events = [];
//    $data = Booking::all();
//    if($data->count()){
//       foreach ($data as $key => $value) {
//         $events[] = \Calendar::event(
//             $value->title,
//             true,
//             new \DateTime($value->start),
//             new \DateTime($value->end.' +1 day')
//         );
//       }
//    }
//   $calendar = \Calendar::addEvents($events); 
//   return view('fullcalendar', compact('calendar'));
// }
