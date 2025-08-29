<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📚  Study Planner developed by ShaqTech Solutions</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.8s ease-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        header {
            background: #4a00e0;
            color: white;
            padding: 25px;
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        h2 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            color: #333;
        }

        .form-wrapper {
            padding: 25px;
            background: #f9faff;
            border-bottom: 1px solid #eee;
        }

        form {
            display: grid;
            gap: 12px;
        }

        label {
            font-weight: 500;
            color: #444;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"] {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        input[type="time"]:focus {
            border-color: #4a00e0;
            outline: none;
            box-shadow: 0 0 10px rgba(74, 0, 224, 0.1);
            transform: scale(1.01);
        }

        button {
            margin-top: 10px;
            padding: 12px;
            background: #4a00e0;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        button:hover {
            background: #6a11cb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }

        .tasks-section {
            padding: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        th {
            background: #4a00e0;
            color: white;
            text-align: left;
            padding: 14px;
            font-weight: 500;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            transition: background 0.3s ease;
        }

        tr:hover {
            background: #f0f4ff;
            transform: scale(1.005);
        }

        .course-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        /* Course Colors */
        .arabic   { background: #4a00e0; }  /* Purple */
        .math     { background: #00b894; }  /* Teal */
        .science  { background: #0984e3; }  /* Blue */
        .english  { background: #d63031; }  /* Red */
        .history  { background: #e17055; }  /* Orange */
        .default  { background: #6c5ce7; }  /* Violet */

        .delete-btn {
            background: #d63031;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #c0392b;
            transform: scale(1.1);
        }

        .no-tasks {
            text-align: center;
            color: #777;
            font-style: italic;
            padding: 30px;
            font-size: 1.1rem;
        }

        .fade-out {
            animation: slideUp 0.5s forwards;
        }

        @keyframes slideUp {
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>📘Student Study Planner</h1>
    </header>

    <section class="form-wrapper">
        <form method="POST" action="">
            <h2>➕ Add Study Task</h2>
            <label for="course">Course:</label>
            <input type="text" name="course" id="course" placeholder="e.g., Arabic" required>

            <label for="task">Task:</label>
            <input type="text" name="task" id="task" placeholder="e.g., Learn Syllabus" required>

            <label for="date">Study Date:</label>
            <input type="date" name="date" id="date" required>

            <label for="duration">Duration (HH:MM):</label>
            <input type="time" name="duration" id="duration" required>

            <button type="submit" name="add_task">➕ Add Task</button>
        </form>
    </section>

    <section class="tasks-section">
        <h2>📅 Study Schedule</h2>
        <?php
        // Database configuration
        $host = 'localhost';
        $db   = 'study_planner';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            die("<p style='color:red; text-align:center;'>❌ Database Error: " . htmlspecialchars($e->getMessage()) . "</p>");
        }

        // Add new task
        if (isset($_POST['add_task'])) {
            $course = trim($_POST['course']);
            $task = trim($_POST['task']);
            $date = $_POST['date'];
            $duration = $_POST['duration'];

            if ($course && $task && $date && $duration) {
                $stmt = $pdo->prepare("INSERT INTO study_tasks (course, task, study_date, duration) VALUES (?, ?, ?, ?)");
                $stmt->execute([$course, $task, $date, $duration]);
                echo "<p style='color:green; text-align:center;'>✅ Task added successfully!</p>";
            } else {
                echo "<p style='color:red; text-align:center;'>❌ All fields are required.</p>";
            }
        }

        // Delete task with animation
        if (isset($_GET['delete'])) {
            $id = (int)$_GET['delete'];
            $stmt = $pdo->prepare("DELETE FROM study_tasks WHERE id = ?");
            $stmt->execute([$id]);
            echo "<script>
                    setTimeout(() => {
                        document.getElementById('row_$id').classList.add('fade-out');
                        setTimeout(() => {
                            document.getElementById('row_$id').remove();
                        }, 500);
                    }, 100);
                  </script>";
        }

        // Fetch all tasks
        $stmt = $pdo->query("SELECT id, course, task, study_date, duration FROM study_tasks ORDER BY study_date, created_at");
        $tasks = $stmt->fetchAll();

        if ($tasks): ?>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Task</th>
                        <th>Date</th>
                        <th>Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <?php
                        // Safe class assignment - works on all PHP versions
                        $courseLower = strtolower($task['course']);
                        $badgeClass = 'default';

                        if ($courseLower === 'arabic') {
                            $badgeClass = 'arabic';
                        } elseif ($courseLower === 'math') {
                            $badgeClass = 'math';
                        } elseif ($courseLower === 'science') {
                            $badgeClass = 'science';
                        } elseif ($courseLower === 'english') {
                            $badgeClass = 'english';
                        } elseif ($courseLower === 'history') {
                            $badgeClass = 'history';
                        }
                        ?>
                        <tr id="row_<?= $task['id'] ?>">
                            <td>
                                <span class="course-badge <?= $badgeClass ?>">
                                    <?= htmlspecialchars($task['course']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($task['task']) ?></td>
                            <td><?= date("M d, Y", strtotime($task['study_date'])) ?></td>
                            <td><?= $task['duration'] ?> hrs</td>
                            <td>
                                <a href="?delete=<?= $task['id'] ?>" class="delete-btn"
                                   onclick="return confirm('Delete this task?');">🗑 Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-tasks">✨ No tasks yet. Start planning your success! 🚀</p>
        <?php endif; ?>
    </section>
</div>

</body>
</html>