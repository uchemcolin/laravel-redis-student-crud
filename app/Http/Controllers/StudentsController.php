<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class StudentsController extends Controller
{
    /**
     * 🏫 CONSTRUCTOR - Like setting up our classroom before students arrive
     * This runs every time we use this controller
     */
    public function __construct()
    {
        // Tell Redis to use database 2 (like going to the 2nd floor)
        Redis::select(2);
    }
    
    /**
     * 📋 SHOW ALL STUDENTS - Like taking attendance
     */
    public function index()
    {
        // Get all student IDs from database 2
        $allStudentIds = Redis::smembers('students:all');
        
        $students = [];
        
        foreach ($allStudentIds as $id) {
            $studentData = Redis::hgetall("student:{$id}");
            if (!empty($studentData)) {
                $students[$id] = $studentData;
            }
        }
        
        return view('students.index', ['students' => $students]);
    }
    
    /**
     * ➕ ADD A NEW STUDENT - Like enrolling someone new
     */
    public function store(Request $request)
    {
        // Make sure we have good data
        $request->validate([
            'name' => 'required|string|max:100',
            'grade' => 'required|string|max:20',
            'age' => 'required|integer|min:1|max:100',
        ]);
        
        // Create a unique ID (like a student ID number)
        $studentId = time(); // Example: 1709123456
        
        // Save to Redis DATABASE 2
        Redis::hmset("student:{$studentId}", [
            'name' => $request->name,
            'grade' => $request->grade,
            'age' => $request->age,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        // Add to class roster
        Redis::sadd('students:all', $studentId);
        
        return redirect()->route('students.index')
                         ->with('success', "🎉 Welcome {$request->name} to our class!");
    }
    
    /**
     * 🔍 SHOW ONE STUDENT - Like calling one student to the front
     */
    public function show($id)
    {
        $student = Redis::hgetall("student:{$id}");
        
        if (empty($student)) {
            return redirect()->route('students.index')
                             ->with('error', '😢 Student not found in database 2!');
        }
        
        return view('students.show', [
            'student' => $student,
            'id' => $id
        ]);
    }
    
    /**
     * ✏️ SHOW EDIT FORM - Like getting a form to fill out
     */
    public function edit($id)
    {
        $student = Redis::hgetall("student:{$id}");
        
        if (empty($student)) {
            return redirect()->route('students.index')
                             ->with('error', '😢 Cannot edit - student not found!');
        }
        
        return view('students.edit', [
            'student' => $student,
            'id' => $id
        ]);
    }
    
    /**
     * 📝 UPDATE STUDENT - Like fixing a mistake in the roll book
     * This updates EVERYTHING about the student
     */
    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:100',
            'grade' => 'required|string|max:20',
            'age' => 'required|integer|min:1|max:100',
        ]);
        
        // Check if student exists
        if (!Redis::exists("student:{$id}")) {
            return redirect()->route('students.index')
                             ->with('error', '😢 Student not found!');
        }
        
        // UPDATE ALL FIELDS at once
        Redis::hmset("student:{$id}", [
            'name' => $request->name,
            'grade' => $request->grade,
            'age' => $request->age,
            'updated_at' => date('Y-m-d H:i:s'),
            // Note: created_at stays the same!
        ]);
        
        return redirect()->route('students.show', $id)
                         ->with('success', "✏️ Student information updated!");
    }
    
    /**
     * 🎯 UPDATE SINGLE FIELD - Like changing just the grade
     */
    public function updateField(Request $request, $id)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string'
        ]);
        
        // Check if student exists
        if (!Redis::exists("student:{$id}")) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        
        // Update just ONE field
        Redis::hset("student:{$id}", $request->field, $request->value);
        Redis::hset("student:{$id}", 'updated_at', date('Y-m-d H:i:s'));
        
        return response()->json(['success' => true, 'message' => 'Field updated!']);
    }
    
    /**
     * 📈 INCREMENT A FIELD - Like adding 1 to age or visit count
     */
    public function incrementField($id, $field)
    {
        if (!Redis::exists("student:{$id}")) {
            return redirect()->back()->with('error', 'Student not found!');
        }
        
        // Increase by 1 (like age++)
        $newValue = Redis::hincrby("student:{$id}", $field, 1);
        Redis::hset("student:{$id}", 'updated_at', date('Y-m-d H:i:s'));
        
        return redirect()->back()->with('success', "{$field} is now {$newValue}!");
    }
    
    /**
     * 🔢 INCREMENT BY AMOUNT - Like adding 5 to age
     */
    public function incrementByAmount(Request $request, $id)
    {
        $request->validate([
            'field' => 'required|string',
            'amount' => 'required|integer|min:1'
        ]);
        
        if (!Redis::exists("student:{$id}")) {
            return redirect()->back()->with('error', 'Student not found!');
        }
        
        $newValue = Redis::hincrby("student:{$id}", $request->field, $request->amount);
        Redis::hset("student:{$id}", 'updated_at', date('Y-m-d H:i:s'));
        
        return redirect()->back()->with('success', 
            "{$request->field} increased by {$request->amount} to {$newValue}!");
    }
    
    /**
     * ❌ DELETE A STUDENT - Like when someone moves away
     */
    public function destroy($id)
    {
        $name = Redis::hget("student:{$id}", 'name');
        
        // Delete from database 2
        Redis::del("student:{$id}");
        Redis::srem('students:all', $id);
        
        return redirect()->route('students.index')
                         ->with('success', "👋 Goodbye {$name}! We'll miss you!");
    }
    
    /**
     * 🧹 DELETE A SINGLE FIELD - Like removing just the phone number
     */
    public function deleteField($id, $field)
    {
        Redis::hdel("student:{$id}", $field);
        Redis::hset("student:{$id}", 'updated_at', date('Y-m-d H:i:s'));
        
        return redirect()->back()->with('success', "{$field} was removed!");
    }
    
    /**
     * 🔍 CHECK DATABASE - See what database we're using
     */
    public function checkDatabase()
    {
        // This is just to show we're really using db:2
        $db = Redis::client()->getDb();
        return "We are using database: {$db}";
    }
}
