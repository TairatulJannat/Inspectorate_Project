<div class="modal fade" id="add_button" tabindex="-1" role="dialog" aria-labelledby="add_buttonLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.dynamic_route') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="add_buttonLabel">Route Details</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Route_name">Route name</label>+
                        <input type="text" class="form-control" id="Route name" aria-describedby="emailHelp"
                            placeholder="Enter Route name" name="title">
                    </div>

                    <div class="form-group">
                        <label for="Route_name">Model name</label>
                        <input type="text" class="form-control" id="Route name" aria-describedby="emailHelp"
                            placeholder="Enter Model name" name="model_name">
                    </div>

                    <div class="form-group">
                        <label for="Route_name">Route Url</label>
                        <input type="text" class="form-control" id="Route name" aria-describedby="emailHelp"
                            placeholder="Enter Route Url" name="url">
                    </div>

                    <div class="form-group">
                        <label for="controller_action">Controller Action</label>
                        <input type="text" class="form-control" id="controller_action" aria-describedby="emailHelp"
                            placeholder="Enter Controller Action" name="controller_action">
                    </div>

                    <div class="form-group">
                        <label for="controller_action">Function Name</label>
                        <input type="text" class="form-control" id="function_name" aria-describedby="emailHelp"
                            placeholder="Enter Controller Action" name="function_name">
                    </div>

                    <div class="form-group">
                        <label for="controller_action">parameter</label>
                        <input type="text" class="form-control" id="controller_action" aria-describedby="emailHelp"
                            name="parameter" placeholder="Enter parameter">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="route_status">
                            <option value="1">Active</option>
                            <option value="0">Diactive</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Method</label>
                        <select class="form-control" id="status" name="method">
                            <option value="get">get</option>
                            <option value="Post">post</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="route_type">Route Type</label>
                        <select class="form-control" id="route_type" name="route_type">
                            <option value="1">Main Route</option>
                            <option value="0">Public Route</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="route_type">Show in Menu</label>
                        <select class="form-control" id="show_in_menu" name="show_in_menu">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="route_type">Ajax Route</label>
                        <select class="form-control" id="ajax" name="ajax">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
