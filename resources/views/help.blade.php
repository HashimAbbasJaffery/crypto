@extends('layouts.app',['title'=>__('messages.Help Desk')])
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="m-0">@lang('messages.Submit a request')</h4>
                    </div>
                    <div class="card-body">
                        @if(Session::has('success'))
                            <div class="alert alert-success">{{Session::get('success')}}
                                <button type="button" data-dismiss="alert" class="close">&times;</button>
                            </div>
                        @endif
                        <form action="{{route('dashboard.createHelp')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">@lang('messages.Subject')</label>
                                <input type="text" id="name" name="subject" class="form-control"
                                       value="{{old('subject')}}">
                                @error('subject')
                                <span style="color: #ec4646;font-weight: 700;margin-bottom: 20px;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="message">@lang('messages.Message')</label>
                                <textarea id="message" cols="30" rows="10" name="message"
                                          class="form-control">{{old('message')}}</textarea>
                                @error('message')
                                <span style="color: #ec4646;font-weight: 700;margin-bottom: 20px;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary"
                                    name="submit">@lang('messages.Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container-fluid -->
@endsection

