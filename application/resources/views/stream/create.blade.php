@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Create stream item</h4>
                <form action="/stream/store" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate="">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">Stream Name</label>
                            <small class="text-danger">{{$errors->first('name') }}</small>
                            <input type="text" name="name" class="form-control" id="name" placeholder="" value="" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="description">Stream description</label>
                            <small class="text-danger">{{$errors->first('description') }}</small>
                            <input type="text" class="form-control" name="description" id="description" placeholder="" value="" required="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="formFile" class="form-label">Upload preview</label>
                            <small class="text-danger">{{$errors->first('stream_preview') }}</small>
                            <input class="form-control" type="file" name="stream_preview" id="stream_preview">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Create</button>
                </form>
            </div>
        </div>
@endsection
