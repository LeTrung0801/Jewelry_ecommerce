@if ($errors->first())
    <div class="alert alert-danger">
        <ul>
            <li>{{ $errors->first() }}</li>
        </ul>
    </div>
@endif
{{-- 
@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif
@if ($errors->first())
<p class="text-red-500 text-xs italic mb-4">{{$errors->first()}}</p>
@endif --}}