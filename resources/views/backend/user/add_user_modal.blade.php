<div class="modal fade" id="add_button" tabindex="-1" role="dialog" aria-labelledby="add_buttonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.save_user') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if (\Illuminate\Support\Facades\Auth::user()->id == 92)
                        <div class="form-group">
                            <label for="Route_name">Inspectorate</label>
                            <select name="insp_id" id="insp_id" class="form-control">\
                                <option value="">Select Inspectorate</option>
                                @foreach ($inspectorates as $inspectorate)
                                    <option value="{{ $inspectorate->id }}">{{ $inspectorate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="Route_name">username</label>
                        <input type="text" class="form-control" id="Route name" name="name">
                    </div>


                    <div class="form-group">
                        <label for="Route_name">Mobile</label>
                        <input type="text" class="form-control" name="mobile">
                    </div>

                    <div class="form-group">
                        <label for="Route_name">user Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                    </div>

                    <div class="form-group">
                        <label for="Route_name">user Password</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="Route_name">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">

                    </div>


                    <div class="form-group">
                        <label for="status">Role</label>
                        <select class="form-control" id="status" name="role_id">
                            <option value="" disabled selected>Select One</option>
                            @foreach ($role as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Assign Section</label>
                        @if ($section)
                            @foreach ($section as $s)
                                <br> <input type="checkbox" value="{{ $s->id }}"  name="sec_id[]">
                                {{ $s->name }}
                            @endforeach
                        @endif
                        <br><span id="error_sec_id" class="text-danger error_field"></span>
                    </div>
                    <div class="form-group">
                        <label for="designation">Designation</label>
                        <select class="form-control " id="desig_id" name="desig_id">

                            <option value="">Please Select</option>
                            @if ($designation)
                                @foreach ($designation as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            @endif

                        </select>
                        <span id="error_desig_id" class="text-danger error_field"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-secondary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
