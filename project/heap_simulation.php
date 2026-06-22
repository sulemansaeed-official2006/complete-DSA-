<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heap Visualization - Ultimate DSA</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sim-container { max-width: 1400px; margin: 0 auto; padding: 2rem; }
        
        #heapCanvas {
            width: 100%;
            height: 450px;
            background: #0f172a;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            box-shadow: inset 0 0 50px rgba(0,0,0,0.5);
        }

        .h-node {
            width: 45px; height: 45px;
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-weight: bold;
            position: absolute;
            transition: all 0.5s ease;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.4);
            z-index: 10;
            font-size: 1.1rem;
            border: 2px solid rgba(255,255,255,0.2);
        }
        
        .h-node.sorted {
            background: linear-gradient(135deg, #10b981, #059669); /* Green for sorted */
            box-shadow: 0 0 15px #10b981;
            opacity: 0.8;
        }

        .h-edge {
            position: absolute;
            background: #475569;
            height: 2px;
            transform-origin: 0 0;
            z-index: 5;
            transition: all 0.5s ease;
        }
        
        .array-view {
            display: flex; gap: 8px; justify-content: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #1e293b;
            border-radius: 10px;
            overflow-x: auto;
        }
        .arr-box {
            width: 45px; height: 45px;
            border: 1px solid #334155;
            color: white;
            display: flex; justify-content: center; align-items: center;
            font-family: 'Fira Code', monospace;
            background: #0f172a;
            border-radius: 5px;
            transition: all 0.3s;
            position: relative;
        }
        .arr-index {
            position: absolute;
            bottom: -20px;
            font-size: 0.7rem;
            color: #64748b;
        }
        
        .arr-box.active { border-color: #fbbf24; box-shadow: 0 0 10px #fbbf24; color: #fbbf24; }
        .arr-box.sorted { background: #064e3b; border-color: #10b981; color: #34d399; }

        .highlight-swap { background: #f59e0b !important; transform: scale(1.2); z-index: 20; }
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7); backdrop-filter: blur(5px);
            display: none; justify-content: center; align-items: center;
            z-index: 1000; opacity: 0; transition: opacity 0.3s ease;
        }
        .modal-overlay.active { display: flex; opacity: 1; }
        .modal-content {
            background: #1e293b; border: 1px solid #3b82f6;
            padding: 2rem; border-radius: 15px;
            box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
            text-align: center; transform: scale(0.9); transition: transform 0.3s ease;
            width: 300px;
        }
        .modal-overlay.active .modal-content { transform: scale(1); }
        .modal-content h3 { color: white; margin-bottom: 1.5rem; font-family: 'Inter', sans-serif; }
        .input-group input {
            width: 100%; padding: 15px; font-size: 1.5rem;
            background: #0f172a; border: 2px solid #475569; border-radius: 8px;
            color: #fbbf24; text-align: center; font-weight: bold;
            outline: none; transition: border-color 0.3s;
        }
        .input-group input:focus { border-color: #fbbf24; }
        .modal-actions { display: flex; gap: 10px; margin-top: 1.5rem; }
        .modal-actions button { flex: 1; padding: 10px; border-radius: 8px; cursor: pointer; border: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
             <a href="heap.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-cubes-stacked"></i> Max Heap
            </div>
        </div>

        <header class="header">
            <h1>Heap Sandbox</h1>
            <p class="subtitle">Build Heaps, Extract Max, and Visualize <span style="color:#fbbf24;">Heap Sort!</span></p>
        </header>

        <div style="background:var(--card-bg); padding:2rem; border-radius:20px; box-shadow:var(--shadow); border:1px solid var(--border-color);">
            <div id="heapCanvas"></div>
            
            <div class="array-view" id="arrayViz"></div>
            
            <div id="statusText" style="text-align:center; font-size:1.2rem; min-height:1.5em; margin-bottom:20px; color:var(--text-primary); font-weight:500;">
                Ready. Add nodes to start.
            </div>
            
            <div class="controls" style="display:flex; gap:15px; justify-content:center; flex-wrap:wrap;">
                <button class="btn btn-primary" onclick="openInsertModal()"><i class="fa-solid fa-plus"></i> Insert Node</button>
                <button class="btn btn-warning" onclick="randomizeHeap()"><i class="fa-solid fa-dice"></i> Randomize</button>
                <div style="width: 1px; background: #334155; margin: 0 10px;"></div>
                <button class="btn btn-danger" onclick="extractMax()"><i class="fa-solid fa-arrow-up-from-bracket"></i> Extract Max</button>
                <button class="btn btn-success" onclick="startHeapSort()"><i class="fa-solid fa-arrow-down-a-z"></i> Run Heap Sort</button>
                <div style="width: 1px; background: #334155; margin: 0 10px;"></div>
                <button class="btn btn-info" onclick="resetHeap()">Clear</button>
            </div>
        </div>
    </div>

    <!-- VIP Insert Modal -->
    <div id="insertModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Insert Node Value</h3>
            <div class="input-group">
                <input type="number" id="insertValInput" placeholder="Val" autofocus>
            </div>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeInsertModal()">Cancel</button>
                <button class="btn btn-primary" onclick="confirmInsert()">Insert</button>
            </div>
        </div>
    </div>

<script>
    let heap = [];
    let heapSize = 0; // Effectively displayed heap size
    const canvas = document.getElementById('heapCanvas');
    let isBusy = false;

    // --- Modal Logic ---
    function openInsertModal() {
        if(isBusy) return;
        const modal = document.getElementById('insertModal');
        const input = document.getElementById('insertValInput');
        modal.classList.add('active');
        input.value = Math.floor(Math.random() * 99) + 1; // Suggest random
        input.focus();
        input.select();
        
        input.onkeydown = (e) => {
            if(e.key === "Enter") confirmInsert();
            if(e.key === "Escape") closeInsertModal();
        }
    }

    function closeInsertModal() {
        document.getElementById('insertModal').classList.remove('active');
    }

    function confirmInsert() {
        const val = parseInt(document.getElementById('insertValInput').value);
        if(!isNaN(val)) {
            closeInsertModal();
            insertHeap(val);
        }
    }
    // -------------------

    function randomizeHeap() {
        if(isBusy) return;
        resetHeap();
        // Generate 7-15 random numbers
        const count = 7 + Math.floor(Math.random() * 8);
        for(let i=0; i<count; i++) {
            heap.push(Math.floor(Math.random() * 99) + 1);
        }
        heapSize = heap.length;
        // Build heap property manually or just let it be random? 
        // Let's build it so it looks nice immediately, then user can sort
        buildMaxHeap(); 
        drawHeap();
        setStatus("Random Heap Generated.");
    }
    
    function buildMaxHeap() {
        for(let i = Math.floor(heap.length/2) - 1; i >= 0; i--) {
            heapify(heap.length, i, false); // Instant heapify
        }
    }
    
    // Instant heapify helper without animation for setup
    function heapify(n, i, animate) {
        let largest = i;
        let l = 2*i + 1;
        let r = 2*i + 2;
        if(l < n && heap[l] > heap[largest]) largest = l;
        if(r < n && heap[r] > heap[largest]) largest = r;
        if(largest != i) {
            [heap[i], heap[largest]] = [heap[largest], heap[i]];
            heapify(n, largest, false);
        }
    }

    async function insertHeap(val) {
        if(isBusy) return;
        isBusy = true;
        
        // If we were in sorted state (heapSize < heap.length), reset to full heap mode?
        // Actually, let's just push to heapSize and ignore the "sorted" tail if we act as a heap again.
        if (heapSize < heap.length) {
            heap = heap.slice(0, heapSize); // Discard sorted part if inserting new
        }

        heap.push(val);
        heapSize++;
        drawHeap();
        setStatus(`Inserted ${val} at leaf.`);
        await delay(600);
        
        // Bubble Up
        let i = heapSize - 1;
        while(i > 0) {
            let p = Math.floor((i - 1) / 2);
            
            highlightNode(i, 'active');
            highlightNode(p, 'active');
            await delay(500);
            
            if(heap[i] > heap[p]) {
                setStatus(`${heap[i]} > ${heap[p]}, Swapping...`);
                await swapAnim(i, p);
                i = p;
            } else {
                highlightNode(i, null);
                highlightNode(p, null);
                break;
            }
        }
        
        setStatus("Max-Heap Property Satisfied.");
        drawHeap();
        isBusy = false;
    }

    async function extractMax() {
        if(isBusy || heapSize === 0) return;
        isBusy = true;
        
        setStatus(`Swapping Root (${heap[0]}) with Last (${heap[heapSize-1]})`);
        await swapAnim(0, heapSize-1);
        
        const max = heap.pop(); // Remove it
        heapSize--;
        
        drawHeap();
        setStatus(`Extracted Max: ${max}`);
        await delay(500);
        
        await heapifyDown(0);
        
        setStatus("Ready.");
        isBusy = false;
    }
    
    async function startHeapSort() {
        if(isBusy || heapSize === 0) return;
        isBusy = true;
        setStatus("Starting Heap Sort...");
        
        // 1. Build Heap (ensure it is one, usually it is active)
        // (Assuming it is already a heap from inserts/randomize)
        
        // 2. Extract elements one by one
        let originalSize = heapSize;
        
        for (let i = heapSize - 1; i > 0; i--) {
            setStatus(`Moving Max (${heap[0]}) to sorted position ${i}`);
            
            // Swap Root with End
            highlightNode(0, 'active');
            highlightNode(i, 'active');
            await delay(600);
            
            // Swap in array
            [heap[0], heap[i]] = [heap[i], heap[0]];
            
            drawHeap(); // This will show node 'i' clearly?
            // Actually, we need to mark 'i' as sorted NOW visually
            // But we decrement heapSize first so drawHeap treats it as "not part of tree"
            // We want to KEEP it on screen but colored green.
            
            // So we need drawHeap to handle "sorted" tail.
            
            heapSize--; // Reduce heap size
            drawHeap(); 
            
            await delay(600);
            
            // Heapify Root
            setStatus(`Restoring Heap Property...`);
            await heapifyDown(0);
        }
        
        // Final element is technically sorted
        heapSize = 0; // All sorted? Or keep visuals?
        // Let's set heapSize to 0 to mean "Tree is empty, all Array is sorted"
        // But drawHeap needs to know to render the array fully green.
        
        setStatus("Heap Sort Complete! Array is Sorted.");
        drawHeap(); // Render full sorted array
        isBusy = false;
        
        // Restore for further interaction?
        // Let's leave it as sorted array. User can Clear or Randomize.
    }

    async function heapifyDown(i) {
        let largest = i;
        let l = 2*i + 1;
        let r = 2*i + 2;
        
        if (l < heapSize && heap[l] > heap[largest]) largest = l;
        if (r < heapSize && heap[r] > heap[largest]) largest = r;
        
        if (largest !== i) {
            highlightNode(i, 'active');
            highlightNode(largest, 'active');
            setStatus(`Swapping ${heap[i]} with larger child ${heap[largest]}`);
            await delay(600);
            
            [heap[i], heap[largest]] = [heap[largest], heap[i]];
            drawHeap();
            
            await heapifyDown(largest);
        }
    }

    async function swapAnim(i, j) {
        // Simple swap logic + redraw for now, refined animation takes complex CSS
        [heap[i], heap[j]] = [heap[j], heap[i]];
        drawHeap();
        highlightNode(i, 'swap');
        highlightNode(j, 'swap');
        await delay(600);
        highlightNode(i, null);
        highlightNode(j, null);
    }

    function drawHeap() {
        canvas.innerHTML = '';
        const arrViz = document.getElementById('arrayViz');
        arrViz.innerHTML = '';
        
        // Array Viz
        // We show ALL elements in heap[] array. 
        // Index 0 to heapSize-1 are "Heap" (Blue)
        // Index heapSize to heap.length-1 are "Sorted" (Green)
        
        // Note: during ExtractMax we actually POP, so array shrinks.
        // During HeapSort we decrement heapSize but keep elements in array.
        
        heap.forEach((v, idx) => {
            const b = document.createElement('div');
            b.className = 'arr-box';
            b.innerText = v;
            
            const idxLbl = document.createElement('div');
            idxLbl.className = 'arr-index';
            idxLbl.innerText = idx;
            b.appendChild(idxLbl);
            
            // Styling
            if(idx >= heapSize) b.classList.add('sorted');
            
            b.id = `arr-${idx}`;
            arrViz.appendChild(b);
        });

        // Tree Viz
        // Only draw up to heapSize
        if(heapSize > 0) drawNodeRecursive(0, canvas.clientWidth/2, 50, canvas.clientWidth/4);
    }

    function drawNodeRecursive(idx, x, y, offset) {
        if(idx >= heapSize) return;
        
        // Children
        const l = 2*idx + 1;
        const r = 2*idx + 2;
        
        if(l < heapSize) {
            const childX = x - offset;
            const childY = y + 80;
            drawEdge(x, y, childX, childY);
            drawNodeRecursive(l, childX, childY, offset/1.8);
        }
        if(r < heapSize) {
            const childX = x + offset;
            const childY = y + 80;
            drawEdge(x, y, childX, childY);
            drawNodeRecursive(r, childX, childY, offset/1.8);
        }
        
        const n = document.createElement('div');
        n.className = 'h-node';
        n.id = `hnode-${idx}`;
        n.innerText = heap[idx];
        n.style.left = (x - 22.5) + 'px'; // Centering (width/2)
        n.style.top = (y - 22.5) + 'px';
        canvas.appendChild(n);
    }

    function drawEdge(x1, y1, x2, y2) {
        const len = Math.hypot(x2-x1, y2-y1);
        const ang = Math.atan2(y2-y1, x2-x1) * 180 / Math.PI;
        const edge = document.createElement('div');
        edge.className = 'h-edge';
        edge.style.width = len + 'px';
        edge.style.left = x1 + 'px';
        edge.style.top = y1 + 'px';
        edge.style.transform = `rotate(${ang}deg)`;
        canvas.appendChild(edge);
    }
    
    function highlightNode(idx, type) {
        // Highlight Tree Node
        const el = document.getElementById(`hnode-${idx}`);
        if(el) {
            el.className = 'h-node'; // reset
            if(type === 'active') el.style.borderColor = '#fbbf24'; 
            if(type === 'swap') el.classList.add('highlight-swap');
        }
        
        // Highlight Array Box
        const arrEl = document.getElementById(`arr-${idx}`);
        if(arrEl) {
            arrEl.classList.remove('active', 'highlight-swap');
            if(type === 'active') arrEl.classList.add('active');
            if(type === 'swap') arrEl.classList.add('highlight-swap');
        }
    }

    const delay = ms => new Promise(r => setTimeout(r, ms));
    function setStatus(msg) { document.getElementById('statusText').innerText = msg; }
    function resetHeap() { 
        heap = []; 
        heapSize = 0;
        drawHeap(); 
        setStatus("Ready."); 
    }
</script>
</body>
</html>
