<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selection Sort Simulation - Ultimate DSA</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sim-container { max-width: 1400px; margin: 0 auto; padding: 2rem; }
        
        .viz-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 400px;
        }

        .bar-container {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: 12px;
            height: 300px;
            width: 100%;
            padding-bottom: 40px;
        }

        .bar {
            width: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            padding-bottom: 10px;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .bar-idx {
            position: absolute;
            bottom: -30px;
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-family: 'Fira Code', monospace;
        }

        .bar.compare { background: linear-gradient(135deg, var(--info-color), #2563eb); }
        .bar.min { background: linear-gradient(135deg, var(--warning-color), #d97706); transform: scale(1.1); z-index: 10; border: 2px solid white; }
        .bar.swap { background: linear-gradient(135deg, var(--danger-color), #dc2626); }
        .bar.sorted { background: linear-gradient(135deg, var(--success-color), #059669); }

        .controls-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        
        .panel {
            background: var(--card-bg);
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid var(--border-color);
        }

        .panel h3 { color: var(--accent-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
        .control-group { margin-bottom: 1.5rem; }
        .control-group label { display: block; color: var(--text-secondary); margin-bottom: 0.5rem; font-size: 0.9rem; }
        input[type=range] { width: 100%; accent-color: var(--primary-color); }

        .stats-box {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1rem;
            padding: 1rem; background: rgba(0,0,0,0.2); border-radius: 12px;
        }
        .stat-item { text-align: center; }
        .stat-val { display: block; font-size: 1.5rem; font-weight: 700; color: var(--text-primary); }
        .stat-label { font-size: 0.8rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px; }

    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
            <a href="selection_sort.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-check-double"></i> Selection Sort
            </div>
        </div>

        <header class="header">
            <h1>Visualization Playground</h1>
            <p class="subtitle">Hunt for the minimum and place it right!</p>
        </header>

        <div class="viz-section">
            <div class="bar-container" id="barContainer"></div>
            <div id="statusText" style="margin-top: 20px; font-size: 1.2rem; color: var(--text-primary); font-weight: 500; min-height: 1.5em;">Ready to sort...</div>
        </div>

        <div class="controls-grid">
            <div class="panel">
                <h3><i class="fa-solid fa-sliders"></i> Controls</h3>
                
                <div class="control-group">
                    <label>Array Size: <span id="sizeVal" style="color:var(--primary-color); font-weight:bold;">5</span></label>
                    <input type="range" id="arrSize" min="3" max="15" value="5" oninput="generateArray(this.value)">
                </div>

                <div class="control-group">
                    <label>Speed (ms): <span id="speedVal" style="color:var(--primary-color); font-weight:bold;">800</span></label>
                    <input type="range" id="speedRange" min="100" max="2000" value="800" oninput="document.getElementById('speedVal').innerText=this.value">
                </div>

                <div class="control-group">
                    <label>Custom Data (Max 15):</label>
                    <div style="display:flex; gap:5px;">
                        <input type="text" id="customInput" placeholder="e.g. 50, 10, 30" class="value-input" style="width:100%; border:1px solid var(--border-color); padding:8px; border-radius:8px;">
                        <button class="btn" style="background:var(--secondary-color); color:white; padding:0 15px;" onclick="loadCustomData()">Load</button>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:20px;">
                    <button class="btn btn-primary" onclick="generateArray(document.getElementById('arrSize').value)">
                        <i class="fa-solid fa-rotate-right"></i> Random
                    </button>
                    <button class="btn btn-danger" onclick="reset()">
                        <i class="fa-solid fa-trash"></i> Reset
                    </button>
                </div>

                <button id="startBtn" class="btn btn-success" style="width:100%; font-size:1.1rem; padding:1rem;" onclick="startSort()">
                    <i class="fa-solid fa-play"></i> Start Selection Sort
                </button>

                <div class="stats-box">
                    <div class="stat-item">
                        <span class="stat-val" id="compCount">0</span>
                        <span class="stat-label">Comparisons</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-val" id="swapCount">0</span>
                        <span class="stat-label">Swaps</span>
                    </div>
                </div>
            </div>

            <div class="panel">
                <h3><i class="fa-solid fa-code"></i> Algorithm</h3>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">selection_sort.cpp</span>
                    </div>
                    <div class="code-content" style="display:block; max-height: 250px; overflow-y:auto;">
<pre><code class="cpp">void selectionSort(int arr[], int n) {
    for (int i = 0; i < n-1; i++) {
        int min_idx = i;
        for (int j = i+1; j < n; j++) {
            if (arr[j] < arr[min_idx])
                min_idx = j;
        }
        swap(arr[min_idx], arr[i]);
    }
}</code></pre>
                    </div>
                </div>
                <div class="operation-log" id="logBox" style="height: 150px;">
                    <div class="log-entry log-info">[System] Ready to initialize...</div>
                </div>
            </div>
        </div>
    </div>

<script>
    let data = [];
    let isSorting = false;
    let comparisons = 0;
    let swaps = 0;
    let abort = false;

    window.onload = () => generateArray(5);

    function loadCustomData() {
        if(isSorting) return;
        const input = document.getElementById('customInput').value;
        if(!input) { log("Please enter some numbers!", "error"); return; }
        
        const arr = input.split(/[, ]+/).map(n => parseInt(n.trim())).filter(n => !isNaN(n));
        
        if(arr.length < 3 || arr.length > 15) {
            log("Please enter between 3 and 15 numbers.", "error");
            return;
        }
        
        document.getElementById('sizeVal').innerText = arr.length;
        document.getElementById('arrSize').value = arr.length;
        
        const container = document.getElementById('barContainer');
        container.innerHTML = '';
        data = arr;
        
        const maxVal = Math.max(...data);
        const scaleFactor = 280 / maxVal;
        
        data.forEach((val, i) => {
            const bar = document.createElement('div');
            bar.className = 'bar';
            bar.style.height = `${Math.max(val * scaleFactor, 30)}px`;
            bar.innerText = val;
            bar.id = `bar-${i}`;
            const idx = document.createElement('div');
            idx.className = 'bar-idx';
            idx.innerText = i;
            bar.appendChild(idx);
            
            bar.innerHTML += `
               <div id="lbl-i-${i}" class="pointer-label lbl-i" style="display:none;">i</div>
               <div id="lbl-j-${i}" class="pointer-label lbl-j" style="display:none;">j</div>
               <div id="lbl-min-${i}" class="pointer-label lbl-min" style="display:none;">min</div>
            `;
            
            container.appendChild(bar);
        });
        
        resetStats();
        log("Custom data loaded.", "success");
        document.getElementById('statusText').innerText = "Ready to sort...";
    }

    function generateArray(size) {
        if(isSorting) return;
        document.getElementById('sizeVal').innerText = size;
        document.getElementById('customInput').value = '';
        const container = document.getElementById('barContainer');
        container.innerHTML = '';
        data = [];
        for(let i=0; i<size; i++) {
            const val = Math.floor(Math.random() * 90) + 10;
            data.push(val);
            const bar = document.createElement('div');
            bar.className = 'bar';
            bar.style.height = `${val * 3}px`;
            bar.innerText = val;
            bar.id = `bar-${i}`;
            const idx = document.createElement('div');
            idx.className = 'bar-idx';
            idx.innerText = i;
            bar.appendChild(idx);
            
            bar.innerHTML += `
               <div id="lbl-i-${i}" class="pointer-label lbl-i" style="display:none;">i</div>
               <div id="lbl-j-${i}" class="pointer-label lbl-j" style="display:none;">j</div>
               <div id="lbl-min-${i}" class="pointer-label lbl-min" style="display:none;">min</div>
            `;
            
            container.appendChild(bar);
        }
        resetStats();
        log("New array generated.", "info");
        document.getElementById('statusText').innerText = "Ready to sort...";
    }

    function resetStats() {
        comparisons = 0; swaps = 0;
        document.getElementById('compCount').innerText = '0';
        document.getElementById('swapCount').innerText = '0';
    }

    function reset() {
        if(isSorting) {
            abort = true; isSorting = false;
            setTimeout(() => { abort = false; generateArray(document.getElementById('arrSize').value); document.getElementById('startBtn').disabled = false; }, 500);
        } else {
            generateArray(document.getElementById('arrSize').value);
        }
    }

    function log(msg, type='info') {
        const box = document.getElementById('logBox');
        box.innerHTML += `<div class="log-entry log-${type}">[${new Date().toLocaleTimeString()}] ${msg}</div>`;
        box.scrollTop = box.scrollHeight;
    }

    const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

    function clearPointers() {
        document.querySelectorAll('.pointer-label').forEach(el => el.style.display = 'none');
    }

    function showPointers(i, j, min) {
        clearPointers();
        if(i !== null && i < data.length) document.getElementById(`lbl-i-${i}`).style.display = 'block';
        if(j !== null && j < data.length) document.getElementById(`lbl-j-${j}`).style.display = 'block';
        if(min !== null && min < data.length) document.getElementById(`lbl-min-${min}`).style.display = 'block';
    }

    async function startSort() {
        if(isSorting) return;
        isSorting = true; abort = false;
        document.getElementById('startBtn').disabled = true;
        log("Sorting started...", "info");
        resetStats();
        const n = data.length;

        for(let i=0; i < n-1; i++) {
            if(abort) break;
            
            let min_idx = i;
            document.getElementById(`bar-${i}`).classList.add('min'); 
            document.getElementById('statusText').innerText = `Current Minimum at index [${i}]`;
            
            showPointers(i, null, min_idx); // Show i and min
            await delay(document.getElementById('speedRange').value);
            
            for(let j=i+1; j < n; j++) {
                if(abort) break;
                
                showPointers(i, j, min_idx); // Show i, j, min
                
                document.getElementById(`bar-${j}`).classList.add('compare');
                comparisons++;
                document.getElementById('compCount').innerText = comparisons;
                await delay(document.getElementById('speedRange').value);

                if(data[j] < data[min_idx]) {
                    document.getElementById(`bar-${min_idx}`).classList.remove('min');
                    min_idx = j;
                    document.getElementById(`bar-${min_idx}`).classList.add('min');
                    log(`New minimum found: ${data[min_idx]} at index [${min_idx}]`, 'info');
                    document.getElementById('statusText').innerText = `New Min: ${data[min_idx]}`;
                    
                    showPointers(i, j, min_idx); // Update min visual
                    await delay(document.getElementById('speedRange').value);
                }
                
                document.getElementById(`bar-${j}`).classList.remove('compare');
            }

            // Swap
            if(min_idx !== i) {
                document.getElementById(`bar-${i}`).classList.add('swap');
                document.getElementById(`bar-${min_idx}`).classList.add('swap');
                document.getElementById('statusText').innerText = `Swapping ${data[i]} and ${data[min_idx]}`;
                showPointers(i, null, min_idx); // Focus on swap targets
                
                let tempH = document.getElementById(`bar-${i}`).style.height;
                let tempT = document.getElementById(`bar-${i}`).firstChild.nodeValue;
                
                document.getElementById(`bar-${i}`).style.height = document.getElementById(`bar-${min_idx}`).style.height;
                document.getElementById(`bar-${i}`).firstChild.nodeValue = document.getElementById(`bar-${min_idx}`).firstChild.nodeValue;
                
                document.getElementById(`bar-${min_idx}`).style.height = tempH;
                document.getElementById(`bar-${min_idx}`).firstChild.nodeValue = tempT;

                let temp = data[i]; data[i] = data[min_idx]; data[min_idx] = temp;
                swaps++;
                document.getElementById('swapCount').innerText = swaps;
                log(`Swapped ${data[i]} and ${data[min_idx]}`, 'warning');
                await delay(document.getElementById('speedRange').value);
                
                document.getElementById(`bar-${i}`).classList.remove('swap');
                document.getElementById(`bar-${min_idx}`).classList.remove('swap');
            }
            
            document.getElementById(`bar-${min_idx}`).classList.remove('min'); 
            document.getElementById(`bar-${i}`).classList.add('sorted');
        }
        
        clearPointers();
        if(!abort) {
            document.getElementById(`bar-${n-1}`).classList.add('sorted');
            log("Array completely sorted!", "success");
            document.getElementById('statusText').innerText = "Sorting Complete!";
        }
        isSorting = false;
        document.getElementById('startBtn').disabled = false;
    }
</script>
</body>
</html>
