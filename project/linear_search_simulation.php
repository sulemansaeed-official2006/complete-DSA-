<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Search Simulation - Ultimate DSA</title>
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
            min-height: 300px;
        }

        .array-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
        }

        .box {
            width: 70px;
            height: 70px;
            background: var(--dark-bg);
            border: 2px solid var(--primary-color);
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
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

        .box.current { background: var(--warning-color); border-color: #f59e0b; transform: scale(1.1); color: black; }
        .box.found { background: var(--success-color); border-color: #10b981; box-shadow: 0 0 20px rgba(16, 185, 129, 0.5); transform: scale(1.1); z-index: 10; }
        .box.checked { opacity: 0.5; background: #333; }

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
            <a href="linear_search.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-list-ol"></i> Linear Search
            </div>
        </div>

        <header class="header">
            <h1>Visualization Playground</h1>
            <p class="subtitle">Checking element by element until we find it!</p>
        </header>

        <div class="viz-section">
            <div class="search-controls">
                <input type="number" id="targetInput" placeholder="Target" class="value-input" style="width: 100px; text-align: center;">
                <button class="btn btn-primary" onclick="generateArray()">New Data</button>
            </div>
            
            <div class="array-container" id="arrayContainer"></div>
            
            <div id="statusText" style="margin-top: 30px; font-size: 1.4rem; color: var(--text-primary); font-weight: 500; min-height: 1.5em; text-align:center;">
                Ready to search...
            </div>
        </div>

        <div class="controls-grid">
            <div class="panel">
                <h3><i class="fa-solid fa-sliders"></i> Controls</h3>
                
                <div class="control-group">
                    <label>Custom Data (Max 20):</label>
                    <div style="display:flex; gap:5px;">
                        <input type="text" id="customInput" placeholder="e.g. 5, 12, 8" class="value-input" style="width:100%; border:1px solid var(--border-color); padding:8px; border-radius:8px;">
                        <button class="btn" style="background:var(--secondary-color); color:white; padding:0 15px;" onclick="loadCustomData()">Load</button>
                    </div>
                </div>

                <div class="control-group">
                    <label>Array Size: <span id="sizeVal" style="color:var(--primary-color); font-weight:bold;">10</span></label>
                    <input type="range" id="arrSize" min="5" max="20" value="10" oninput="generateArray(this.value)">
                </div>

                <div class="control-group">
                    <label>Speed (ms): <span id="speedVal" style="color:var(--primary-color); font-weight:bold;">500</span></label>
                    <input type="range" id="speedRange" min="100" max="2000" value="500" oninput="document.getElementById('speedVal').innerText=this.value">
                </div>

                <button id="startBtn" class="btn btn-success" style="width:100%; font-size:1.1rem; padding:1rem;" onclick="startSearch()">
                    <i class="fa-solid fa-play"></i> Start Linear Search
                </button>
            </div>

            <div class="panel">
                <h3><i class="fa-solid fa-code"></i> Algorithm</h3>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">linear_search.cpp</span>
                    </div>
                    <div class="code-content" style="display:block;">
<pre><code class="cpp">int linearSearch(int arr[], int n, int target) {
    for (int i = 0; i < n; i++) {
        if (arr[i] == target) {
            return i; // Found
        }
    }
    return -1; // Not Found
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
        
        const arr = input.split(/[, ]+/).map(n => parseInt(n.trim())).filter(n => !isNaN(n));
        
        if(arr.length < 5 || arr.length > 20) {
            log("Please enter between 5 and 20 numbers.", "error");
            return;
        }
        
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
            container.appendChild(box);
        });
        
        log("Custom data loaded.", "success");
        document.getElementById('statusText').innerText = "Ready to search...";
        document.getElementById('targetInput').value = data[0]; // Suggest first
    }

    function generateArray(size = 10) {
        if(isSearching) return;
        size = document.getElementById('arrSize').value || size;
        document.getElementById('sizeVal').innerText = size;
        document.getElementById('customInput').value = '';
        const container = document.getElementById('arrayContainer');
        container.innerHTML = '';
        data = [];
        for(let i=0; i<size; i++) {
            const val = Math.floor(Math.random() * 50) + 1;
            data.push(val);
            const box = document.createElement('div');
            box.className = 'box';
            box.innerText = val;
            box.id = `box-${i}`;
            const idx = document.createElement('div');
            idx.className = 'box-idx';
            idx.innerText = i;
            box.appendChild(idx);
            container.appendChild(box);
        }
        log("New array generated.", "info");
        document.getElementById('statusText').innerText = "Ready to search...";
        
        // Pick a random target to suggest
        document.getElementById('targetInput').value = data[Math.floor(Math.random() * data.length)];
    }

    function log(msg, type='info') {
        const box = document.getElementById('logBox');
        box.innerHTML += `<div class="log-entry log-${type}">[${new Date().toLocaleTimeString()}] ${msg}</div>`;
        box.scrollTop = box.scrollHeight;
    }

    const delay = (ms) => new Promise(resolve => setTimeout(resolve, ms));

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
        document.querySelectorAll('.box').forEach(b => b.className = 'box');
        
        log(`Starting Linear Search for ${target}...`, "info");
        document.getElementById('statusText').innerText = `Searching for ${target}...`;
        
        let found = false;

        for(let i=0; i < data.length; i++) {
            if(abort) break;
            
            document.getElementById(`box-${i}`).classList.add('current');
            document.getElementById('statusText').innerText = `Checking index [${i}]: Is ${data[i]} == ${target}?`;
            
            await delay(document.getElementById('speedRange').value);

            if(data[i] === target) {
                document.getElementById(`box-${i}`).classList.remove('current');
                document.getElementById(`box-${i}`).classList.add('found');
                document.getElementById('statusText').innerText = `FOUND at Index ${i}!`;
                log(`Target ${target} found at index ${i}`, "success");
                found = true;
                break;
            } else {
                document.getElementById(`box-${i}`).classList.remove('current');
                document.getElementById(`box-${i}`).classList.add('checked');
            }
        }
        
        if(!found && !abort) {
            log(`Target ${target} not found in array`, "error");
            document.getElementById('statusText').innerText = "Target Not Found";
        }

        isSearching = false;
        document.getElementById('startBtn').disabled = false;
    }
</script>
</body>
</html>
