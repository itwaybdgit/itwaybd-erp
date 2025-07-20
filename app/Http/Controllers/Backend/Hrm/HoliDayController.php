<?php

namespace App\Http\Controllers\Backend\Hrm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class HoliDayController extends Controller
{
     public function index(Request $request)
{
    $title = 'Add New HoliDay';



    return view('backend.pages.hrm.holi_day.index', compact('title'));
}

 public function indexList(Request $request): JsonResponse
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $query = Holiday::whereYear('date', $year);

        if ($month) {
            $query->whereMonth('date', $month);
        }

        $holidays = $query->orderBy('date')->get();

        return response()->json([
            'success' => true,
            'data' => $holidays
        ]);
    }

     public function getByDate(Request $request): JsonResponse
    {
        $date = $request->get('date');

        if (!$date) {
            return response()->json([
                'success' => false,
                'message' => 'Date parameter is required'
            ], 400);
        }

        $holidays = Holiday::whereDate('date', $date)->get();

        return response()->json([
            'success' => true,
            'data' => $holidays
        ]);
    }

 public function store(Request $request): JsonResponse
{
    try {
        if ($request->type === 'weekly') {
            $validated = $request->validate([
                'year' => 'required|integer|min:1900|max:2100',
                'day' => 'required|array|min:1',
                'title' => 'nullable|string|max:255',
            ]);

            $days = $validated['day'];
            $year = $validated['year'];
            $title = $validated['title'];

            $startDate = Carbon::createFromDate($year, 1, 1);
            $endDate = Carbon::createFromDate($year, 12, 31);

            $datesToInsert = [];

            while ($startDate->lte($endDate)) {
                if (in_array(strtolower($startDate->format('l')), $days)) {
                    $datesToInsert[] = [
                        'title' => $title,
                        'date' => $startDate->format('Y-m-d'),
                        'type' => 'weekly',
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                $startDate->addDay();
            }

            Holiday::insert($datesToInsert);

            return response()->json([
                'success' => true,
                'message' => 'Weekly holidays created successfully',
            ], 201);

        } else {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'type' => 'required|in:public,religious,national,weekly,other'
            ]);

            $holiday = Holiday::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Holiday created successfully',
                'data' => $holiday
            ], 201);
        }

    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('Holiday save failed: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'An unexpected error occurred. Please try again.'
        ], 500);
    }
}

    public function show(Holiday $holiday): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $holiday
        ]);
    }

    public function update(Request $request, Holiday $holiday): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'sometimes|required|date',
            'type' => 'sometimes|required|in:public,religious,national,other'
        ]);

        $holiday->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Holiday updated successfully',
            'data' => $holiday
        ]);
    }

    public function destroy(Holiday $holiday): JsonResponse
    {
        $holiday->delete();

        return response()->json([
            'success' => true,
            'message' => 'Holiday deleted successfully'
        ]);
    }



}
