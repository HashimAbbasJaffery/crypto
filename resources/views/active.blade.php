@extends('layouts.app',['title' => 'Account Status'])
@section('main-content')
    <div class="container-fluid">
        <div class="text-center">
            <h4>Email verification status</h4>
            @if($status === 'error')
                <i class="fas fa-times-circle mb-3 text-danger" style="font-size: 70px;"></i>
                <p>Hi {{Auth::user() -> first_name}}, the link you chosen is expired. Please try another one.</p>
            @else
                <i class="fas fa-check-circle mb-3 text-success" style="font-size: 70px;"></i>
                <p>Hi {{Auth::user() -> first_name}}, your account has been activated.</p>
            @endif
        </div>
    </div> <!-- container-fluid -->
@endsection

