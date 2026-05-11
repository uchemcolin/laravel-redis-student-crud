<!-- resources/views/students/show.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>👤 Student Details</title>
    <style>
        body {
            font-family: 'Comic Sans MS', 'Arial', sans-serif;
            background-color: #87CEEB;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
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
        
        .student-detail {
            background-color: #FFEAA7;
            padding: 30px;
            border-radius: 15px;
            margin: 20px 0;
        }
        
        .detail-row {
            margin: 15px 0;
            font-size: 20px;
        }
        
        .label {
            font-weight: bold;
            color: #FF8C42;
        }
        
        .value {
            color: #333;
            margin-left: 10px;
        }
        
        .back-button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .back-button:hover {
            background-color: #45a049;
        }

        /* Add these new styles */
        .edit-button {
            display: inline-block;
            background-color: #FFA500;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 10px;
            margin-right: 10px;
        }
        
        .edit-button:hover {
            background-color: #FF8C00;
        }
        
        .action-buttons {
            margin-top: 20px;
            text-align: center;
        }
        
        .field-update-form {
            background-color: #E6F3FF;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
        }
        
        .quick-update {
            display: flex;
            gap: 10px;
            margin: 10px 0;
        }
        
        .quick-update select, .quick-update input, .quick-update button {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        
        .quick-update button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        
        .db-badge {
            background-color: #FF6B6B;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Show which database we're using -->
        <div class="db-badge">
            📀 Using Database: 2
        </div>
        
        <h1>👤 Student Details</h1>
        
        <div class="student-detail">
            <div class="detail-row">
                <span class="label">Student ID:</span>
                <span class="value">{{ $id }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Name:</span>
                <span class="value">{{ $student['name'] ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Grade:</span>
                <span class="value">{{ $student['grade'] ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Age:</span>
                <span class="value">{{ $student['age'] ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Joined:</span>
                <span class="value">{{ $student['created_at'] ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="label">Last Updated:</span>
                <span class="value">{{ $student['updated_at'] ?? 'N/A' }}</span>
            </div>
        </div>
        
        <!-- QUICK FIELD UPDATE - Like changing just one thing -->
        <div class="field-update-form">
            <h3>⚡ Quick Update (Change One Thing)</h3>
            <div class="quick-update">
                <select id="fieldSelect">
                    <option value="name">Name</option>
                    <option value="grade">Grade</option>
                    <option value="age">Age</option>
                </select>
                <input type="text" id="fieldValue" placeholder="New value">
                <button onclick="quickUpdate()">Update Field</button>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('students.edit', $id) }}" class="edit-button">✏️ Edit All Fields</a>
            
            <form action="{{ route('students.destroy', $id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('Remove this student?')">❌ Delete Student</button>
            </form>
        </div>
        
        <br>
        
        <!-- Back button -->
        <a href="{{ route('students.index') }}" class="back-button">← Back to Class</a>
    </div>
    
    <!-- JavaScript for quick updates -->
    <script>
    function quickUpdate() {
        const field = document.getElementById('fieldSelect').value;
        const value = document.getElementById('fieldValue').value;
        const id = {{ $id }};
        
        fetch(`/students/${id}/field`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                field: field,
                value: value
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('✅ Field updated!');
                location.reload();
            } else {
                alert('❌ Error: ' + data.error);
            }
        });
    }
    </script>
</body>
</html>