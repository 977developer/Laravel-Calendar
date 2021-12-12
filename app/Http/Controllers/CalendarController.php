<?php
    
namespace App\Http\Controllers;
    
use App\Models\Calendar;
use Illuminate\Http\Request;
    
class CalendarController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:calendar-list|calendar-create|calendar-edit|calendar-delete', ['only' => ['index','show']]);
         $this->middleware('permission:calendar-create', ['only' => ['create','store']]);
         $this->middleware('permission:calendar-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:calendar-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendars = Calendar::latest()->paginate(5);
        return view('calendar.index',compact('calendars'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        Calendar::create($request->all());
    
        return redirect()->route('calendar.index')
            ->with('success','Calendar created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        return view('calendar.show',compact('calendars'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        return view('calendar.edit',compact('calendars'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        $calendar->update($request->all());
    
        return redirect()->route('calendar.index')
            ->with('success','Calendar updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        $calendar->delete();
    
        return redirect()->route('calendar.index')
            ->with('success','Calendar deleted successfully');
    }
}
