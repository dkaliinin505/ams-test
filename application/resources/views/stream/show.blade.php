@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
            <div class="card-body">
                @if($data->status == 'broadcasting')
                <iframe width="500" height="500" src="http://192.168.1.234:5080/LiveApp/play.html?name={{$data->streamId}}" frameborder="1" allowfullscreen></iframe>
                @else
                <img width="300px" height="300px" src="{{asset('storage/previews/'.$data->streamId.'.jpg')}}">
                @endif
                <ul class="list-unstyled mt-3 mb-4">
                    <li><b>Stream Name</b> : {{$data->name}}</li>
                    <li><b>Description</b> : {{$data->description}}</li>
                    <li><b>Author</b> : {{$data->username ?? 'Anon'}}</li>
                    <li><small>Hls Views</small> : {{$data->hlsViewerCount}}</li>
                    <li><small>webRTC Views</small> : {{$data->webRTCViewerCount}}</li>
                    <li><small>rtmp Views</small> : {{$data->rtmpViewerCount}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
