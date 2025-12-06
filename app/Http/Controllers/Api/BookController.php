<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // 1. Pagination
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'paginate' => 'integer|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Validation error",
                "data" => [
                    "errors" => $validator->errors()
                ]
            ], 422);
        }

        $books = Book::paginate($request->paginate ?? 5);

        return response()->json([
            "success" => true,
            "message" => "Books retrieved successfully",
            "data" => $books
        ], 200);
    }

    // 2. Search by title
    public function search(Request $request)
    {
        $title = $request->query('title');

        $books = Book::where('title', 'like', "%$title%")->get();

        return response()->json($books);
    }

    // 3. Filter by year
    public function filterByYear(Request $request)
    {
        $year = $request->query('year');

        $books = Book::where('year', $year)->get();

        return response()->json($books);
    }

    // 4. Filter by publisher & author
    public function filterByPublisherAndAuthor(Request $request)
    {
        $publisher = $request->query('publisher');
        $author = $request->query('author');

        $books = Book::where('publisher', 'like', "%$publisher%")
                ->where('author', 'like', "%$author%")
                ->get();

        return response()->json($books);
    }

    // 5. Range filter by year
    public function range(Request $request)
    {
        // validasi sederhana
        $validator = Validator::make($request->all(), [
            'start' => 'required|digits:4|integer',
            'end'   => 'required|digits:4|integer|gte:start'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $start = (int) $request->query('start');
        $end   = (int) $request->query('end');

        $books = Book::whereBetween('year', [$start, $end])->get();

        return response()->json([
            'success' => true,
            'message' => "Books between {$start} and {$end}",
            'data'    => $books
        ], 200);
    }

    public function sortByYear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required|in:asc,desc'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $order = $request->query('order', 'asc');
        $books = Book::orderBy('year', $order)->get();
        return $books;
    }
}
