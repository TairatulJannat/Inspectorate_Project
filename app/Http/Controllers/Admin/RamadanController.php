<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Hall;
use App\Models\Ramadan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Random;
use Yajra\DataTables\Facades\DataTables;

class RamadanController extends Controller{
	public function index(){
		
		return view("backend.ramadan.index");
	}
	public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Ramadan::leftJoin('halls', 'halls.id', 'ramadans.hall_id')
            ->select('ramadans.*', 'halls.name as hall_name')
            ->get();

            // $query->orderBy('hall_id', 'asc');
          

            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
				->addColumn("hall_name", function ($data) {
                    if ($data->hall_name) {
                        return $data->hall_name;
                    } else {
                        return '';
                    }
                })
                ->addColumn("action", function ($data) {
                    $linkVar = 'admin/hall_price/edit/' . $data->id;
                    $actionBtn = '<div class="btn-group" role="group">
                            <a href="' . url('admin/ramadans/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                           <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
				
                ->rawColumns(["action","hall_name"])
                ->make(true);
        }
    }
	public function create(){
		$halls=Hall::all();
		return view("backend.ramadan.create" ,compact("halls"));
	}
	public function store(Request $request){
		$this->validate($request, [
			'hall_id' => 'required',
			'title' => 'required',
            'starting_date' => 'required',
            'ending_date' => 'required',
            
        ]);
	
	
		$ramadan = new Ramadan;
		$ramadan->hall_id=$request->hall_id;
		$ramadan->title=$request->title;
		$ramadan->starting_date=$request->starting_date;
		$ramadan->end_date=$request->ending_date;
		$ramadan->created_by = auth()->id();
        $ramadan->updated_by = auth()->id();

		$ramadan->save();

		return response()->json(['success' => 'Done']);
	}
	
	public function edit($id){
		$ramadan = Ramadan::find($id);
		
        $hall = Hall::pluck('name', 'id')->toArray();
		return view("backend.ramadan.edit", compact('ramadan','hall'));
	}
	public function update(Request $request){

		$this->validate($request, [
			'hall_id' => 'required',
			'title' => 'required',
            'starting_date' => 'required',
            'ending_date' => 'required',
            
        ]);
		//Ramadan::update($request->all());
		$prev = Ramadan::where('id', $request->edit_id)->first();	
		$prev->hall_id=$request->hall_id;
		$prev->title=$request->title;
		$prev->starting_date=$request->starting_date;
		$prev->end_date=$request->ending_date;
		$prev->updated_by= auth()->id();


		$prev->save();
		if ($prev->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
	}
	public function delete( $id){

		$ramadan = Ramadan::find($id);
        $ramadan->delete();
        return response()->json(['success' => 'Done']);	
	}
}
