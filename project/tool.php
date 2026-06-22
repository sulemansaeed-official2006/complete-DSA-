<?php
session_start();
// Database connection
include 'db_conn.php';

// Login Check
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

// Algorithm Select
$algo = isset($_GET['algo']) ? $_GET['algo'] : 'bubble';

// --- ULTIMATE DATA DICTIONARY (ENGLISH) ---
$data = [
    'bubble' => [
        'name' => 'Bubble Sort',
        'type' => 'sort',
        'desc' => 'A simple sorting algorithm that repeatedly steps through the list, compares adjacent elements, and swaps them if they are in the wrong order. This pass through the list is repeated until the list is sorted.',
        'complexity' => 'Time: O(n²) | Space: O(1)',
        'code' => 
"void bubbleSort(int arr[], int n) {
    for (int i = 0; i < n-1; i++) {
        for (int j = 0; j < n-i-1; j++) {
            // Compare adjacent elements
            if (arr[j] > arr[j+1]) {
                swap(arr[j], arr[j+1]);
            }
        }
    }
}",
        'pros' => ['Easy to understand and implement.', 'No extra memory required (In-place).', 'Stable sorting algorithm.'],
        'cons' => ['Very slow time complexity O(n²).', 'Inefficient for large datasets.'],
        'examples' => ['Sorting playing cards in your hand.', 'Teaching basic sorting concepts to students.', 'Computer graphics polygons sorting.'],
    ],
    'selection' => [
        'name' => 'Selection Sort',
        'type' => 'sort',
        'desc' => 'This algorithm sorts an array by repeatedly finding the minimum element from the unsorted part and putting it at the beginning of the list.',
        'complexity' => 'Time: O(n²) | Space: O(1)',
        'code' => 
"void selectionSort(int arr[], int n) {
    for (int i = 0; i < n-1; i++) {
        int min_idx = i;
        for (int j = i+1; j < n; j++) {
            if (arr[j] < arr[min_idx])
                min_idx = j;
        }
        // Swap found minimum with first element
        swap(arr[min_idx], arr[i]);
    }
}",
        'pros' => ['Performs well on small lists.', 'Minimizes the number of swaps.'],
        'cons' => ['Slow O(n²) time complexity.', 'Not a stable sort by default.'],
        'examples' => ['Sorting names in a phonebook.', 'Writing to memory is expensive (Flash memory).', 'Selecting the top scorers in a game.'],
    ],
    'insertion' => [
        'name' => 'Insertion Sort',
        'type' => 'sort',
        'desc' => 'Builds the final sorted array one item at a time. It is much less efficient on large lists than more advanced algorithms such as quicksort, heapsort, or merge sort.',
        'complexity' => 'Time: O(n²) | Space: O(1)',
        'code' => 
"void insertionSort(int arr[], int n) {
    for (int i = 1; i < n; i++) {
        int key = arr[i];
        int j = i - 1;
        // Move elements greater than key
        while (j >= 0 && arr[j] > key) {
            arr[j + 1] = arr[j];
            j = j - 1;
        }
        arr[j + 1] = key;
    }
}",
        'pros' => ['Extremely fast for already sorted data.', 'Stable and adaptive.', 'Low overhead.'],
        'cons' => ['Inefficient for large lists.', 'Requires shifting elements.'],
        'examples' => ['Arranging cards in a hand.', 'Sorting data as it is being received (Live Stream).', 'Small datasets.'],
    ],
    'linear' => [
        'name' => 'Linear Search',
        'type' => 'search',
        'desc' => 'A method for finding an element within a list. It sequentially checks each element of the list until a match is found or the whole list has been searched.',
        'complexity' => 'Time: O(n) | Space: O(1)',
        'code' => 
"int linearSearch(int arr[], int n, int x) {
    for (int i = 0; i < n; i++) {
        if (arr[i] == x)
            return i;
    }
    return -1;
}",
        'pros' => ['Simple to implement.', 'Works on unsorted arrays.', 'No preprocessing required.'],
        'cons' => ['Very slow for large datasets.', 'Time increases linearly with data size.'],
        'examples' => ['Finding a specific shirt in a pile.', 'Searching for a typo in a short text.', 'Checking a grocery list.'],
    ],
    'binary' => [
        'name' => 'Binary Search',
        'type' => 'search',
        'desc' => 'A search algorithm that finds the position of a target value within a sorted array. It compares the target value to the middle element of the array.',
        'complexity' => 'Time: O(log n) | Space: O(1)',
        'code' => 
"int binarySearch(int arr[], int l, int r, int x) {
    while (l <= r) {
        int m = l + (r - l) / 2;
        if (arr[m] == x) return m;
        if (arr[m] < x) l = m + 1;
        else r = m - 1;
    }
    return -1;
}",
        'pros' => ['Extremely fast O(log n).', 'Highly efficient for large datasets.'],
        'cons' => ['Array must be sorted first.', 'Implementation is trickier than linear search.'],
        'examples' => ['Looking up a word in a dictionary.', 'Database indexing.', 'Debugging via bisection method.'],
    ]
];

$current = $data[$algo];

// --- HISTORY SAVE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_history'])) {
    if(isset($conn) && $conn) {
        $uid = $_SESSION['user_id'];
        $inp = $_POST['input_str'];
        $out = $_POST['output_str'];
        $tool = $_POST['tool_name'];
        $stmt = $conn->prepare("INSERT INTO user_history (user_id, tool_name, input_values, output_result) VALUES (?, ?, ?, ?)");
        if($stmt) {
            $stmt->bind_param("isss", $uid, $tool, $inp, $out);
            $stmt->execute();
        }
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $current['name']; ?> - Ultimate Learning Tool</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4f46e5; --secondary: #8b5cf6; --accent: #06b6d4;
            --success: #10b981; --danger: #ef4444; --warning: #f59e0b;
            --dark: #0f172a; --glass: rgba(255, 255, 255, 0.95);
            --code-bg: #1e1e1e;
        }

        body { 
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at top left, #a78bfa, #3b82f6, #14b8a6);
            background-size: 200% 200%;
            animation: moveGradient 15s ease infinite;
            min-height: 100vh; color: var(--dark); margin: 0; padding-bottom: 60px;
        }
        @keyframes moveGradient { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }

        .hover-glow { position: relative; overflow: hidden; transition: transform 0.3s, box-shadow 0.3s; }
        .hover-glow:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

        .navbar { 
            background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(15px);
            height: 75px; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; 
            border-bottom: 1px solid rgba(255,255,255,0.5); position: sticky; top:0; z-index:100;
        }
        .brand { font-weight: 800; color: var(--primary); font-size: 24px; display: flex; gap: 10px; align-items: center; }
        .back-link { text-decoration: none; color: #475569; font-weight: 600; padding: 8px 16px; border-radius: 30px; background: #f1f5f9; transition:0.3s; }
        .back-link:hover { background: var(--primary); color:white; }

        .container { max-width: 1300px; margin: 40px auto; padding: 0 20px; animation: slideUp 0.8s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

        .card { 
            background: var(--glass); backdrop-filter: blur(20px);
            border-radius: 24px; padding: 40px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
            margin-bottom: 30px; border: 1px solid rgba(255,255,255,0.6);
        }
        .algo-title { font-size: 42px; font-weight: 800; color: var(--primary); margin: 0; }
        .badge { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 8px 18px; border-radius: 50px; font-weight: 700; }

        /* IDE BOX */
        .ide-box {
            background: var(--code-bg); border-radius: 12px; overflow: hidden;
            border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: flex; flex-direction: column; height: 100%; min-height: 300px;
        }
        .ide-header {
            background: #252526; padding: 10px 15px; border-bottom: 1px solid #333;
            color: #ccc; font-size: 13px; display: flex; gap: 8px; align-items: center;
        }
        .dot { width: 10px; height: 10px; border-radius: 50%; }
        .red { background: #ff5f56; } .yellow { background: #ffbd2e; } .green { background: #27c93f; }
        .code-content {
            padding: 15px; color: #d4d4d4; font-family: 'Fira Code', monospace; 
            font-size: 14px; line-height: 1.6; white-space: pre; overflow: auto;
        }

        /* EXAMPLE GRID */
        .example-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-top: 15px; }
        .ex-card {
            background: white; padding: 20px; border-radius: 15px; 
            border-left: 5px solid var(--accent); display: flex; align-items: center; gap: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); color: #334155; font-weight: 500; font-size: 16px;
        }

        /* VIZ STAGE */
        #viz-interface { display: none; }
        .viz-stage { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; min-height: 550px; }
        
        .canvas {
            background: white; border-radius: 20px; position: relative;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid #e2e8f0; padding:20px;
        }

        .control-bar {
            background: white; padding: 15px 30px; border-radius: 50px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-bottom: 25px;
        }
        .v-btn { 
            border: none; background: #f1f5f9; color: #475569; 
            padding: 12px 25px; border-radius: 30px; font-weight: 700; cursor: pointer; 
            font-size: 14px; display: flex; align-items: center; gap: 8px; transition: 0.2s;
        }
        .v-btn-start { background: var(--success); color: white; box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3); }
        .v-btn:disabled { opacity: 0.5; cursor: not-allowed; }

        .status-header { position: absolute; top: 20px; width: 100%; text-align: center; left: 0;}
        #statusText {
            font-size: 20px; font-weight: 700; color: #475569; 
            background: rgba(241, 245, 249, 0.95); padding: 8px 20px; border-radius: 30px;
            display: inline-block; border: 1px solid #e2e8f0;
        }
        .status-highlight { color: var(--danger) !important; border-color: var(--danger) !important; transform: scale(1.05); transition:0.3s; }

        .node-container { display: flex; align-items: flex-end; gap: 15px; height: 350px; padding-bottom: 60px; }
        
        .node { 
            width: 70px; height: 70px; 
            background: linear-gradient(145deg, #6366f1, #4f46e5);
            color: white; border-radius: 12px;
            display: flex; justify-content: center; align-items: center;
            font-size: 24px; font-weight: 700; position: relative;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
            transition: transform 0.4s, background 0.3s;
        }
        .node-idx { position: absolute; bottom: -35px; color: #94a3b8; font-size: 14px; font-family: 'Fira Code'; }
        
        .var-label {
            position: absolute; top: -50px; left: 50%; transform: translateX(-50%);
            background: var(--danger); color: white; padding: 4px 10px;
            border-radius: 6px; font-size: 14px; font-weight: 800; font-family: 'Fira Code';
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4);
            animation: bounce 0.6s infinite alternate; z-index: 50; white-space: nowrap;
        }
        .var-label::after {
            content: ''; position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%);
            border-width: 6px 6px 0; border-style: solid; border-color: var(--danger) transparent transparent transparent;
        }
        @keyframes bounce { from{top:-50px} to{top:-58px} }

        .node.compare { background: linear-gradient(145deg, #f59e0b, #d97706) !important; transform: scale(1.15); border: 3px solid white; z-index: 10; }
        .node.swap { background: linear-gradient(145deg, #ef4444, #dc2626) !important; transform: translateY(-40px); }
        .node.sorted { background: linear-gradient(145deg, #10b981, #059669) !important; opacity: 1; border: 2px solid #a7f3d0; }
        .node.found { background: #22c55e !important; transform: scale(1.3); border: 4px solid white; z-index: 20; box-shadow: 0 0 30px #22c55e; }
        .node.dim { opacity: 0.15; filter: grayscale(100%); }

        .sorted-tray {
            background: #f0fdf4; border: 2px dashed #86efac; border-radius: 12px;
            padding: 15px; margin-top: 20px; text-align: left; width: 90%;
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap; min-height: 60px;
        }
        .tray-label { font-weight: 700; color: #15803d; margin-right: 10px; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; }
        .tray-item {
            background: #15803d; color: white; padding: 5px 12px; border-radius: 6px;
            font-weight: 700; font-size: 14px; animation: popIn 0.3s ease;
        }
        @keyframes popIn { from{transform:scale(0)} to{transform:scale(1)} }

        .btn-xl { 
            width: 100%; background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white; padding: 20px; border: none; border-radius: 16px;
            font-size: 20px; font-weight: 700; cursor: pointer; margin-top: 30px;
        }
        
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; margin-top: 25px; }
        .info-box { padding: 25px; border-radius: 16px; background: white; }
        
        @media(max-width: 1024px) { 
            .viz-stage { grid-template-columns: 1fr; } 
            .ide-box { height: 250px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="brand"><i class="fa-solid fa-layer-group"></i> Ultimate DSA</div>
    <a href="dashboard.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Dashboard</a>
</nav>

<div class="container">

    <div id="theory-view">
        <div class="card hover-glow">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <h1 class="algo-title"><?php echo $current['name']; ?></h1>
                <span class="badge"><i class="fa-regular fa-clock"></i> <?php echo $current['complexity']; ?></span>
            </div>
            <p style="margin-top:20px; font-size:18px; line-height:1.8; color:#475569;">
                <?php echo $current['desc']; ?>
            </p>
            
            <h3 style="margin-top:30px; color:var(--dark);">Algorithm Code</h3>
            <div class="ide-box">
                <div class="ide-header">
                    <div class="dot red"></div><div class="dot yellow"></div><div class="dot green"></div>
                    <span style="margin-left:10px; color:#aaa;">main.cpp</span>
                </div>
                <div class="code-content"><?php echo htmlspecialchars($current['code']); ?></div>
            </div>
        </div>

        <div class="grid-2">
            <div class="info-box hover-glow" style="background:#dcfce7; color:#14532d;">
                <h4><i class="fa-solid fa-thumbs-up"></i> Advantages</h4>
                <ul><?php foreach($current['pros'] as $p) echo "<li>$p</li>"; ?></ul>
            </div>
            <div class="info-box hover-glow" style="background:#fee2e2; color:#7f1d1d;">
                <h4><i class="fa-solid fa-thumbs-down"></i> Disadvantages</h4>
                <ul><?php foreach($current['cons'] as $c) echo "<li>$c</li>"; ?></ul>
            </div>
        </div>
        
        <div class="card hover-glow" style="margin-top:30px;">
            <h3><i class="fa-solid fa-earth-americas" style="color:var(--accent)"></i> Real World Examples</h3>
            <div class="example-grid">
                <?php foreach($current['examples'] as $ex): ?>
                    <div class="ex-card hover-glow">
                        <i class="fa-solid fa-check" style="color:var(--success)"></i> 
                        <?php echo $ex; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <button onclick="switchMode('viz')" class="btn-xl hover-glow">
            <i class="fa-solid fa-play-circle"></i> Start Visualizing
        </button>
    </div>

    <div id="viz-interface">
        
        <div id="setup-panel" class="card hover-glow" style="text-align:center;">
            <h2 style="color:var(--primary);">Configure Data</h2>
            <div style="background:#f1f5f9; padding:30px; border-radius:20px; margin-top:20px; display:inline-block; min-width:50%;">
                <div style="margin-bottom:20px;">
                    <span style="font-weight:700;">Size:</span>
                    <input type="range" id="arrSize" min="3" max="7" value="5" oninput="updateSizeUI(this.value)" style="accent-color:var(--primary);">
                    <span id="sizeDisplay" style="font-weight:800; color:var(--primary);">5</span>
                </div>

                <div id="dynamicInputs" style="display:flex; justify-content:center; gap:10px; margin-bottom:20px;"></div>

                <?php if($current['type'] == 'search'): ?>
                    <div>
                        <label style="font-weight:700; color:var(--success);">Search Target:</label>
                        <input type="number" id="targetVal" value="42" style="padding:8px; width:60px; text-align:center; border-radius:8px; border:2px solid var(--success); font-weight:bold;">
                    </div>
                <?php elseif($current['type'] == 'sort'): ?>
                     <div style="color:var(--success); font-weight:700; margin-bottom:10px;">
                        <i class="fa-solid fa-arrow-down-short-wide"></i> Sort Data
                    </div>
                <?php endif; ?>

                <button onclick="initViz()" class="btn-xl hover-glow" style="padding:15px; font-size:16px; margin-top:20px;">
                    Generate & Run <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <div id="stage-panel" style="display:none;">
            <div class="control-bar hover-glow">
                <div style="display:flex; gap:15px; align-items:center;">
                    <button class="v-btn hover-glow" onclick="location.reload()"><i class="fa-solid fa-arrow-left"></i> Back</button>
                    <div>
                        <span style="font-size:12px; font-weight:700; color:#64748b;">SPEED</span>
                        <input type="range" id="speedRange" min="100" max="2000" value="1000" style="accent-color:var(--secondary);">
                    </div>
                </div>
                <div style="display:flex; gap:10px;">
                    <button class="v-btn v-btn-start hover-glow" id="startBtn" onclick="beginAnimation()"><i class="fa-solid fa-play"></i> Start</button>
                    <button class="v-btn hover-glow" id="playPauseBtn" onclick="togglePause()" disabled><i class="fa-solid fa-pause"></i> Pause</button>
                    <button class="v-btn hover-glow" onclick="resetViz()"><i class="fa-solid fa-rotate-right"></i> Reset</button>
                </div>
            </div>

            <div class="viz-stage">
                <div class="canvas hover-glow">
                    <div class="status-header"><span id="statusText">Ready...</span></div>
                    
                    <div class="node-container" id="nodeCanvas"></div>
                    
                    <div class="sorted-tray" id="sortedTray">
                        <span class="tray-label"><i class="fa-solid fa-check-double"></i> Sorted:</span>
                    </div>

                    <div id="resultMsg" style="display:none; font-size:24px; font-weight:800; color:var(--success); margin-top:15px;">Complete!</div>
                    
                    <div style="margin-top:auto; width:100%; display:flex; justify-content:space-between; color:#64748b; font-weight:600; font-size:14px;">
                        <span>Comparisons: <span id="statComp" style="color:var(--dark)">0</span></span>
                        <span>Swaps: <span id="statSwap" style="color:var(--dark)">0</span></span>
                    </div>
                </div>
                
                <div class="ide-box hover-glow">
                    <div class="ide-header">
                        <div class="dot red"></div><div class="dot yellow"></div><div class="dot green"></div>
                        <span style="margin-left:10px; color:#aaa;">Logic View</span>
                    </div>
                    <div class="code-content"><?php echo htmlspecialchars($current['code']); ?></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const algoType = "<?php echo $algo; ?>";
    let dataset = [];
    let isPaused = false;
    let isRunning = false;
    let stats = { comp: 0, swaps: 0 };
    
    window.onload = function() { updateSizeUI(5); }

    function switchMode(mode) {
        if(mode === 'viz') {
            document.getElementById('theory-view').style.display = 'none';
            document.getElementById('viz-interface').style.display = 'block';
        }
    }

    // Auto-switch to Viz if param is present
    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('view') === 'sim') {
        setTimeout(() => switchMode('viz'), 100);
    }

    function updateSizeUI(val) {
        document.getElementById('sizeDisplay').innerText = val;
        genInputs(val);
    }

    function genInputs(n) {
        const div = document.getElementById('dynamicInputs');
        div.innerHTML = '';
        for(let i=0; i<n; i++) {
            let rnd = Math.floor(Math.random() * 99) + 1;
            div.innerHTML += `<input type="number" class="arr-input hover-glow" value="${rnd}" style="width:55px; height:55px; text-align:center; border:2px solid #e2e8f0; border-radius:12px; font-weight:700; font-size:18px;">`;
        }
    }

    function initViz() {
        dataset = [];
        document.querySelectorAll('.arr-input').forEach(inp => dataset.push(parseInt(inp.value)));
        
        document.getElementById('setup-panel').style.display = 'none';
        document.getElementById('stage-panel').style.display = 'block';
        document.getElementById('sortedTray').innerHTML = '<span class="tray-label"><i class="fa-solid fa-check-double"></i> Sorted:</span>';
        
        let inpStr = dataset.join(", ");
        if(document.getElementById('targetVal')) inpStr += " [Find: "+document.getElementById('targetVal').value+"]";
        const fd = new FormData();
        fd.append('save_history', '1');
        fd.append('tool_name', '<?php echo $current['name']; ?>');
        fd.append('input_str', inpStr);
        fd.append('output_str', 'Viz Run');
        fetch('tool.php', { method:'POST', body:fd });

        renderNodes();
        setStatus("Click 'Start' to begin");
    }

    function beginAnimation() {
        if(isRunning) return;
        isRunning = true;
        document.getElementById('startBtn').disabled = true;
        document.getElementById('startBtn').style.opacity = '0.5';
        document.getElementById('playPauseBtn').disabled = false;
        startAlgorithm();
    }

    function renderNodes(indices=[], type='', labels={}) {
        const canvas = document.getElementById('nodeCanvas');
        canvas.innerHTML = '';
        dataset.forEach((val, i) => {
            let cls = 'node';
            if(indices.includes(i)) cls += ' ' + type;
            let labelHtml = labels[i] ? `<div class="var-label">${labels[i]}</div>` : '';
            canvas.innerHTML += `
                <div class="${cls}" id="node-${i}">
                    ${labelHtml}
                    ${val}
                    <div class="node-idx">${i}</div>
                </div>
            `;
        });
    }

    function addToSortedTray(val) {
        const tray = document.getElementById('sortedTray');
        const span = document.createElement('span');
        span.className = 'tray-item';
        span.innerText = val;
        tray.appendChild(span);
    }

    const delay = () => new Promise(r => setTimeout(r, document.getElementById('speedRange').value));
    async function pauseCheck() { while(isPaused) await new Promise(r => setTimeout(r, 100)); }
    
    function togglePause() { 
        isPaused = !isPaused; 
        document.getElementById('playPauseBtn').innerHTML = isPaused ? '<i class="fa-solid fa-play"></i> Resume' : '<i class="fa-solid fa-pause"></i> Pause';
    }
    
    function setStatus(txt, highlight=false) { 
        const el = document.getElementById('statusText');
        el.innerText = txt;
        if(highlight) el.classList.add('status-highlight'); else el.classList.remove('status-highlight');
    }
    
    function updateStatsUI() { document.getElementById('statComp').innerText = stats.comp; document.getElementById('statSwap').innerText = stats.swaps; }
    
    function markSorted(indices) { 
        indices.forEach(i => { 
            const el = document.getElementById(`node-${i}`);
            if(el && !el.classList.contains('sorted')) {
                el.classList.add('sorted');
                addToSortedTray(dataset[i]);
            }
        }); 
    }
    
    function resetViz() { location.reload(); }

    async function startAlgorithm() {
        stats = { comp:0, swaps:0 };
        const n = dataset.length;
        let target = document.getElementById('targetVal') ? parseInt(document.getElementById('targetVal').value) : 0;

        if(algoType === 'bubble') {
            for(let i=0; i<n-1; i++) {
                for(let j=0; j<n-i-1; j++) {
                    await pauseCheck();
                    renderNodes([j, j+1], 'compare', { [j]: 'j', [j+1]: 'j+1' });
                    setStatus(`Comparing ${dataset[j]} > ${dataset[j+1]}`);
                    stats.comp++; updateStatsUI();
                    await delay();

                    if(dataset[j] > dataset[j+1]) {
                        setStatus(`Swapping...`, true);
                        let temp = dataset[j]; dataset[j] = dataset[j+1]; dataset[j+1] = temp;
                        renderNodes([j, j+1], 'swap', { [j]: 'j', [j+1]: 'j+1' });
                        stats.swaps++; updateStatsUI();
                        await delay();
                    }
                }
                markSorted([n-1-i]);
            }
            markSorted([0]); 
            renderNodes([], 'sorted');
        }
        
        else if(algoType === 'selection') {
            for(let i=0; i<n-1; i++) {
                let min_idx = i;
                for(let j=i+1; j<n; j++) {
                    await pauseCheck();
                    renderNodes([min_idx, j], 'compare', { [min_idx]: 'min', [j]: 'j' });
                    setStatus(`Checking: Is ${dataset[j]} < ${dataset[min_idx]}?`);
                    stats.comp++; updateStatsUI();
                    await delay();
                    
                    if(dataset[j] < dataset[min_idx]) {
                        min_idx = j;
                        setStatus(`New Minimum: ${dataset[min_idx]}`);
                    }
                }
                if(min_idx !== i) {
                    setStatus(`Swapping Min to Start`, true);
                    renderNodes([i, min_idx], 'swap', { [min_idx]: 'min', [i]: 'i' });
                    let temp = dataset[min_idx]; dataset[min_idx] = dataset[i]; dataset[i] = temp;
                    stats.swaps++; updateStatsUI();
                    await delay();
                }
                markSorted([i]);
            }
            markSorted([n-1]);
            renderNodes([], 'sorted');
        }

        else if(algoType === 'insertion') {
            renderNodes();
            markSorted([0]);
            await delay();

            for(let i=1; i<n; i++) {
                let key = dataset[i];
                let j = i-1;
                while(j >= 0 && dataset[j] > key) {
                    await pauseCheck();
                    stats.comp++; updateStatsUI();
                    renderNodes([j, j+1], 'compare', { [j]: 'j', [j+1]: 'Key' });
                    setStatus(`${dataset[j]} > ${key} : Shifting`, true);
                    await delay();

                    dataset[j+1] = dataset[j];
                    renderNodes([j+1], 'swap', { [j+1]: 'shift' });
                    stats.swaps++; updateStatsUI();
                    j--;
                    await delay();
                    
                    renderNodes();
                    for(let k=0; k<=i; k++) document.getElementById(`node-${k}`).classList.add('sorted');
                }
                dataset[j+1] = key;
                renderNodes();
                for(let k=0; k<=i; k++) document.getElementById(`node-${k}`).classList.add('sorted');
                await delay();
            }
            document.getElementById('sortedTray').innerHTML = '<span class="tray-label"><i class="fa-solid fa-check-double"></i> Sorted:</span>';
            dataset.forEach(val => addToSortedTray(val));
            renderNodes([], 'sorted');
        }

        else if(algoType === 'linear') {
            let found = false;
            for(let i=0; i<n; i++) {
                await pauseCheck();
                renderNodes([i], 'compare', { [i]: 'i' });
                setStatus(`Checking index ${i}: ${dataset[i]}`);
                stats.comp++; updateStatsUI();
                await delay();

                if(dataset[i] === target) {
                    renderNodes([i], 'found', { [i]: 'Found!' });
                    setStatus(`Found ${target} at index ${i}!`, true);
                    found = true;
                    break;
                }
            }
            if(!found) {
                setStatus("Not Found", true);
                document.querySelectorAll('.node').forEach(n => n.classList.add('dim'));
            }
        }

        else if(algoType === 'binary') {
            dataset.sort((a,b) => a-b);
            renderNodes();
            await delay();
            let l = 0, r = n-1;
            let found = false;
            while(l <= r) {
                await pauseCheck();
                let mid = Math.floor((l+r)/2);
                renderNodes();
                for(let k=0; k<n; k++) if(k < l || k > r) document.getElementById(`node-${k}`).classList.add('dim');
                document.getElementById(`node-${mid}`).classList.add('compare');
                renderNodes([mid], 'compare', { [l]: 'L', [r]: 'R', [mid]: 'Mid' });
                setStatus(`Mid: ${dataset[mid]} vs Target: ${target}`);
                stats.comp++; updateStatsUI();
                await delay();

                if(dataset[mid] === target) {
                    renderNodes([mid], 'found', { [mid]: 'Found!' });
                    setStatus("Found!", true);
                    found = true;
                    break;
                }
                if(dataset[mid] < target) l = mid + 1; else r = mid - 1;
            }
            if(!found) setStatus("Not Found", true);
        }

        if(algoType !== 'linear' && algoType !== 'binary') {
            document.getElementById('resultMsg').style.display = 'block';
        }
    }
</script>
</body>
</html>