<!-- resources/views/students/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>🏫 My Classroom</title>
    <style>
        /* This is like decorating our classroom */
        body {
            font-family: 'Comic Sans MS', 'Arial', sans-serif;
            background-color: #87CEEB; /* Sky blue */
            margin: 0;
            padding: 20px;
        }
        
        .classroom {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        
        h1 {
            color: #FF6B6B;
            text-align: center;
            font-size: 40px;
            margin-top: 0;
        }
        
        .add-student-form {
            background-color: #FFEAA7;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        
        input {
            padding: 10px;
            margin: 5px;
            border: 2px solid #FFB347;
            border-radius: 10px;
            font-size: 16px;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        .student-card {
            background-color: #E6F3FF;
            border: 3px solid #66B2FF;
            padding: 15px;
            margin: 15px 0;
            border-radius: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .student-info h3 {
            color: #333;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        
        .student-info p {
            color: #666;
            margin: 5px 0;
        }
        
        .actions a, .actions button {
            margin-left: 10px;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .btn-view {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-delete {
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
        
        .success-message {
            background-color: #DFF2BF;
            color: #4F8A10;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .error-message {
            background-color: #FFBABA;
            color: #D8000C;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }
        
        .empty-class {
            text-align: center;
            padding: 50px;
            color: #999;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="classroom">
        <h1>🏫 My Amazing Classroom</h1>
        
        <!-- Show success message if there is one -->
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Show error message if there is one -->
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- FORM TO ADD NEW STUDENT -->
        <div class="add-student-form">
            <h2>➕ Add a New Student</h2>
            <form action="{{ route('students.store') }}" method="POST">
                <!-- This protects our form (like a security guard) -->
                @csrf
                
                <input type="text" name="name" placeholder="Student's name" required>
                <input type="text" name="grade" placeholder="Grade (e.g., 5th)" required>
                <input type="number" name="age" placeholder="Age" required>
                <button type="submit">Add Student</button>
            </form>
        </div>
        
        <!-- LIST OF ALL STUDENTS -->
        <h2>📋 Class Roster ({{ count($students) }} students)</h2>
        
        @if(empty($students))
            <div class="empty-class">
                🎒 No students yet!<br>
                <span style="font-size: 16px;">Add your first student above ☝️</span>
            </div>
        @else
            @foreach($students as $id => $student)
                <div class="student-card">
                    <div class="student-info">
                        <h3>👤 {{ $student['name'] }}</h3>
                        <p>📚 Grade: {{ $student['grade'] }}</p>
                        <p>🎂 Age: {{ $student['age'] }}</p>
                        <p>📅 Joined: {{ $student['created_at'] }}</p>
                    </div>
                    <!-- Inside the student-card, replace the actions div with: -->
                    <div class="actions">
                        <!-- View button -->
                        <a href="{{ route('students.show', $id) }}" class="btn-view">🔍 View</a>
                        
                        <!-- NEW: Edit button -->
                        <a href="{{ route('students.edit', $id) }}" class="btn-edit" style="background-color: #FFA500; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px;">✏️ Edit</a>
                        
                        <!-- Delete form -->
                        <form action="{{ route('students.destroy', $id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Remove this student?')">❌ Delete</button>
                        </form>
                    </div>

                    <!-- Add this to show which database -->
                    <div style="text-align: right; font-size: 12px; color: #999; margin-top: 5px;">
                        📀 DB: 2
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>