@extends('layouts.app')

@section('content')
    <div class="card-deck mb-3 text-center">
        <div class="row">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @if($errors->any())
                    <div class="alert alert-danger">
                        {{$errors->first()}}
                    </div>
                @endif
            @endif
            <h1>List of streams</h1>
                @if(isset($data))
                @foreach($data as $item)
                <div class="col">
                    <div class="card mb-4 box-shadow">
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">{{$item->name}}</h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li><small>Stream Id</small> : {{$item->streamId}}</li>
                                <li><small>Stream Status</small> : {{$item->status}}</li>
                                <li><small>Stream Description</small> : {{$item->description}}</li>
                                <li>
                                    <img  width="300px" height="300px" src="{{asset('storage/previews/'.$item->streamId.'.jpg')}}">
{{--                                    <iframe width="170" height="300" src="http://192.168.1.234:5080/LiveApp/play.html?name={{$item->streamId}}" frameborder="1" allowfullscreen></iframe>--}}
                                </li>
                            </ul>
                            <a href="{{route('stream.show',$item->streamId)}}" type="button" class="btn btn-primary">Go to Stream</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
        </div>
    </div>
@stop
