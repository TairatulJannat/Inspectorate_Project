<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HolidayController extends Controller
{
    public function index(){

		return view("backend.holiday.index");
	}
	public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Holiday::leftJoin('halls', 'halls.id', 'holidays.hall_id')
            ->select('holidays.*', 'halls.name as hall_name')
            ->get();

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn('hall_name', function ($data) {
                    if ($data->hall_name) {
                        return $data->hall_name;
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($data) {
                    $linkVar = 'admin/holidays/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/holidays/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
				
                ->rawColumns(['action','hall_name'])
                ->make(true);
        }
    }
	public function create(){
        $halls=Hall::all();
		return view("backend.holiday.create", compact('halls'));
	}
	public function store(Request $request){
		$this->validate($request, [
            'hall_id' => 'required',
            'title' => 'required',
            'holiday_date' => 'required', 
        ]);

		$holiday = new Holiday;
		$holiday->hall_id=$request->hall_id;
		$holiday->title=$request->title;
		$holiday->holiday_date=$request->holiday_date;
		$holiday->created_by = auth()->id();
        $holiday->updated_by = auth()->id();
		$holiday->save();
		return response()->json(['success' => 'Done']);
	}
	
	public function edit($id){
		$holiday = Holiday::find($id);
        $hall = Hall::pluck('name', 'id')->toArray();
		return view("backend.holiday.edit", compact('holiday', 'hall'));
	}
	public function update(Request $request){

		$this->validate($request, [
            'title' => 'required',
            'hall_id' => 'required',
            'holiday_date' => 'required',
                 
        ]);
		
		$prev = Holiday::where('id', $request->edit_id)->first();	
		$prev->hall_id=$request->hall_id;
		$prev->title=$request->title;
		$prev->holiday_date=$request->holiday_date;
		$prev->updated_by= auth()->id();

		$prev->save();
		if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
	}
	public function delete( $id){

		$holiday = Holiday::find($id);
        $holiday->delete();
        return response()->json(['success' => 'Done']);	
	}
}
