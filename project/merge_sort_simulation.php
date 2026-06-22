<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merge Sort Simulation - Ultimate DSA</title>
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
            min-height: 400px;
        }
        .array-container {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            height: 300px;
            width: 100%;
            gap: 4px;
        }
        .bar {
            width: 30px;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            border-radius: 5px 5px 0 0;
            transition: height 0.3s ease, background 0.3s ease, transform 0.3s ease;
            position: relative;
            display: flex;
            justify-content: center;
        }
        .bar span {
            position: absolute;
            bottom: -25px;
            color: var(--text-secondary);
            font-size: 0.8rem;
        }
         
        /* Status Colors */
        .bar.merge-left { background: #ef4444; } /* Red */
        .bar.merge-right { background: #f59e0b; } /* Orange */
        .bar.sorted { background: #10b981; } /* Green */
        .bar.merging { background: #ec4899; box-shadow: 0 0 15px #ec4899; } /* Pink */
    </style>
</head>
<body>
    <div class="sim-container">
         <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
             <a href="merge_sort.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-code-merge"></i> Merge Sort
            </div>
        </div>

        <header class="header">
            <h1>Merge Sort Live</h1>
            <p class="subtitle">Visualizing Divide and Conquer Merging</p>
        </header>

        <div class="viz-section">
             <div class="array-container" id="arrayContainer"></div>
             <div id="statusText" style="margin-top: 20px; font-size: 1.2rem; color: var(--text-primary); font-weight: 500;">Ready</div>
        </div>

         <div class="controls">
            <div class="input-group" style="justify-content:center; max-width:600px; margin:0 auto;">
                <button class="btn btn-primary" onclick="generateArray()">New Random Array</button>
                <button class="btn btn-success" id="startBtn" onclick="startSort()">Start Sort</button>
                <input type="range" id="speedRange" min="50" max="1000" value="500" style="width:150px;">
                <span style="color:white; line-height:3;">Speed</span>
            </div>
        </div>
    </div>

<script>
    let data = [];
    const container = document.getElementById('arrayContainer');
    
    window.onload = generateArray;

    function generateArray() {
        data = [];
        container.innerHTML = '';
        for(let i=0; i<20; i++) {
            data.push(Math.floor(Math.random() * 80) + 10);
            const bar = document.createElement('div');
            bar.className = 'bar';
            bar.id = `bar-${i}`;
            bar.style.height = `${data[i] * 3}px`;
            bar.innerHTML = `<span>${data[i]}</span>`;
            container.appendChild(bar);
        }
        document.getElementById('statusText').innerText = "Ready to Sort";
    }

    const delay = ms => new Promise(res => setTimeout(res, ms));

    async function startSort() {
        document.getElementById('startBtn').disabled = true;
        await mergeSort(0, data.length - 1);
        document.getElementById('statusText').innerText = "Sorting Complete!";
        data.forEach((_, i) => document.getElementById(`bar-${i}`).classList.add('sorted'));
        document.getElementById('startBtn').disabled = false;
    }

    async function mergeSort(l, r) {
        if(l >= r) return;
        
        let m = l + Math.floor((r - l) / 2);
        
        await mergeSort(l, m);
        await mergeSort(m + 1, r);
        
        await merge(l, m, r);
    }

    async function merge(l, m, r) {
        document.getElementById('statusText').innerText = `Merging Range [${l} - ${r}]`;
        
        // Visual Highlight
        for(let i=l; i<=m; i++) document.getElementById(`bar-${i}`).classList.add('merge-left');
        for(let i=m+1; i<=r; i++) document.getElementById(`bar-${i}`).classList.add('merge-right');
        
        await delay(document.getElementById('speedRange').value);
        
        let n1 = m - l + 1;
        let n2 = r - m;
        
        let L = new Array(n1);
        let R = new Array(n2);
        
        for(let i=0; i<n1; i++) L[i] = data[l + i];
        for(let j=0; j<n2; j++) R[j] = data[m + 1 + j];
        
        let i = 0; 
        let j = 0; 
        let k = l;
        
        while (i < n1 && j < n2) {
             document.getElementById(`bar-${k}`).classList.add('merging');
            if (L[i] <= R[j]) {
                data[k] = L[i];
                updateBar(k, data[k]);
                i++;
            } else {
                data[k] = R[j];
                updateBar(k, data[k]);
                j++;
            }
            await delay(document.getElementById('speedRange').value / 2);
             document.getElementById(`bar-${k}`).classList.remove('merging');
            k++;
        }
        
        while (i < n1) {
            document.getElementById(`bar-${k}`).classList.add('merging');
            data[k] = L[i];
            updateBar(k, data[k]);
            i++; k++;
            await delay(document.getElementById('speedRange').value / 2);
             document.getElementById(`bar-${k-1}`).classList.remove('merging');
        }
        
        while (j < n2) {
            document.getElementById(`bar-${k}`).classList.add('merging');
            data[k] = R[j];
            updateBar(k, data[k]);
            j++; k++;
            await delay(document.getElementById('speedRange').value / 2);
             document.getElementById(`bar-${k-1}`).classList.remove('merging');
        }
        
        // Cleanup Viz
        for(let i=l; i<=r; i++) {
             document.getElementById(`bar-${i}`).className = 'bar';
             // Mark refined sorted range?
        }
    }

    function updateBar(idx, val) {
        const bar = document.getElementById(`bar-${idx}`);
        bar.style.height = `${val * 3}px`;
        bar.innerHTML = `<span>${val}</span>`;
    }
</script>
</body>
</html>
