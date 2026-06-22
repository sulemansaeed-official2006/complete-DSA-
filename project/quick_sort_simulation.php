<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Sort Simulation - Ultimate DSA</title>
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
            transition: height 0.3s ease, background 0.3s ease;
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
        .bar.pivot { background: #f59e0b; box-shadow: 0 0 15px #f59e0b; }
        .bar.less { background: #ef4444; } /* Red for left */
        .bar.greater { background: #10b981; } /* Green for right */
        .bar.sorted { background: #6366f1; opacity: 0.8; }
        .bar.compare { background: #d946ef; }
    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
             <a href="quick_sort.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-bolt"></i> Quick Sort
            </div>
        </div>

        <header class="header">
            <h1>Quick Sort Live</h1>
            <p class="subtitle">Recursive Partitioning Visualization</p>
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
        await quickSort(0, data.length - 1);
        document.getElementById('statusText').innerText = "Sorting Complete!";
        data.forEach((_, i) => document.getElementById(`bar-${i}`).classList.add('sorted'));
        document.getElementById('startBtn').disabled = false;
    }

    async function quickSort(low, high) {
        if (low < high) {
            let pi = await partition(low, high);
            
            await quickSort(low, pi - 1);
            await quickSort(pi + 1, high);
        }
    }

    async function partition(low, high) {
        let pivot = data[high];
        document.getElementById(`bar-${high}`).classList.add('pivot');
        document.getElementById('statusText').innerText = `Pivot Selected: ${pivot}`;
        
        let i = (low - 1);
        
        for (let j = low; j <= high - 1; j++) {
            document.getElementById(`bar-${j}`).classList.add('compare');
            await delay(document.getElementById('speedRange').value);
            
            if (data[j] < pivot) {
                i++;
                await swap(i, j);
                document.getElementById(`bar-${i}`).classList.add('less');
            } else {
                 document.getElementById(`bar-${j}`).classList.add('greater');
            }
            
             // Reset visual if not permanent state
             if(data[j] >= pivot) {
                  // Keep green
             }
        }
        await swap(i + 1, high);
        
        // Cleanup viz for this round
        for(let k=low; k<=high; k++) {
             document.getElementById(`bar-${k}`).className = 'bar'; 
        }
        
        return (i + 1);
    }

    async function swap(i, j) {
        if(i === j) return;
        
        let el1 = document.getElementById(`bar-${i}`);
        let el2 = document.getElementById(`bar-${j}`);
        
        let h1 = el1.style.height;
        let t1 = el1.innerText;
        
        el1.style.height = el2.style.height;
        el1.innerHTML = el2.innerHTML;
        
        el2.style.height = h1;
        el2.innerHTML = t1;
        
        let temp = data[i];
        data[i] = data[j];
        data[j] = temp;
        
        await delay(document.getElementById('speedRange').value);
    }
</script>
</body>
</html>
