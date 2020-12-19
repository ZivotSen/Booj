@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Details for book <strong class="text-title">{{ $book->title }}</strong>

                        <div class="float-right">
                            <a href="javascript:history.back()" class="btn btn-primary btn-sm">
                                <i class="fa fa-fw fa-angle-left"></i>
                                Back previous
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <th class="font-weight-bold" style="width: 25%">
                                        Identifier
                                    </th>
                                    <th>{{ $book->id }}</th>
                                </tr>
                                <tr>
                                    <th class="font-weight-bold">
                                        Read Order
                                    </th>
                                    <th>{{ $book->order }}</th>
                                </tr>
                                <tr>
                                    <th class="font-weight-bold">
                                        Book Title
                                    </th>
                                    <th>{{ $book->title }}</th>
                                </tr>
                                @if($book->description)
                                    <tr>
                                        <th class="font-weight-bold">
                                            Book Description
                                        </th>
                                        <th>{{ $book->description }}</th>
                                    </tr>
                                @endif
                                <tr>
                                    <th class="font-weight-bold">
                                        Added at
                                    </th>
                                    <th>{{ $book->created_at }}</th>
                                </tr>
                                <tr>
                                    <th class="font-weight-bold">
                                        Updated at
                                    </th>
                                    <th>{{ $book->updated_at }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

