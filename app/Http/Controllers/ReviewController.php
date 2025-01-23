<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'order'])->orderBy('created_at', 'desc')->get();
        $unreviewed_orders = Order::where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->whereDoesntHave('review')
            ->get();
        
        return view('reviews.index', compact('reviews', 'unreviewed_orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $review = new Review();
        $review->order_id = $request->order_id;
        $review->user_id = auth()->id();
        $review->rating = $request->rating;
        $review->comment = $request->comment;

        // Obsługa zdjęcia
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Store the file in the public disk
            $file->storeAs('reviews', $filename, 'public');
            
            // Zapisz tylko nazwę pliku w bazie danych
            $review->image = $filename;
        }

        $review->save();

        return redirect()->route('reviews.index')->with('success', 'Ocena została dodana!');
    }

    public function getImage($filename)
    {
        $path = storage_path('app/public/reviews/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}