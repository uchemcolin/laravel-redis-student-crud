<!-- resources/views/students/edit.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>✏️ Edit Student</title>
    <style>
        body {
            font-family: 'Comic Sans MS', 'Arial', sans-serif;
            background-color: #87CEEB;
            padding: 20px;
        }
        
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        
        h1 {
            color: #FF6B6B;
            text-align: center;
        }
        
        .form-group {
            margin: 20px 0;
        }
        
        label {
            display: block;
            font-weight: bold;
            color: #FF8C42;
            margin-bottom: 5px;
            font-size: 18px;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #FFB347;
            border-radius: 10px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        .cancel {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
        }
        
        .info {
            background-color: #E6F3FF;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ Edit Student</h1>
        
        <div class="info">
            Editing Student ID: {{ $id }}
        </div>
        
        <form action="{{ route('students.update', $id) }}" method="POST">
            @csrf
            @method('PUT') <!-- This tells Laravel it's an UPDATE -->
            
            <div class="form-group">
                <label>👤 Name:</label>
                <input type="text" name="name" value="{{ $student['name'] }}" required>
            </div>
            
            <div class="form-group">
                <label>📚 Grade:</label>
                <input type="text" name="grade" value="{{ $student['grade'] }}" required>
            </div>
            
            <div class="form-group">
                <label>🎂 Age:</label>
                <input type="number" name="age" value="{{ $student['age'] }}" required>
            </div>
            
            <button type="submit">💾 Save Changes</button>
        </form>
        
        <a href="{{ route('students.show', $id) }}" class="cancel">← Cancel and go back</a>
    </div>
</body>
</html>