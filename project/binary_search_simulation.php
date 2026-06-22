<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Search Simulation - Ultimate DSA</title>
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
            justify-content: center;
            min-height: 350px;
        }

        .array-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
            margin-bottom: 40px;
        }

        .box {
            width: 60px;
            height: 60px;
            background: var(--dark-bg);
            border: 2px solid var(--primary-color);
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            position: relative;
            transition: all 0.3s ease;
        }

        .box-idx {
            position: absolute;
            bottom: -25px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-family: 'Fira Code', monospace;
        }

        .pointer-label {
            position: absolute;
            top: -35px;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 4px;
            color: white;
            z-index: 10;
        }

        .lbl-l { background: var(--secondary-color); left: -10px; }
        .lbl-r { background: var(--secondary-color); right: -10px; }
        .lbl-m { background: var(--accent-color); left: 50%; transform: translateX(-50%); top: -50px; }

        .box.mid { background: var(--warning-color); border-color: #f59e0b; color: black; transform: scale(1.15); z-index: 5; }
        .box.found { background: var(--success-color); border-color: #10b981; box-shadow: 0 0 20px rgba(16, 185, 129, 0.5); transform: scale(1.15); z-index: 10; }
        .box.dim { opacity: 0.2; filter: blur(1px); }

        .search-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            width: 100%;
            justify-content: center;
        }

        .controls-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .panel { background: var(--card-bg); padding: 2rem; border-radius: 20px; border: 1px solid var(--border-color); }
        .panel h3 { color: var(--accent-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
        .control-group { margin-bottom: 1.5rem; }
        .control-group label { display: block; color: var(--text-secondary); margin-bottom: 0.5rem; font-size: 0.9rem; }
        input[type=range] { width: 100%; accent-color: var(--primary-color); }
    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
            <a href="binary_search.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-magnifying-glass-chart"></i> Binary Search
            </div>
        </div>

        <header class="header">
            <h1>Visualization Playground</h1>
            <p class="subtitle">Divide and Conquer: Finding targets fast!</p>
        </header>

        <div class="viz-section">
            <div class="search-controls">
                <input type="number" id="targetInput" placeholder="Target" class="value-input" style="width: 100px; text-align: center;">
                <button class="btn btn-primary" onclick="generateArray()">New Sorted Data</button>
            </div>
            
            <div class="array-container" id="arrayContainer"></div>
            
            <div id="statusText" style="margin-top: 10px; font-size: 1.4rem; color: var(--text-primary); font-weight: 500; min-height: 1.5em; text-align:center;">
                Ready to search...
            </div>
        </div>

        <div class="controls-grid">
            <div class="panel">
                <h3><i class="fa-solid fa-sliders"></i> Controls</h3>
                
                <div class="control-group">
                    <label>Custom Data (Will be Sorted):</label>
                    <div style="display:flex; gap:5px;">
                        <input type="text" id="customInput" placeholder="e.g. 50, 10, 30" class="value-input" style="width:100%; border:1px solid var(--border-color); padding:8px; border-radius:8px;">
                        <button class="btn" style="background:var(--secondary-color); color:white; padding:0 15px;" onclick="loadCustomData()">Load</button>
                    </div>
                </div>

                <div class="control-group">
                    <label>Array Size: <span id="sizeVal" style="color:var(--primary-color); font-weight:bold;">10</span></label>
                    <input type="range" id="arrSize" min="5" max="20" value="10" oninput="generateArray(this.value)">
                </div>

                <div class="control-group">
                    <label>Speed (ms): <span id="speedVal" style="color:var(--primary-color); font-weight:bold;">1000</span></label>
                    <input type="range" id="speedRange" min="200" max="3000" value="1000" oninput="document.getElementById('speedVal').innerText=this.value">
                </div>

                <button id="startBtn" class="btn btn-success" style="width:100%; font-size:1.1rem; padding:1rem;" onclick="startSearch()">
                    <i class="fa-solid fa-play"></i> Start Binary Search
                </button>
            </div>

            <div class="panel">
                <h3><i class="fa-solid fa-code"></i> Algorithm</h3>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">binary_search.cpp</span>
                    </div>
                    <div class="code-content" style="display:block;">
<pre><code class="cpp">int binarySearch(int arr[], int l, int r, int x) {
    while (l <= r) {
        int mid = l + (r - l) / 2;
        if (arr[mid] == x) return mid;
        if (arr[mid] < x) l = mid + 1;
        else r = mid - 1;
    }
    return -1;
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
    let isSearching = false;
    let abort = false;

    window.onload = () => generateArray(10);

    function loadCustomData() {
        if(isSearching) return;
        const input = document.getElementById('customInput').value;
        if(!input) { log("Please enter some numbers!", "error"); return; }
        
        let arr = input.split(',').map(n => parseInt(n.trim())).filter(n => !isNaN(n));
        
        if(arr.length < 5 || arr.length > 20) {
            log("Please enter between 5 and 20 numbers.", "error");
            return;
        }
        
        // Auto sort for binary search
        arr.sort((a,b) => a - b);
        
        document.getElementById('sizeVal').innerText = arr.length;
        document.getElementById('arrSize').value = arr.length;
        
        const container = document.getElementById('arrayContainer');
        container.innerHTML = '';
        data = arr;
        
        data.forEach((val, i) => {
            const box = document.createElement('div');
            box.className = 'box';
            box.innerText = val;
            box.id = `box-${i}`;
            const idx = document.createElement('div');
            idx.className = 'box-idx';
            idx.innerText = i;
            box.appendChild(idx);
            
            box.innerHTML += `
                <div id="lbl-l-${i}" class="pointer-label lbl-l" style="display:none;">L</div>
                <div id="lbl-m-${i}" class="pointer-label lbl-m" style="display:none;">M</div>
                <div id="lbl-r-${i}" class="pointer-label lbl-r" style="display:none;">R</div>
            `;
            
            container.appendChild(box);
        });
        
        log("Custom data loaded (Sorted).", "success");
        document.getElementById('statusText').innerText = "Ready to search...";
        document.getElementById('targetInput').value = data[Math.floor(data.length / 2)];
    }

    function generateArray(size = 10) {
        if(isSearching) return;
        size = document.getElementById('arrSize').value || size;
        document.getElementById('sizeVal').innerText = size;
        document.getElementById('customInput').value = '';
        
        const container = document.getElementById('arrayContainer');
        container.innerHTML = '';
        data = [];
        
        // Generate Sorted Array
        let current = Math.floor(Math.random() * 5) + 1;
        for(let i=0; i<size; i++) {
            data.push(current);
            current += Math.floor(Math.random() * 8) + 1; 
            
            const box = document.createElement('div');
            box.className = 'box';
            box.innerText = data[i];
            box.id = `box-${i}`;
            
            const idx = document.createElement('div');
            idx.className = 'box-idx';
            idx.innerText = i;
            box.appendChild(idx);
            
            // Limit labels placeholders
            box.innerHTML += `
                <div id="lbl-l-${i}" class="pointer-label lbl-l" style="display:none;">L</div>
                <div id="lbl-m-${i}" class="pointer-label lbl-m" style="display:none;">M</div>
                <div id="lbl-r-${i}" class="pointer-label lbl-r" style="display:none;">R</div>
            `;
            
            container.appendChild(box);
        }
        log("New sorted array generated.", "info");
        document.getElementById('statusText').innerText = "Ready to search...";
        
        // Pick a random target
        document.getElementById('targetInput').value = data[Math.floor(Math.random() * data.length)];
    }

    function log(msg, type='info') {
        const box = document.getElementById('logBox');
        box.innerHTML += `<div class="log-entry log-${type}">[${new Date().toLocaleTimeString()}] ${msg}</div>`;
        box.scrollTop = box.scrollHeight;
    }

    const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

    function setPointers(l, m, r) {
        // Hide all pointers
        document.querySelectorAll('.pointer-label').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.box').forEach(b => {
             b.classList.remove('mid');
             // Dim logic handled in loop
        });

        if(l >= 0 && l < data.length) document.getElementById(`lbl-l-${l}`).style.display = 'block';
        if(r >= 0 && r < data.length) document.getElementById(`lbl-r-${r}`).style.display = 'block';
        if(m !== null && m >= 0 && m < data.length) {
            document.getElementById(`lbl-m-${m}`).style.display = 'block';
            document.getElementById(`box-${m}`).classList.add('mid');
        }
    }

    async function startSearch() {
        if(isSearching) return;
        
        const target = parseInt(document.getElementById('targetInput').value);
        if(isNaN(target)) {
            log("Please enter a valid target", "error");
            return;
        }

        isSearching = true; abort = false;
        document.getElementById('startBtn').disabled = true;
        
        // Reset styles
        document.querySelectorAll('.box').forEach(b => {
            b.classList.remove('found'); 
            b.classList.remove('dim');
            b.classList.remove('mid');
        });
        
        log(`Starting Binary Search for ${target}...`, "info");
        
        let l = 0;
        let r = data.length - 1;
        let found = false;

        while(l <= r) {
            if(abort) break;

            // Dim outside range
            for(let i=0; i<data.length; i++) {
                if(i < l || i > r) document.getElementById(`box-${i}`).classList.add('dim');
                else document.getElementById(`box-${i}`).classList.remove('dim');
            }

            let mid = Math.floor((l + r) / 2);
            setPointers(l, mid, r);
            
            document.getElementById('statusText').innerText = `L=${l}, R=${r} -> Checking Mid [${mid}] w/ Value ${data[mid]}`;
            log(`Checking Middle index [${mid}] value ${data[mid]}`, 'info');
            
            await delay(document.getElementById('speedRange').value);

            if(data[mid] === target) {
                document.getElementById(`box-${mid}`).classList.add('found');
                document.getElementById('statusText').innerText = `FOUND at Index ${mid}!`;
                log(`Target ${target} found at index ${mid}`, "success");
                found = true;
                break;
            } 
            else if (data[mid] < target) {
                log(`${data[mid]} < ${target}, moving Right (L = Mid + 1)`, 'warning');
                l = mid + 1;
            } else {
                log(`${data[mid]} > ${target}, moving Left (R = Mid - 1)`, 'warning');
                r = mid - 1;
            }
            
            await delay(document.getElementById('speedRange').value / 1.5);
        }
        
        if(!found && !abort) {
            // Dim all
             for(let i=0; i<data.length; i++) document.getElementById(`box-${i}`).classList.add('dim');
            log(`Target ${target} not found in array`, "error");
            document.getElementById('statusText').innerText = "Target Not Found";
        }

        isSearching = false;
        document.getElementById('startBtn').disabled = false;
    }
</script>
</body>
</html>
