<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GuestController extends Controller
{
	public function index(){
		
		return view("backend.guest.index");
	}
	public function all_data(Request $request)
    {
        if ($request->ajax()) {
            $query = Guest::all();

            // $query->orderBy('hall_id', 'asc');
          
            return DataTables::of($query)
                ->setTotalRecords($query->count())
                ->addIndexColumn()
                ->addColumn("image", function ($data) {
                
                    if ($data->image) {
                        $url = asset("assets/backend/images/guests/$data->image");
                    } else {
                        $url = asset("assets/backend/images/no.jpg");
                    }
                    return '<img src=' . $url . ' border="0" width="70" class="img-rounded" align="center" />';
                                       
                    
                })

                ->addColumn("action", function ($data) {
                    $linkVar = 'admin/guests/edit/' . $data->id;
                    $actionBtn = '
                    <div class="mb-1">
                    <a href="' . url('admin/guests/change_password/' . $data->id) . '" class="edit btn btn-outline-info btn-sm">Change Password</a>
                    </div>
                    <div class="btn-group" role="group">
                           
                            <a href="' . url('admin/guests/edit/' . $data->id) . '" class="edit btn btn-outline-success btn-sm">Edit</a>

                            <a class="btn btn-outline-danger btn-sm " type="button" href="javascript:void(0)" onclick="delete_data(' . $data->id . ')">Delete</a>';
                    return $actionBtn;
                })
				
                ->rawColumns(["action" ,'image'])
                ->make(true);
        }
    }
	public function create(){
		
		return view("backend.guest.create");
	}
	public function store(Request $request){
        
		$this->validate($request, [
            'name' => 'required',
			'mobile' => 'required|min:11',
			'email' => 'required|email',
			// 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|min:6',
                        
        ]);
        $imageName = '';
        if ($request->file('image')) {
            $image     = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalName();
            $image->move(public_path('/assets/backend/images/guests'), $imageName);
        }
	
		$guest = new Guest;
		$guest->name=$request->name;
		$guest->email=$request->email;
		$guest->mobile=$request->mobile;
        $guest->image = $imageName ?? '';
		$guest->password=$request->password;
		$guest->type=$request->type;
		$guest->wing=$request->wing;
		$guest->rank=$request->rank;
		$guest->service_id=$request->service_id;
		$guest->created_by = auth()->id();
        $guest->updated_by = auth()->id();

		$guest->save();
		return response()->json(['success' => 'Done']);
	}
	
	public function edit($id){
		$guest = Guest::find($id);

		return view("backend.guest.edit", compact('guest'));
	}
	public function update(Request $request){

        $this->validate($request, [
            'name' => 'required',
			'mobile' => 'required|min:11',
			'email' => 'required|email',
			// 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',             
        ]);


		$guest = Guest::where('id', $request->edit_id)->first();
        $imageName = $guest->image;
        if ($request->file('image')) {
            $image     = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalName();
            $image->move(public_path('/assets/backend/images/guests'), $imageName);
        }	
		$guest->name=$request->name;
		$guest->email=$request->email;
		$guest->mobile=$request->mobile;
        $guest->image = $imageName ?? '';
		$guest->type=$request->type;
		$guest->wing=$request->wing;
		$guest->rank=$request->rank;
		$guest->service_id=$request->service_id;
        $guest->updated_by = auth()->id();

		if ($guest->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
	}
	public function delete( $id){

		$ramadan = Guest::find($id);
        $ramadan->delete();
        return response()->json(['success' => 'Done']);	
	}
    public function change_password($id){
        $guest = Guest::find($id);

		return view("backend.guest.change_password", compact('guest'));
    }
    public function update_password(Request $request){
        $this->validate($request, [
           
			'set_pass' => 'required|min:6'
			            
        ]);
        $guest = Guest::where('id', $request->edit_id)->first();

        $guest->password=$request->set_pass;
        $guest->updated_by = auth()->id();

		if ($guest->update()) {
            return response()->json(['success' => 'Done']);
        } else {
            return response()->json(['error' => 'Failed']);
        }
    }
}

