@extends('layouts.app',['title'=>__('messages.Profile')])
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body  met-pro-bg">
                        <div class="met-profile">
                            <div class="row">
                                <div class="col-lg-4 align-self-center">
                                    <div class="met-profile-main">
                                        <form id="avatar-form" name="avatar-form"
                                              action="{{route('image.update', ['id' => Auth::user()->id])}}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="met-profile-main-pic">
                                                @if(!empty(Auth::user()->photo))
                                                    <img src="{{asset('media/profileImages/'.Auth::user()->photo)}}"
                                                         style="height: 100px;" alt="" class="rounded-circle">
                                                @else
                                                    <img src="{{asset('images/user.png')}}" alt=""
                                                         class="rounded-circle">
                                                @endif
                                                <label for="photo" class="d-block mx-auto">
                                                    <span class="fro-profile_main-pic-change"><i
                                                            class="fas fa-camera"></i></span>
                                                    <input type="file" onchange="document.forms['avatar-form'].submit()"
                                                           name="photo" id="photo" class="d-none">
                                                </label>
                                            </div>
                                        </form>
                                        <div class="met-profile_user-detail">
                                            <h5 class="met-user-name">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h5>
                                            <p class="mb-0 met-user-name-post">{{ ucwords(Auth::user()->role) }}</p>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-4 ml-auto">
                                    <ul class="list-unstyled personal-detail">
                                        <li class=""><i class="dripicons-device-mobile mr-2 text-info font-18"></i>
                                            <b>@lang('messages.Cell') </b> : {{Auth::user()->cell}}
                                        </li>
                                        <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                                @lang('messages.Email') </b> : {{Auth::user()->email}}
                                        </li>
                                    </ul>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end f_profile-->
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->

        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>@lang('messages.Update profile')</h5>
                        <form method="POST" id="name-change">
                            <div class="message"></div>
                            <div class="form-group">
                                <label for="first_name">@lang('messages.First name')</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                       placeholder="First name" value="{{Auth::user() -> first_name}}">
                            </div>
                            <div class="form-group">
                                <label for="first_name">@lang('messages.Last name')</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                       placeholder="Last name" value="{{Auth::user() -> last_name}}">
                            </div>
                            <button type="submit" class="btn btn-success">@lang('messages.Save')</button>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>@lang('messages.Personal Information')</h5>
                        <form method="POST" id="change-info">
                            <div class="message"></div>
                            <div class="form-group">
                                <label for="email">@lang('messages.Email')</label>
                                <input type="text" name="email" id="email" class="form-control"
                                       placeholder="Enter valid email" value="{{Auth::user() -> email}}">
                            </div>
                            <div class="form-group">
                                <label for="cell">@lang('messages.Cell')</label>
                                <input type="text" name="cell" id="cell" class="form-control" placeholder="Last name"
                                       value="{{Auth::user() -> cell}}">
                            </div>
                            <button type="submit" class="btn btn-success">@lang('messages.Save')</button>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5>@lang('messages.Change Password')</h5>
                        <form method="POST" id="change-password" data-user_id="{{Auth::user() -> id}}">
                            <div class="message"></div>
                            <div class="form-group">
                                <label for="old-password">@lang('messages.Old Password')</label>
                                <input type="password" id="old-password" name="old_password"
                                       placeholder="@lang('messages.Please enter your old password.')"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="new-password">@lang('messages.New Password')</label>
                                <input type="password" id="new-password" name="new_password"
                                       placeholder="@lang('messages.Please enter new password.')" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">@lang('messages.Confirm Password')</label>
                                <input type="password" id="confirm-password" name="confirm_password"
                                       placeholder="@lang('messages.Confirm Password')" class="form-control">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" checked name="check"
                                       value="true">
                                <label class="form-check-label"
                                       for="exampleCheck1">@lang('messages.Keep me logged in')</label>
                            </div>
                            <button type="submit" name="change" class="btn btn-success">@lang('messages.Save')</button>
                        </form>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div><!--end row-->
    </div><!-- container -->
    @php
        $scripts = ['main'];
    @endphp
@endsection

