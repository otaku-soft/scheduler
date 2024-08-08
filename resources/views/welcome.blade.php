@extends('layouts/public')
@section('content')
<h2>Welcome to {{ env('APP_NAME') }} </h2>
<br/><br/>
<p >
    {{ env('APP_DESCRIPTION') }}
</p>
@endsection
