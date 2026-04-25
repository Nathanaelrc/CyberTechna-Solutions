@if (session('status'))
    <div class="alert alert-success border-0 rounded-4 px-4 py-3 mb-4" role="alert">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger border-0 rounded-4 px-4 py-3 mb-4" role="alert">
        <strong class="d-block mb-2">Hay datos que debes corregir.</strong>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif