<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion Sort Simulation - Ultimate DSA</title>
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

        .bar.key { background: linear-gradient(135deg, var(--warning-color), #d97706); transform: translateY(-20px); z-index: 20; box-shadow: 0 10px 20px rgba(0,0,0,0.4);border: 2px solid white; }
        .bar.compare { opacity: 0.7; }
        .bar.sorted { background: linear-gradient(135deg, var(--success-color), #059669); }
        .bar.shifting { background: linear-gradient(135deg, var(--info-color), #2563eb); }

        .controls-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .panel { background: var(--card-bg); padding: 2rem; border-radius: 20px; border: 1px solid var(--border-color); }
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
            <a href="insertion_sort.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-arrow-right-to-bracket"></i> Insertion Sort
            </div>
        </div>

        <header class="header">
            <h1>Visualization Playground</h1>
            <p class="subtitle">Place the key where it belongs!</p>
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
                    <i class="fa-solid fa-play"></i> Start Insertion Sort
                </button>

                <div class="stats-box">
                    <div class="stat-item">
                        <span class="stat-val" id="compCount">0</span>
                        <span class="stat-label">Comparisons</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-val" id="shiftCount">0</span>
                        <span class="stat-label">Shifts</span>
                    </div>
                </div>
            </div>

            <div class="panel">
                <h3><i class="fa-solid fa-code"></i> Algorithm</h3>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">insertion_sort.cpp</span>
                    </div>
                    <div class="code-content" style="display:block; max-height: 250px; overflow-y:auto;">
<pre><code class="cpp">void insertionSort(int arr[], int n) {
    for (int i = 1; i < n; i++) {
        int key = arr[i];
        int j = i - 1;
        while (j >= 0 && arr[j] > key) {
            arr[j + 1] = arr[j];
            j = j - 1;
        }
        arr[j + 1] = key;
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
    let shifts = 0;
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
               <div id="lbl-key-${i}" class="pointer-label lbl-key" style="display:none;">key</div>
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
               <div id="lbl-key-${i}" class="pointer-label lbl-key" style="display:none;">key</div>
            `;
            
            container.appendChild(bar);
        }
        resetStats();
        log("New array generated.", "info");
        document.getElementById('statusText').innerText = "Ready to sort...";
    }

    function resetStats() {
        comparisons = 0; shifts = 0;
        document.getElementById('compCount').innerText = '0';
        document.getElementById('shiftCount').innerText = '0';
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

    // Helper to update specific bar
    function updateBar(idx, val) {
        const bar = document.getElementById(`bar-${idx}`);
        bar.style.height = `${val * 3}px`;
        bar.firstChild.nodeValue = val;
    }

    function clearPointers() {
        document.querySelectorAll('.pointer-label').forEach(el => el.style.display = 'none');
    }

    function showPointers(i, j, keyIdx) {
        clearPointers();
        if(i !== null && i < data.length) document.getElementById(`lbl-i-${i}`).style.display = 'block';
        if(j !== null && j >= 0 && j < data.length) document.getElementById(`lbl-j-${j}`).style.display = 'block';
        // Note: Key might be floating, but we label the slot we are comparing
        if(keyIdx !== null && keyIdx < data.length) document.getElementById(`lbl-key-${keyIdx}`).style.display = 'block';
    }

    async function startSort() {
        if(isSorting) return;
        isSorting = true; abort = false;
        document.getElementById('startBtn').disabled = true;
        log("Sorting started...", "info");
        resetStats();
        const n = data.length;
        
        document.getElementById(`bar-0`).classList.add('sorted');

        for(let i=1; i < n; i++) {
            if(abort) break;

            let key = data[i];
            let j = i - 1;
            
            document.getElementById(`bar-${i}`).classList.add('key');
            document.getElementById('statusText').innerText = `Selected Key: ${key}`;
            log(`Key selected: ${key}`, 'info');
            
            showPointers(i, j, i); // i=unsorted start, j=sorted end, key=current i
            await delay(document.getElementById('speedRange').value);

            while(j >= 0 && data[j] > key) {
                if(abort) break;
                
                showPointers(i, j, null); // Show where we are comparing
                
                comparisons++;
                document.getElementById('compCount').innerText = comparisons;
                
                document.getElementById(`bar-${j}`).classList.add('compare');
                await delay(document.getElementById('speedRange').value / 2);
                
                // Shift
                document.getElementById(`bar-${j+1}`).style.height = document.getElementById(`bar-${j}`).style.height;
                document.getElementById(`bar-${j+1}`).firstChild.nodeValue = document.getElementById(`bar-${j}`).firstChild.nodeValue;
                document.getElementById(`bar-${j+1}`).classList.add('shifting');
                
                data[j+1] = data[j];
                shifts++;
                document.getElementById('shiftCount').innerText = shifts;
                
                log(`Shifted ${data[j]} to right`, 'warning');
                document.getElementById('statusText').innerText = `Shifting ${data[j]} > ${key}`;
                await delay(document.getElementById('speedRange').value);
                
                document.getElementById(`bar-${j}`).classList.remove('compare');
                document.getElementById(`bar-${j+1}`).classList.remove('shifting');
                document.getElementById(`bar-${j+1}`).classList.add('sorted'); 

                j = j - 1;
            }
            
            // Insert Key
            data[j + 1] = key;
            updateBar(j+1, key);
            
            document.getElementById(`bar-${i}`).classList.remove('key'); 
            
            for(let k=0; k<=i; k++) document.getElementById(`bar-${k}`).classList.add('sorted');
            
            log(`Inserted ${key} at index [${j+1}]`, 'success');
            showPointers(i, null, j+1); // Show where it landed
            await delay(document.getElementById('speedRange').value);
        }

        clearPointers();
        if(!abort) {
            log("Array completely sorted!", "success");
            document.getElementById('statusText').innerText = "Sorting Complete!";
        }
        isSorting = false;
        document.getElementById('startBtn').disabled = false;
    }
</script>
</body>
</html>
