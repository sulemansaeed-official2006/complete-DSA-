<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #0ea5e9;
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-light: #e2e8f0;
            --text-dim: #94a3b8;
            --accent-green: #10b981;
            --accent-orange: #f59e0b;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter', sans-serif; }

        body {
            background: #0f172a;
            color: var(--text-light);
            min-height: 100vh;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.15) 0px, transparent 50%);
        }

        .container { max-width: 800px; margin: 0 auto; padding: 40px 20px; }

        /* Header */
        .header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 20px;
        }
        .header h1 { font-size: 28px; font-weight: 700; background: linear-gradient(to right, #fff, #cbd5e1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .back-btn {
            color: var(--text-dim); text-decoration: none; display: flex; align-items: center; gap: 8px;
            transition: 0.3s; font-size: 14px;
        }
        .back-btn:hover { color: var(--primary); transform: translateX(-5px); }

        /* Timeline */
        .timeline { position: relative; padding-left: 30px; }
        .timeline::before {
            content: ''; position: absolute; left: 0; top: 0; height: 100%; width: 2px;
            background: linear-gradient(to bottom, var(--primary), rgba(255,255,255,0.1));
            border-radius: 2px;
        }

        .t-item {
            position: relative; margin-bottom: 30px;
            background: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 20px; border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            transition: 0.3s;
            animation: slideIn 0.5s ease-out backwards;
        }
        .t-item:hover { transform: translateY(-3px); border-color: rgba(255,255,255,0.1); }

        /* Dot on timeline */
        .t-dot {
            position: absolute; left: -36px; top: 25px;
            width: 14px; height: 14px; border-radius: 50%;
            background: var(--bg-dark); border: 2px solid var(--primary);
            box-shadow: 0 0 10px var(--primary);
            z-index: 1;
        }

        .t-date { position: absolute; top: -25px; left: 0; font-size: 12px; color: var(--text-dim); font-family: 'Fira Code', monospace; }
        
        .t-content { display: flex; align-items: start; gap: 15px; }
        .t-icon {
            min-width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        
        .type-learn { background: rgba(79, 70, 229, 0.2); color: #818cf8; }
        .type-quiz { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .type-login { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }

        .t-info h3 { font-size: 16px; margin-bottom: 5px; color: white; }
        .t-info p { font-size: 14px; color: var(--text-dim); line-height: 1.5; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Stagger animation */
        .t-item:nth-child(1) { animation-delay: 0.1s; }
        .t-item:nth-child(2) { animation-delay: 0.2s; }
        .t-item:nth-child(3) { animation-delay: 0.3s; }
        .t-item:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1><i class="fa-solid fa-clock-rotate-left"></i> Activity History</h1>
        <a href="dashboard.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <div class="timeline">
        
        <!-- Mock Data for specific user feel -->
        
        <!-- Item 1 -->
        <div class="t-item">
            <div class="t-dot"></div>
            <div class="t-date">Just Now</div>
            <div class="t-content">
                <div class="t-icon type-learn"><i class="fa-solid fa-cubes-stacked"></i></div>
                <div class="t-info">
                    <h3>Mastered Heaps</h3>
                    <p>Completed the Max Heap & Heap Sort simulation module.</p>
                </div>
            </div>
        </div>

        <!-- Item 2 -->
        <div class="t-item">
            <div class="t-dot" style="border-color: var(--accent-green); box-shadow: 0 0 10px var(--accent-green);"></div>
            <div class="t-date">2 Hours Ago</div>
            <div class="t-content">
                <div class="t-icon type-quiz"><i class="fa-solid fa-share-nodes"></i></div>
                <div class="t-info">
                    <h3>Graph Explorer</h3>
                    <p>Successfully ran BFS and DFS traversals on a custom graph.</p>
                </div>
            </div>
        </div>

        <!-- Item 3 -->
        <div class="t-item">
            <div class="t-dot" style="border-color: var(--accent-orange); box-shadow: 0 0 10px var(--accent-orange);"></div>
            <div class="t-date">Yesterday, 10:45 AM</div>
            <div class="t-content">
                <div class="t-icon type-login"><i class="fa-solid fa-arrow-right-to-bracket"></i></div>
                <div class="t-info">
                    <h3>Login</h3>
                    <p>Logged in from Chrome on Windows 11.</p>
                </div>
            </div>
        </div>

        <!-- Item 4 -->
        <div class="t-item">
            <div class="t-dot"></div>
            <div class="t-date">Jan 12, 2026</div>
            <div class="t-content">
                <div class="t-icon type-learn"><i class="fa-solid fa-layer-group"></i></div>
                <div class="t-info">
                    <h3>Started Queue Module</h3>
                    <p>Learned about FIFO principles and Circular Queues.</p>
                </div>
            </div>
        </div>

    </div>
    
    <div style="text-align: center; margin-top: 40px; color: var(--text-dim); font-size: 13px;">
        <p>Showing last 4 activities. <a href="#" style="color:var(--primary); text-decoration:none;">Load More</a></p>
    </div>
</div>

</body>
</html>
