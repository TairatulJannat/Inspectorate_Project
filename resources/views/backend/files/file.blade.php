<div class="row p-0 mx-0 my-2">
    @if ($files)
        @foreach ($files as $file)
            <div class="col-3">

                <a class=" mt-3 btn-parameter text-light" href="{{ asset('storage/' . $file->path) }}" target="_blank"><img
                        src="{{ asset('assets/backend/images/pdf.png') }}" alt=""></a>
                <p class="text-success">{{ $file->file_name }}</p>
            </div>
        @endforeach
    @endif


</div>
