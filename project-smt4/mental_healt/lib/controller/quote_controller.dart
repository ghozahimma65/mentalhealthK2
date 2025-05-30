// app/Http/Controllers/Api/QuoteController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quote; // Pastikan ini model MongoDB Anda
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Quote::query();

        // Filter berdasarkan tipe jika field 'type' ada di model dan data
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan kategori jika field 'category' ada di model dan data
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $quotes = $query->paginate(10); // Pagination tetap berfungsi

        return response()->json($quotes);
    }

    public function random(Request $request)
    {
        $query = Quote::query();

        // Filter berdasarkan tipe jika field 'type' ada di model dan data
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan kategori jika field 'category' ada di model dan data
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $quote = $query->inRandomOrder()->first(); // inRandomOrder() didukung

        if (!$quote) {
            return response()->json(['message' => 'No entries found matching your criteria.'], 404);
        }

        return response()->json($quote);
    }

    public function show(Quote $quote) // Route model binding juga berfungsi
    {
        return response()->json($quote);
    }
}