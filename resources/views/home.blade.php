@extends($layout)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
</div>
{{-- Modal login --}}
@include('login')
{{-- Modal register --}}
@include('register')
@endsection
