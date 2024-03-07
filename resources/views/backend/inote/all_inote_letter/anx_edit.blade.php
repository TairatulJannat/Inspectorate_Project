

@if ($anx)
<div class="inote_boc mb-2">
    <div class="container">
        <form ction="" id='saveAnx' method="POST" enctype="multipart/form-data">
            <div class="card-body">
                <h1 class="mb-4">Upload Document</h1>
    
                <div class="file-container">
                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control file-name" name="file_name[]" placeholder="File Name"
                                id="file_name_0">
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input file form-control" name="file[]" id="file_0">
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
            <button type="submit" class="btn btn-success px-4 py-3" >Update</button>
        </form>
    </div>

</div>   
@else
<div class="inote_boc mb-2">
    <div class="p-5">
        <h4>ANX is not created yet</h4>
    </div>
</div>
@endif