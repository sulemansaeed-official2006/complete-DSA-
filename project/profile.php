<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$message = "";
$error = "";

// Handle Password Change
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if (password_verify($current_pass, $user['password'])) {
        if ($new_pass === $confirm_pass) {
            if (strlen($new_pass) >= 8) {
                $new_hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET password = '$new_hashed_pass' WHERE id = '$user_id'";
                if ($conn->query($update_sql) === TRUE) {
                    $message = "Password updated successfully.";
                    $user['password'] = $new_hashed_pass; 
                } else { $error = "Database error."; }
            } else { $error = "New password must be min 8 chars."; }
        } else { $error = "New passwords do not match."; }
    } else { $error = "Incorrect current password."; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #0ea5e9;
            --bg-dark: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-light: #e2e8f0;
            --text-dim: #94a3b8;
            --accent-green: #10b981;
            --accent-red: #ef4444; 
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter', sans-serif; }

        body {
            background: #0f172a;
            color: var(--text-light);
            min-height: 100vh;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(14, 165, 233, 0.15) 0px, transparent 50%);
            padding: 40px 20px;
        }
        
        .layout { 
            max-width: 950px; margin: 0 auto; 
            display: grid; grid-template-columns: 260px 1fr; gap: 30px; 
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* SIDEBAR */
        .sidebar { margin-top: 20px; }
        .sidebar h2 { font-size: 22px; margin-bottom: 25px; font-weight: 700; color: white; }
        
        .tab-btn {
            display: flex; align-items: center; width: 100%; text-align: left; padding: 14px 18px;
            background: rgba(255,255,255,0.03); border: none; border-radius: 12px; margin-bottom: 10px;
            font-weight: 500; color: var(--text-dim); cursor: pointer; transition: 0.2s;
            border: 1px solid transparent;
        }
        .tab-btn i { width: 25px; }
        .tab-btn:hover { background: rgba(255,255,255,0.08); color: white; }
        .tab-btn.active {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.2) 0%, rgba(79, 70, 229, 0.1) 100%);
            color: #818cf8; border-color: #4f46e5;
        }
        
        .back-link { 
            display: inline-block; margin-top: 30px; color: var(--text-dim); text-decoration: none; font-size: 14px; 
            transition: 0.3s;
        }
        .back-link:hover { color: white; transform: translateX(-5px); }

        /* CONTENT CARD */
        .card { 
            background: var(--card-bg); 
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px; padding: 40px; 
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.5); 
        }
        
        .section-header { margin-bottom: 35px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px; }
        .section-header h3 { font-size: 24px; margin-bottom: 8px; color: white; }
        .section-header p { color: var(--text-dim); font-size: 14px; }
        
        /* Profile Info Styles */
        .info-row { 
            display: grid; grid-template-columns: 180px 1fr; margin-bottom: 25px; align-items: center; 
            padding: 15px; background: rgba(0,0,0,0.2); border-radius: 10px; border: 1px solid rgba(255,255,255,0.03);
            transition: 0.3s;
        }
        .info-row:hover { background: rgba(255,255,255,0.05); transform: translateX(5px); }
        
        .label { font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .value { font-size: 16px; font-weight: 500; color: white; }

        /* Password Form Styles */
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-size: 14px; margin-bottom: 10px; font-weight: 500; color: #cbd5e1; }
        
        input { 
            width: 100%; padding: 14px; 
            background: #0f172a; border: 1px solid #334155; 
            border-radius: 10px; font-size: 15px; color: white; transition: 0.3s;
        }
        input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 15px rgba(79, 70, 229, 0.2); }
        
        .btn-save {
            background: linear-gradient(135deg, var(--primary), #4338ca); 
            color: white; padding: 14px 28px; border: none;
            border-radius: 10px; font-weight: 600; cursor: pointer;
            width: 100%; font-size: 15px; transition: 0.3s;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(79, 70, 229, 0.4); }
        
        /* Utilities */
        .hidden { display: none; }
        .alert { padding: 15px; border-radius: 10px; margin-bottom: 25px; font-size: 14px; font-weight: 500; display:flex; align-items:center; gap:10px; }
        .success { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid #059669; }
        .error { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid #b91c1c; }
        
        /* Avatar Placeholder */
        .profile-header {
            display: flex; align-items: center; gap: 20px; margin-bottom: 30px;
        }
        .avatar-large {
            width: 80px; height: 80px; font-size: 32px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: white; box-shadow: 0 10px 30px rgba(79, 70, 229, 0.4);
            border: 3px solid #1e293b;
        }
    </style>
</head>
<body>

<div class="layout">
    <div class="sidebar">
        <h2>Settings</h2>
        <button class="tab-btn active" onclick="showTab('profile', this)">
            <i class="fa-regular fa-user"></i> Profile Details
        </button>
        <button class="tab-btn" onclick="goToHistory()">
            <i class="fa-solid fa-clock-rotate-left"></i> Activity History
        </button>
        <button class="tab-btn" onclick="showTab('security', this)">
            <i class="fa-solid fa-lock"></i> Security
        </button>
        
        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </div>

    <div class="card">
        
        <div id="profile-tab">
            <div class="section-header">
                <h3>Profile Information</h3>
                <p>Manage your account details and preferences.</p>
            </div>
            
            <div class="profile-header">
                <div class="avatar-large">
                    <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
                </div>
                <div>
                    <h2 style="font-size:20px; color:white; margin-bottom:5px;"><?php echo htmlspecialchars($user['fullname']); ?></h2>
                    <span style="background: rgba(79,70,229,0.2); color:#818cf8; padding:5px 10px; border-radius:20px; font-size:12px; font-weight:600;">Standard User</span>
                </div>
            </div>
            
            <div class="info-row">
                <span class="label">Full Name</span>
                <span class="value"><?php echo htmlspecialchars($user['fullname']); ?></span>
            </div>
            <div class="info-row">
                <span class="label">Email Address</span>
                <span class="value"><?php echo htmlspecialchars($user['email']); ?></span>
            </div>
            <div class="info-row">
                <span class="label">Phone Number</span>
                <span class="value"><?php echo htmlspecialchars($user['phone']); ?></span>
            </div>
            <div class="info-row">
                <span class="label">CNIC / ID</span>
                <span class="value"><?php echo htmlspecialchars($user['cnic']); ?></span>
            </div>
            <div class="info-row">
                <span class="label">Date of Birth</span>
                <span class="value"><?php echo htmlspecialchars($user['dob']); ?></span>
            </div>
        </div>

        <div id="security-tab" class="hidden">
            <div class="section-header">
                <h3>Change Password</h3>
                <p>Ensure your account is using a strong, unique password.</p>
            </div>

            <?php if($message) echo "<div class='alert success'><i class='fa-solid fa-check'></i> $message</div>"; ?>
            <?php if($error) echo "<div class='alert error'><i class='fa-solid fa-triangle-exclamation'></i> $error</div>"; ?>
            
            <input type="hidden" id="hasError" value="<?php echo ($message || $error) ? 'yes' : 'no'; ?>">

            <form method="POST">
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" required placeholder="Enter current password">
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" required placeholder="Min 8 characters">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" required placeholder="Confirm new password">
                </div>
                <button type="submit" class="btn-save">Update Password</button>
            </form>
        </div>

    </div>
</div>

<script>
    function showTab(tabName, btn) {
        // Hide all tabs
        document.getElementById('profile-tab').classList.add('hidden');
        document.getElementById('security-tab').classList.add('hidden');
        
        // Remove active class from buttons (only sidebar buttons)
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

        // Show selected tab
        const tab = document.getElementById(tabName + '-tab');
        if(tab) tab.classList.remove('hidden');
        
        if(btn) btn.classList.add('active');
    }
    
    function goToHistory() {
        window.location.href = 'history.php';
    }

    // Retain tab on form submit
    if(document.getElementById('hasError').value === 'yes') {
        const secBtn = document.querySelectorAll('.tab-btn')[2]; // Security btn index
        showTab('security', secBtn);
    }
</script>

</body>
</html>