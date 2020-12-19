<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response | View
     */
    public function index()
    {
        $books = Book::orderBy('order', 'ASC')->get();
        return view('index')->with([
            'books' => $books
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function listFromAPI(Request $request)
    {
        $books = Book::orderBy('order', 'ASC')->get();
        return response()->json([
            'status' => true,
            'books' => $books,
            'message' => "List of your books."
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response | RedirectResponse | View
     * @throws
     */
    public function store(Request $request)
    {
        if($request->method() == "POST"){
            $input = $request->all();
            Validator::make($input, [
                'title' => 'required|unique:books|max:255',
            ])->validate();

            $book = new Book();
            $this->setOrder($book);
            $book->fill($input)->save();

            Session::flash('success', 'Book was added successfully!');
            return redirect()->route('index');
        }

        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function storeFromAPI(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'title' => 'required|unique:books|max:255',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => $validate->errors()
            ]);
        }

        if(isset($input['order'])){
            unset($input['order']);
        }

        try {
            $book = new Book();
            $this->setOrder($book);
            $book->fill($input)->save();

            return response()->json([
                'status' => true,
                'book' => $book,
                'message' => "Book was added successfully!",
            ]);
        } catch (\Exception $e){
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response | View
     */
    public function show(int $id)
    {
        $book = Book::findOrFail($id);
        return view('view')->with([
            'book' => $book
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function showFromAPI(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'id' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => $validate->errors()
            ]);
        }

        if($book = Book::where('id', $input['id'])->first()){
            return response()->json([
                'status' => true,
                'book' => $book,
                'message' => "Book was found!",
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Book is not present in your list.",
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response | RedirectResponse | View
     * @throws
     */
    public function edit(Request $request, int $id)
    {
        $book = Book::findOrFail($id);

        if($request->method() == "PUT"){
            $input = $request->all();
            if(isset($input['order']) && $input['order']){
                $order = (int) $input['order'];
                if($order !== $book->order){
                    $this->reOrder($book, (int) $input['order']);
                }
            }

            if(isset($input['description'])){
                $book->description = $input['description'];
                $book->save();
            }

            Session::flash('success', 'Book was updated successfully!');
            return redirect()->route('index');
        }

        return view('update')->with([
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function editFromAPI(Request $request)
    {
        $input = $request->all();
        $validate = Validator::make($input, [
            'id' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => $validate->errors()
            ]);
        }

        if($book = Book::where('id', $input['id'])->first()){
            if(isset($input['order']) && $input['order']){
                $order = (int) $input['order'];
                if($order !== $book->order){
                    $this->reOrder($book, (int) $input['order']);
                }
            }

            if(isset($input['description'])){
                $book->description = $input['description'];
                $book->save();
            }

            return response()->json([
                'status' => true,
                'book' => $book,
                'message' => "Book was updated successfully!",
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Book is not present in your list.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response | RedirectResponse | View
     */
    public function destroy(int $id)
    {
        $book = Book::findOrFail($id);
        $this->reOrder($book);
        $book->delete();

        Session::flash('success', 'Book was deleted successfully!');
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function destroyFromAPI(Request $request){
        $input = $request->all();
        $validate = Validator::make($input, [
            'id' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => $validate->errors()
            ]);
        }

        if($book = Book::where('id', $input['id'])->first()){
            $this->reOrder($book);
            $book->delete();

            return response()->json([
                'status' => true,
                'message' => "Book was deleted successfully!",
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Book is not present in your list.",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Book $book
     * @param int|null $order
     */
    private function reOrder(Book $book, $order = null){
        $books = Book::orderBy('order', 'ASC')->get();
        $total = Book::all()->count();

        $update = true;
        if(is_null($order)){
            $to = $total;
            $update = false;
        } else {
            // New order cannot be greater than the total
            $to = $order < $total ? $order : $total;

            // New order cannot be less than 1
            if($to < 1){
                $to = 1;
            }
        }

        $from = $book->order;

        if($from != $to){
            $operation = "+";
            if($from < $to){
                $operation = "-";
                $min = $from;
                $max = $to;
                $item = $min;
            } else {
                $min = $to;
                $max = $from;
                $item = $min - 1;
            }

            while ($min < $max){
                if(isset($books[$item])){
                    switch ($operation){
                        case "+":
                            $newOrder = $books[$item]->order + 1;
                            break;
                        case "-":
                            $newOrder = $books[$item]->order - 1;
                            break;
                        default:
                            break;
                    }

                    if(isset($newOrder) && $newOrder){
                        $books[$item]->update(['order' => $newOrder]);
                    }
                }

                $item++;
                $min++;
            }

            if($update){
                // Update actual book at the end
                $book->update(['order' => $to]);
            }
        }
    }

    private function setOrder(&$object, $order = null){
        $total = Book::all()->count();

        if($order){
            $object->order = $order;
        } else {
            $object->order = $total + 1;
        }
    }
}
