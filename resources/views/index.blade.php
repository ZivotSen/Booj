@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Modal -->
        <div class="modal fade" id="remove" tabindex="-1" aria-labelledby="removeModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="removeModal">Delete a book from your list</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>Are you want to delete this book?</h4>
                    </div>
                    <div class="modal-footer">
                        <form id="form_delete" method="POST">
                            {{ method_field('DELETE') }}
                            @csrf
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        List of Books

                        <div class="float-right">
                            <a href="{{ route('create') }}" class="btn btn-sm btn-outline-primary">Add a Book</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="books" class="table table-books table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Added at</th>
                                    <th style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($books) && count($books) > 0)
                                    @foreach($books as $book)
                                        <tr id="book_{{ $book->id }}">
                                            <td>{{ $book->order }}</td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ $book->description }}</td>
                                            <td>{{ $book->created_at }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('view', $book->id) }}" class="btn btn-sm btn-outline-primary">
                                                    View
                                                </a>
                                                <a href="{{ route('update', $book->id) }}" class="btn btn-sm btn-outline-success">
                                                    Update
                                                </a>
                                                <a class="btn btn-sm btn-outline-danger open-modal"
                                                   data-toggle="modal" data-target="#remove"
                                                   data-route="{{ route('delete', $book->id) }}">
                                                    Remove
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
    <script>
        $(document).ready(() => {
            $('.open-modal').on('click', function(){
                let form = $('#form_delete');
                let route = $(this).attr('data-route');
                console.log(route);
                form.attr('action', '');
                form.attr('action', route);
            })
        })
    </script>
@endsection

