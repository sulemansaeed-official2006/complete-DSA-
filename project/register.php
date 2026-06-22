<?php
include 'db_conn.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    
    // Dashes remove kar rahe hain taake database mein saaf number save ho
    $phone = str_replace('-', '', $_POST['phone']); 
    $cnic = str_replace('-', '', $_POST['cnic']);
    
    $dob = $_POST['dob'];
    $password = $_POST['password'];

    // --- STEP 1: CHECK EMAIL ---
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $resultEmail = $conn->query($checkEmail);

    // --- STEP 2: CHECK CNIC ---
    $checkCNIC = "SELECT * FROM users WHERE cnic='$cnic'";
    $resultCNIC = $conn->query($checkCNIC);
    
    // --- DECISION LOGIC ---
    if ($resultEmail->num_rows > 0) {
        // ERROR IN ENGLISH
        $error = "This email is already registered! Please login.";
    } 
    elseif ($resultCNIC->num_rows > 0) {
        // ERROR IN ENGLISH
        $error = "This CNIC is already registered! Only one account allowed per CNIC.";
    } 
    else {
        // Agar Email aur CNIC dono naye hain, tab account banao
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (fullname, email, phone, cnic, dob, password) 
                VALUES ('$fullname', '$email', '$phone', '$cnic', '$dob', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            $success = "Registration Successful! Redirecting to Login Page...";
            echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 2000);</script>";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - VIP Portal</title>
  <link rel="stylesheet" href="auth_style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-header">
      <h2>Create Account</h2>
      <p>Start your data structures journey</p>
    </div>

    <?php if($error){ echo "<div class='msg php-error'>$error</div>"; } ?>
    <?php if($success){ echo "<div class='msg success'>$success</div>"; } ?>

    <form id="registerForm" method="POST" action="" novalidate>
      
      <div class="input-group">
        <label>Full Name</label>
        <div class="input-wrapper">
          <input type="text" id="fullname" name="fullname" placeholder="John Doe" />
          <i class="fa-solid fa-user"></i>
        </div>
        <div class="error-msg" id="nameError">Please enter your full name</div>
      </div>

      <div class="input-group">
        <label>Email Address</label>
        <div class="input-wrapper">
          <input type="email" id="email" name="email" placeholder="name@example.com" />
          <i class="fa-solid fa-envelope"></i>
        </div>
        <div class="error-msg" id="emailError">Please enter a valid email</div>
      </div>

      <div class="input-group">
        <label>Mobile Number</label>
        <div class="input-wrapper">
          <input type="text" id="phone" name="phone" placeholder="0300-1234567" maxlength="12" />
          <i class="fa-solid fa-phone"></i>
        </div>
        <div class="error-msg" id="phoneError">Enter valid number (03xx-xxxxxxx)</div>
      </div>

      <div class="input-group">
        <label>CNIC</label>
        <div class="input-wrapper">
          <input type="text" id="cnic" name="cnic" placeholder="12345-1234567-1" maxlength="15" />
          <i class="fa-solid fa-id-card"></i>
        </div>
        <div class="error-msg" id="cnicError">Enter valid CNIC (13 digits with dashes)</div>
      </div>

      <div class="input-group">
        <label>Date of Birth</label>
        <div class="input-wrapper">
          <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" />
          <i class="fa-solid fa-calendar"></i>
        </div>
        <div class="error-msg" id="dobError">Please select a valid Date of Birth</div>
      </div>

      <div class="input-group">
        <label>Password</label>
        <div class="input-wrapper">
            <input type="password" id="password" name="password" placeholder="Create a password" />
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="error-msg" id="passwordError">Password must be at least 8 characters</div>
      </div>

      <div class="input-group">
        <label>Confirm Password</label>
        <div class="input-wrapper">
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" />
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="error-msg" id="confirmError">Passwords do not match</div>
      </div>

      <button type="submit" class="btn-auth">Register Now</button>
    </form>

    <div class="auth-footer">
      Already have an account? <a href="index.php">Login here</a>
    </div>
  </div>

  <script>
    // --- GLOBAL TRACKING ---
    const fields = ['fullname', 'email', 'phone', 'cnic', 'dob', 'password', 'confirmPassword'];
    const dirty = {}; // Track if user has interacted with a field

    // --- UTILITY FUNCTIONS ---
    function showError(fieldId, message) {
      const input = document.getElementById(fieldId);
      const errorEl = document.getElementById(fieldId + 'Error');
      input.classList.add("error");
      if (errorEl) {
        errorEl.innerText = message;
        errorEl.style.display = "block";
      }
    }

    function hideError(fieldId) {
      const input = document.getElementById(fieldId);
      const errorEl = document.getElementById(fieldId + 'Error');
      input.classList.remove("error");
      if (errorEl) {
        errorEl.style.display = "none";
      }
    }

    // --- VALIDATION LOGIC ---
    function validate(fieldId) {
      const input = document.getElementById(fieldId);
      const value = input.value.trim();
      let isValid = true;
      let msg = "Wrong format";

      if (fieldId === 'fullname') {
        if (value === "") { isValid = false; msg = "Wrong format: Name cannot be empty"; }
      }
      else if (fieldId === 'email') {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(value)) { isValid = false; msg = "Wrong format: Invalid email"; }
      }
      else if (fieldId === 'phone') {
        if (value.length !== 12 || !value.startsWith("03")) { isValid = false; msg = "Wrong format: use 03xx-xxxxxxx"; }
      }
      else if (fieldId === 'cnic') {
        if (value.length !== 15) { isValid = false; msg = "Wrong format: use xxxxx-xxxxxxx-x"; }
      }
      else if (fieldId === 'dob') {
        if (value === "") {
          isValid = false;
          msg = "Wrong format: Select Date of Birth";
        } else {
          const birth = new Date(value);
          const now = new Date();
          let age = now.getFullYear() - birth.getFullYear();
          const m = now.getMonth() - birth.getMonth();
          if (m < 0 || (m === 0 && now.getDate() < birth.getDate())) {
            age--;
          }
          if (age < 18) {
            isValid = false;
            msg = "Wrong format: Age must be 18+";
          }
        }
      }
      else if (fieldId === 'password') {
        if (value.length < 8) { isValid = false; msg = "Wrong format: Min 8 chars"; }
        // Re-validate confirm password if it's already filled
        if (dirty['confirmPassword']) validate('confirmPassword');
      }
      else if (fieldId === 'confirmPassword') {
        const pass = document.getElementById('password').value;
        if (value === "" || value !== pass) { isValid = false; msg = "Wrong format: Passwords do not match"; }
      }

      // Show/Hide logic
      if (isValid) {
        hideError(fieldId);
      } else if (dirty[fieldId]) {
        showError(fieldId, msg);
      }

      return isValid;
    }

    // --- ATTACH LISTENERS ---
    fields.forEach(f => {
      const el = document.getElementById(f);
      
      // On Input
      el.addEventListener('input', () => {
        if (f !== 'phone' && f !== 'cnic') { // These are handled by specific formatters
           dirty[f] = true;
           validate(f);
        }
      });

      // On Blur (Always mark as dirty and validate)
      el.addEventListener('blur', () => {
        dirty[f] = true;
        validate(f);
      });
      
      // Fix for Date of Birth potentially needing 'change'
      if (f === 'dob') {
          el.addEventListener('change', () => {
              dirty[f] = true;
              validate(f);
          });
      }
    });

    // --- SPECIAL FORMATTERS ---
    document.getElementById('phone').addEventListener('input', (e) => {
      let val = e.target.value.replace(/\D/g, '');
      if (val.length > 4) val = val.slice(0, 4) + '-' + val.slice(4, 11);
      e.target.value = val;
      
      dirty['phone'] = true;
      validate('phone');
    });

    document.getElementById('cnic').addEventListener('input', (e) => {
      let val = e.target.value.replace(/\D/g, '');
      if (val.length > 5) val = val.slice(0, 5) + '-' + val.slice(5);
      if (val.length > 13) val = val.slice(0, 13) + '-' + val.slice(13, 14);
      e.target.value = val;
      
      dirty['cnic'] = true;
      validate('cnic');
    });

    // --- FORM SUBMIT ---
    document.getElementById('registerForm').addEventListener('submit', function(e) {
      let totalValid = true;
      fields.forEach(f => {
        dirty[f] = true; // Mark all as dirty on submit attempt
        if (!validate(f)) totalValid = false;
      });

      if (!totalValid) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
