@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Update <strong class="text-title">{{ $book->title }}</strong>

                        <div class="float-right">
                            <a href="{{ route('index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-fw fa-angle-left"></i>
                                Back previous
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="text-description">
                            On this version you can only update the related description and order
                        </h5>

                        <form action="{{ route('update', $book->id) }}" method="POST" class="mt-5">
                            {{ method_field('PUT') }}
                            @csrf

                            <div class="form-group">
                                <label for="description">Book description</label>
                                <textarea class="form-control"
                                          id="description"
                                          name="description"
                                          placeholder="Write a description" required>{{ $book->description }}</textarea>
                            </div>

                            <div class="form-group row">
                                <label for="order" class="col-sm-2 col-form-label">Book order</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control"
                                           id="order" name="order" min="1" step="1" value="{{ $book->order }}" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">
                                Update book
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


