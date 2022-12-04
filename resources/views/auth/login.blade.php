<body style="background-color: #E2E2E2">
    

@extends('layouts.app')

@section('content')
    <login-component csrf_token="{{ @csrf_token() }}"></login-component>
@endsection
</body>