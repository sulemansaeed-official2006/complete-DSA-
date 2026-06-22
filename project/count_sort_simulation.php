<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counting Sort Simulation</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .sim-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .arrays-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .array-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .array-label {
            width: 100px;
            font-weight: 600;
            color: var(--text-main);
        }

        .visual-array {
            display: flex;
            gap: 10px;
            padding: 10px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 10px;
            border: 2px dashed var(--border-color);
            min-height: 80px;
            align-items: center;
        }

        .array-bar {
            width: 50px;
            height: 50px;
            background: white;
            border: 2px solid var(--primary-color);
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .array-bar .index {
            position: absolute;
            bottom: -25px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .array-bar.highlight {
            background: var(--accent-color);
            color: white;
            transform: scale(1.1);
            border-color: var(--accent-color);
        }

        .array-bar.active {
            background: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }

        .controls-panel {
            grid-template-columns: 1fr 1.5fr; 
        }
    </style>
</head>
<body>
    <div class="container sim-container">
        <div class="nav-header">
            <a href="count_sort.php" class="back-link">← Back to Theory</a>
        </div>

        <header class="header">
            <h1>Counting Sort Simulation</h1>
            <p class="subtitle">Visualizing Frequency Counting & Placement</p>
        </header>

        <section class="card">
            <div class="arrays-container">
                <!-- Input Array -->
                <div class="array-row">
                    <div class="array-label">Input Array</div>
                    <div id="inputArray" class="visual-array"></div>
                </div>

                <!-- Count Array -->
                <div class="array-row">
                    <div class="array-label">Count Array</div>
                    <div id="countArray" class="visual-array"></div>
                </div>

                <!-- Output Array -->
                <div class="array-row">
                    <div class="array-label">Output Array</div>
                    <div id="outputArray" class="visual-array"></div>
                </div>
            </div>
        </section>

        <div class="controls-panel">
            <div class="control-card">
                <h3 style="color: var(--accent-color);">Controls</h3>
                <div class="controls">
                    <button onclick="generateRandomArray()" class="btn btn-primary">Generate New Array</button>
                    <button onclick="startSort()" class="btn btn-info">Start Sorting</button>
                </div>
                <div style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                    <strong>Note:</strong> Generating values between 0-9 for simplicity.
                </div>
            </div>

            <div class="control-card log-panel">
                 <h3 style="color: var(--accent-color);">Execution Log</h3>
                 <div id="log" class="operation-log" style="height: 150px;"></div>
            </div>
        </div>
    </div>

    <script>
        let arr = [];
        let countArr = [];
        let outputArr = [];
        const MAX_VAL = 9;
        const SIZE = 7;
        const DELAY = 800; // ms

        // UI References
        const inputDiv = document.getElementById('inputArray');
        const countDiv = document.getElementById('countArray');
        const outputDiv = document.getElementById('outputArray');
        const logDiv = document.getElementById('log');

        function generateRandomArray() {
            arr = [];
            for(let i=0; i<SIZE; i++) {
                arr.push(Math.floor(Math.random() * (MAX_VAL + 1)));
            }
            // Reset others
            countArr = new Array(MAX_VAL + 1).fill(0);
            outputArr = new Array(SIZE).fill(null);
            
            renderAll();
            addLog('Generated new random array (Values 0-9)', 'info');
        }

        function renderAll() {
            renderArray(inputDiv, arr, 'in');
            renderArray(countDiv, countArr, 'cnt');
            renderArray(outputDiv, outputArr, 'out');
        }

        function renderArray(container, data, prefix) {
            container.innerHTML = '';
            data.forEach((val, idx) => {
                const el = document.createElement('div');
                el.className = 'array-bar';
                el.id = `${prefix}-${idx}`;
                el.innerHTML = `
                    ${val === null ? '' : val}
                    <span class="index">${idx}</span>
                `;
                container.appendChild(el);
            });
        }

        function addLog(msg, type='info') {
            const entry = document.createElement('div');
            entry.className = `log-entry log-${type}`;
            entry.innerText = `[${new Date().toLocaleTimeString()}] ${msg}`;
            logDiv.appendChild(entry);
            logDiv.scrollTop = logDiv.scrollHeight;
        }

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        async function startSort() {
            addLog('Starting Count Sort...', 'info');

            // 1. Initialize Count Array
            countArr = new Array(MAX_VAL + 1).fill(0);
            renderAll();
            await sleep(DELAY);

            // 2. Count Frequencies
            addLog('Step 1: Counting Frequencies', 'warning');
            for(let i=0; i<arr.length; i++) {
                const val = arr[i];
                
                // Highlight input
                document.getElementById(`in-${i}`).classList.add('highlight');
                await sleep(DELAY/2);
                
                // Increment Count
                countArr[val]++;
                addLog(`Found ${val}. Incrementing Count[${val}] to ${countArr[val]}`);
                
                // Animate Count Update
                document.getElementById(`cnt-${val}`).classList.add('highlight');
                document.getElementById(`cnt-${val}`).innerHTML = `${countArr[val]}<span class="index">${val}</span>`;
                
                await sleep(DELAY);
                
                document.getElementById(`in-${i}`).classList.remove('highlight');
                document.getElementById(`cnt-${val}`).classList.remove('highlight');
            }

            // 3. Accumulate Counts
             addLog('Step 2: Accumulating Counts (Prefix Sum)', 'warning');
             for(let i=1; i<countArr.length; i++) {
                 const prev = countArr[i-1];
                 const curr = countArr[i];
                 countArr[i] += countArr[i-1];
                 
                 addLog(`Count[${i}] = Count[${i}] + Count[${i-1}] => ${curr} + ${prev} = ${countArr[i]}`);
                 
                 document.getElementById(`cnt-${i}`).classList.add('active');
                 document.getElementById(`cnt-${i-1}`).classList.add('active');
                 document.getElementById(`cnt-${i}`).innerHTML = `${countArr[i]}<span class="index">${i}</span>`;
                 
                 await sleep(DELAY);
                 
                 document.getElementById(`cnt-${i}`).classList.remove('active');
                 document.getElementById(`cnt-${i-1}`).classList.remove('active');
             }

             // 4. Build Output
             addLog('Step 3: Building Output Array (Reverse Traversal)', 'warning');
             outputArr = new Array(SIZE).fill(null);
             renderArray(outputDiv, outputArr, 'out'); // Clear visual
             
             for(let i=arr.length-1; i>=0; i--) {
                 const val = arr[i];
                 const pos = countArr[val];
                 const targetIdx = pos - 1;
                 
                 addLog(`Placing ${val}. Count[${val}] is ${pos}. Go to Output[${targetIdx}].`);
                 
                 // Highlight Input
                 document.getElementById(`in-${i}`).classList.add('highlight');
                 await sleep(DELAY/2);
                 
                 // Update Output
                 outputArr[targetIdx] = val;
                 document.getElementById(`out-${targetIdx}`).innerHTML = `${val}<span class="index">${targetIdx}</span>`;
                 document.getElementById(`out-${targetIdx}`).classList.add('active');
                 
                 // Decrement Count
                 countArr[val]--;
                 document.getElementById(`cnt-${val}`).innerHTML = `${countArr[val]}<span class="index">${val}</span>`;
                 document.getElementById(`cnt-${val}`).classList.add('highlight'); // Flash count change
                 
                 await sleep(DELAY);
                 
                 document.getElementById(`in-${i}`).classList.remove('highlight');
                 document.getElementById(`cnt-${val}`).classList.remove('highlight');
                 // Keep output highlighted to show it's done? Or remove to show next step clearly. Let's keep strict activity.
                 document.getElementById(`out-${targetIdx}`).classList.remove('active');
                 document.getElementById(`out-${targetIdx}`).classList.add('done'); // Mark final
             }
             
             addLog('Sorting Complete!', 'success');
        }

        // Init
        generateRandomArray();
    </script>
</body>
</html>
