@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Add a new book to the list

                        <div class="float-right">
                            <a href="{{ route('index') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-fw fa-angle-left"></i>
                                Back previous
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('create') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">Book title</label>
                                <input type="text" class="form-control"
                                       id="title" name="title" placeholder="Enter the tile" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Book description</label>
                                <textarea class="form-control"
                                          id="description" name="description" placeholder="Write a description"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success btn-block">
                                Add a new book
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

