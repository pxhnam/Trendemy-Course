<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function list()
    {
        $courses = Course::select(
            'id',
            'name',
            'lecturer',
            'thumbnail',
            'fake_cost',
            'cost',
            'duration'
        )->latest()
            ->paginate(10);
        if (!$courses->isEmpty()) {
            return response()->json([
                'success' => true,
                'courses' => $courses
            ]);
        } else {
            return response()->json([
                'success' => false, 'message' => 'Không tìm thấy danh sách khóa học.'
            ]);
        }
    }
    public function all()
    {
        $courses = Course::select(
            'id',
            'name',
            'lecturer',
            'thumbnail',
            'fake_cost',
            'cost',
            'duration'
        )->latest()
            ->get();
        if (!$courses->isEmpty()) {
            return response()->json([
                'success' => true,
                'courses' => $courses
            ]);
        } else {
            return response()->json([
                'success' => false, 'message' => 'Không tìm thấy danh sách khóa học.'
            ]);
        }
    }
    public function show($id)
    {
        $course = Course::select(
            'id',
            'name',
            'lecturer',
            'thumbnail',
            'fake_cost',
            'cost',
            'duration'
        )
            ->where('id', $id)
            ->first();
        if ($course) {
            return response()->json([
                'success' => true,
                'course' => $course
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy khóa học.'
            ]);
        }
    }
    public function check($id)
    {
        return Course::where('id', $id)->exists();
    }
    public function getRandomCoursesNotInCart($ids)
    {
        $idsArray = explode(',', $ids);
        $randomCourses = Course::whereNotIn('id', $idsArray)
            ->select(
                'id',
                'name',
                'lecturer',
                'thumbnail',
                'fake_cost',
                'cost',
                'duration'
            )
            ->inRandomOrder()
            ->limit(10)
            ->get();
        return $randomCourses;
    }

    public function store(Request $request)
    {
        try {
            $validated =  $request->validate([
                'name' => 'required|string|max:255',
                'lecturer' => 'required|string|max:255',
                'thumbnail' => 'required|string',
                'fake_cost' => 'required|integer',
                'cost' => 'required|integer',
            ]);

            $validated['num_of_chapters'] = rand(5, 20);
            $validated['num_of_lessons'] = rand(10, 50);
            $validated['time_to_complete'] = rand(1, 30);
            $validated['starts'] = rand(0, 5);
            $validated['duration'] = rand(1, 30);
            $validated['description'] = 'This is a course';

            Course::create($validated);
            return response()->json(['success' => true], 200);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['success' => false, 'message' => $ex->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $course = Course::findOrFail($id);
            $validated =  $request->validate([
                'name' => 'required|string|max:255',
                'lecturer' => 'required|string|max:255',
                'fake_cost' => 'required|integer',
                'cost' => 'required|integer',
            ]);
            $course->name = $request->name;
            $course->lecturer = $request->lecturer;
            $course->fake_cost = $request->fake_cost;
            $course->cost = $request->cost;
            if ($request->thumbnail) {
                $course->thumbnail = $request->thumbnail;
            }
            $course->save();
            return response()->json(['success' => true], 200);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json(['success' => false, 'message' => $ex->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);

            if ($course->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa khóa học thành công.'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa khóa học này.'
                ], 404);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi trong quá tình xóa.'
            ], 500);
        }
    }
}
