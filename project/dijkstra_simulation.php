<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dijkstra Visualization - Ultimate DSA</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sim-container { max-width: 1400px; margin: 0 auto; padding: 2rem; }
        
        .viz-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .viz-section {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow);
            position: relative;
            min-height: 500px;
        }

        #graphCanvas {
            width: 100%;
            height: 450px;
            background: #0f172a;
            border-radius: 12px;
            cursor: crosshair;
            position: relative;
            overflow: hidden;
        }

        .g-node {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-weight: bold;
            position: absolute;
            z-index: 10;
            border: 2px solid white;
            transition: all 0.3s ease;
        }
        
        .g-node.visited { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 0 15px #10b981; }
        .g-node.processing { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 0 20px #f59e0b; transform: scale(1.1); }

        .g-edge {
            position: absolute;
            background: #64748b;
            height: 2px;
            transform-origin: 0 0;
            z-index: 5;
        }
        
        .g-edge.active { background: #f59e0b; height: 4px; box-shadow: 0 0 10px #f59e0b; }
        .g-edge.path-highlight { background: #ef4444; height: 4px; box-shadow: 0 0 15px #ef4444 !important; z-index: 20; }
        .g-node.path-node { border-color: #ef4444; box-shadow: 0 0 20px #ef4444; transform: scale(1.2); z-index: 21; }

        .edge-weight {
            position: absolute;
            background: #1e293b;
            padding: 2px 6px;
            border-radius: 4px;
            color: #fbbf24;
            font-size: 0.8rem;
            border: 1px solid #475569;
        }
        
        /* Distance Table */
        .dist-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Fira Code', monospace;
            font-size: 0.9rem;
        }
        .dist-table th, .dist-table td {
            padding: 8px;
            border-bottom: 1px solid #334155;
            text-align: left;
            color: var(--text-secondary);
        }
        .dist-table th { color: var(--text-primary); }
        .dist-table tr.highlight-row { background: rgba(16, 185, 129, 0.2); }
    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
             <a href="dijkstra.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-route"></i> Dijkstra Visualization
            </div>
        </div>

        <header class="header">
            <h1>Dijkstra Sandbox</h1>
            <p class="subtitle">Build a weighted graph and find shortest paths!</p>
        </header>

        <div class="viz-grid">
            <!-- Left: Graph -->
            <div class="viz-section">
                <div id="graphCanvas" onclick="handleCanvasClick(event)">
                     <div style="position:absolute; top:10px; left:10px; background:rgba(0,0,0,0.6); color:white; padding:5px 10px; border-radius:5px; pointer-events:none;">
                        Mode: <span id="currentMode">Add Node</span>
                    </div>
                </div>
                <div id="statusText" style="text-align:center; margin-top:15px; font-weight:500; min-height:1.2em;">Ready. Add nodes and edges.</div>
            </div>

            <!-- Right: Details -->
            <div class="viz-section" style="padding: 1.5rem;">
                <h3><i class="fa-solid fa-table"></i> Distance Table</h3>
                <div style="max-height: 250px; overflow-y:auto; margin-bottom: 20px;">
                    <table class="dist-table" id="distTable">
                        <thead><tr><th>Node</th><th>Min Dist</th><th>Path</th></tr></thead>
                        <tbody></tbody>
                    </table>
                </div>

                <h3><i class="fa-solid fa-list-ol"></i> Priority Queue</h3>
                <div id="pqViz" style="background: rgba(0,0,0,0.2); padding: 10px; border-radius: 8px; font-family:'Fira Code'; font-size:0.9rem; min-height:40px; color: #94a3b8;">
                    Empty
                </div>
                
                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 20px 0;">
                
                <div class="controls">
                    <div style="display:flex; gap:10px; margin-bottom:10px;">
                         <button class="btn btn-primary" onclick="setMode('node')" style="font-size:0.8rem;">Nodes</button>
                         <button class="btn btn-info" onclick="setMode('edge')" style="font-size:0.8rem;">Edges</button>
                    </div>
                    <button class="btn btn-success" style="width:100%;" onclick="runDijkstra()">Run Dijkstra (from Node 0)</button>
                    <button class="btn btn-danger" style="width:100%; margin-top:10px;" onclick="clearGraph()">Clear</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Weight Modal -->
    <div id="weightModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Set Edge Weight</h3>
            <div class="input-group">
                <input type="number" id="customWeightInput" placeholder="Enter Cost" min="1" value="5" autoselect>
            </div>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeModal(null)">Cancel</button>
                <button class="btn btn-primary" onclick="confirmWeight()">Set Weight</button>
            </div>
        </div>
    </div>
    
    <style>
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
        .btn-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; }
        .btn-secondary { background: #475569; color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4); }
    </style>

<script>
    let nodes = [];
    let edges = [];
    let mode = 'node';
    let selectedNode = null;
    let isRunning = false;
    let weightPromiseResolver = null; // For modal
    const canvas = document.getElementById('graphCanvas');
    
    // Result State
    let isFinished = false;
    let globalParent = [];
    let globalDist = [];

    // ... (Previous setMode, handleCanvasClick, addNode, nodeClick remain same) ... 
    
    function setMode(m) {
        if(isFinished) clearGraph(); // Reset if user changes mode after run
        mode = m;
        selectedNode = null;
        document.getElementById('currentMode').innerText = m === 'node' ? 'Add Node' : 'Add Edge';
    }

    function handleCanvasClick(e) {
        if(isRunning) return;
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (mode === 'node') {
             // Basic collision check
            for(let n of nodes) if(Math.hypot(n.x - x, n.y - y) < 40) return;
            addNode(x, y);
        }
    }

    function addNode(x, y) {
        const id = nodes.length;
        nodes.push({id, x, y});
        const el = document.createElement('div');
        el.className = 'g-node';
        el.id = `node-${id}`;
        el.innerText = id;
        el.style.left = (x - 20) + 'px';
        el.style.top = (y - 20) + 'px';
        el.onclick = (e) => { e.stopPropagation(); nodeClick(id); };
        canvas.appendChild(el);
        updateTableInitial();
    }

    function nodeClick(id) {
        // Result Interaction
        if(isFinished) {
            showPathTo(id);
            return;
        }

        if(mode !== 'edge' || isRunning) return;
        if(selectedNode === null) {
            selectedNode = id;
            document.getElementById(`node-${id}`).style.borderColor = '#f59e0b';
        } else {
            if(selectedNode !== id) addEdge(selectedNode, id);
            document.getElementById(`node-${selectedNode}`).style.borderColor = 'white';
            selectedNode = null;
        }
    }
    
    function showPathTo(target) {
        // Reset previous highlights
        document.querySelectorAll('.g-edge').forEach(e => e.classList.remove('path-highlight'));
        document.querySelectorAll('.g-node').forEach(n => n.classList.remove('path-node'));
        
        if(globalDist[target] === Infinity) {
            setStatus(`No path exists to Node ${target}`);
            return;
        }
        
        let path = [];
        let curr = target;
        while(curr !== -1) {
            path.unshift(curr);
            document.getElementById(`node-${curr}`).classList.add('path-node');
            
            const p = globalParent[curr];
            if(p !== -1) {
                // Highlight edge
                let edgeId = `edge-${p}-${curr}`;
                 if(!document.getElementById(edgeId)) edgeId = `edge-${curr}-${p}`;
                 if(document.getElementById(edgeId)) document.getElementById(edgeId).classList.add('path-highlight');
            }
            curr = p;
        }
        
        setStatus(`Shortest Path to ${target}: ${path.join(' ➝ ')} (Cost: ${globalDist[target]})`);
    }

    async function addEdge(u, v) {
        if(edges.some(e => (e.u === u && e.v === v) || (e.u === v && e.v === u))) return;
        
        // Use Custom Modal
        const w = await getCustomWeight(u, v);
        if(w === null) return; // Cancelled
        
        edges.push({u, v, w});
        
        const n1 = nodes[u];
        const n2 = nodes[v];
        
        const len = Math.hypot(n2.x - n1.x, n2.y - n1.y);
        const ang = Math.atan2(n2.y - n1.y, n2.x - n1.x) * 180 / Math.PI;
        
        const line = document.createElement('div');
        line.className = 'g-edge';
        line.id = `edge-${u}-${v}`;
        line.style.width = len + 'px';
        line.style.left = n1.x + 'px';
        line.style.top = n1.y + 'px';
        line.style.transform = `rotate(${ang}deg)`;
        
        const lbl = document.createElement('div');
        lbl.className = 'edge-weight';
        lbl.innerText = w;
        lbl.style.left = '50%';
        lbl.style.top = '-15px';
        lbl.style.transform = `translateX(-50%) rotate(${-ang}deg)`;
        
        line.appendChild(lbl);
        canvas.insertBefore(line, canvas.firstChild);
    }
    
    // Modal Logic
    function getCustomWeight(u, v) {
        return new Promise(resolve => {
            const modal = document.getElementById('weightModal');
            const input = document.getElementById('customWeightInput');
            modal.classList.add('active');
            input.value = 5; // default
            input.focus();
            input.select();
            
            // Temporary handler for Confirm
            window.confirmWeight = () => {
                const val = parseInt(input.value);
                closeModal(val > 0 ? val : 1);
            };
            
            // Temporary handler for Close
            window.closeModal = (val) => {
                modal.classList.remove('active');
                resolve(val);
            };
            
            // Enter key support
            input.onkeydown = (e) => {
                if(e.key === 'Enter') confirmWeight();
                if(e.key === 'Escape') closeModal(null);
            };
        });
    }

    function updateTableInitial() {
        const tbody = document.querySelector('#distTable tbody');
        tbody.innerHTML = '';
        nodes.forEach(n => {
            const tr = document.createElement('tr');
            tr.id = `row-${n.id}`;
            tr.innerHTML = `<td>${n.id}</td><td id="d-${n.id}">∞</td><td id="p-${n.id}">-</td>`;
            tbody.appendChild(tr);
        });
    }

    async function runDijkstra() {
        if(nodes.length === 0 || isRunning) return;
        isRunning = true;
        isFinished = false;
        resetViz();
        
        const src = 0;
        let dist = new Array(nodes.length).fill(Infinity);
        let parent = new Array(nodes.length).fill(-1);
        let visited = new Set();
        dist[src] = 0;
        
        // Simple Priority Queue (Array sorted by dist)
        let pq = [{id: src, d: 0}];
        
        updateTable(dist, parent);
        
        while(pq.length > 0) {
            // Sort PQ (Min Heap Simulation)
            pq.sort((a,b) => a.d - b.d);
            updatePQViz(pq);
            
            const curr = pq.shift();
            const u = curr.id;
            
            if(visited.has(u)) continue;
            visited.add(u);
            
            document.getElementById(`node-${u}`).classList.add('processing');
            setStatus(`Processing Node ${u} (Dist: ${dist[u]})`);
            await delay(800);
            
            // Get neighbors
            let neighbors = [];
            edges.forEach(e => {
                if(e.u === u) neighbors.push({id: e.v, w: e.w});
                if(e.v === u) neighbors.push({id: e.u, w: e.w});
            });
            
            for(let nb of neighbors) {
                const v = nb.id;
                const weight = nb.w;
                
                if(!visited.has(v)) {
                     highlightLine(u, v, true);
                     setStatus(`Checking neighbor ${v} (Weight: ${weight})`);
                     await delay(500);
                     
                     if(dist[u] + weight < dist[v]) {
                         dist[v] = dist[u] + weight;
                         parent[v] = u;
                         setStatus(`Relaxed ${v}: New Dist ${dist[v]}`);
                         updateTable(dist, parent, v);
                         pq.push({id: v, d: dist[v]});
                         updatePQViz(pq);
                         await delay(500);
                     }
                     highlightLine(u, v, false);
                }
            }
            
            document.getElementById(`node-${u}`).classList.remove('processing');
            document.getElementById(`node-${u}`).classList.add('visited');
        }
        
        // Save Global State
        globalParent = parent;
        globalDist = dist;
        isFinished = true;
        
        // Auto-show path to the last added node (End Node)
        if(nodes.length > 1) {
            const target = nodes.length - 1;
            setStatus(`Calculation Complete. Finding Shortest Path to End Node (${target})...`);
            await delay(1000);
            showPathTo(target);
        } else {
             setStatus("Dijkstra Complete!");
        }
        
        isRunning = false;
    }
    
    function highlightLine(u, v, active) {
        let el = document.getElementById(`edge-${u}-${v}`);
        if(!el) el = document.getElementById(`edge-${v}-${u}`);
        if(el) {
            if(active) el.classList.add('active');
            else el.classList.remove('active');
        }
    }

    function updateTable(dist, parent, highlightId = -1) {
        nodes.forEach(n => {
            const dStr = dist[n.id] === Infinity ? '∞' : dist[n.id];
            document.getElementById(`d-${n.id}`).innerText = dStr;
            document.getElementById(`p-${n.id}`).innerText = parent[n.id] === -1 ? '-' : parent[n.id];
            
            const row = document.getElementById(`row-${n.id}`);
            if(n.id === highlightId) {
                row.classList.add('highlight-row');
                setTimeout(() => row.classList.remove('highlight-row'), 1000);
            }
        });
    }
    
    function updatePQViz(pq) {
        const div = document.getElementById('pqViz');
        if(pq.length === 0) { div.innerText = "Empty"; return; }
        div.innerText = pq.map(item => `[${item.id}:${item.d}]`).join(', ');
    }
    
    function resetViz() {
         document.querySelectorAll('.g-node').forEach(el => {
             el.className = 'g-node';
         });
         document.querySelectorAll('.g-edge').forEach(e => e.classList.remove('path-highlight'));
         updateTableInitial();
    }
    
    function clearGraph() {
        if(isRunning) return;
        nodes = []; edges = [];
        isFinished = false;
        canvas.innerHTML = '<div style="position:absolute; top:10px; left:10px; background:rgba(0,0,0,0.6); color:white; padding:5px 10px; border-radius:5px; pointer-events:none;">Mode: <span id="currentMode">Add Node</span></div>';
        updateTableInitial();
    }
    
    function setStatus(msg) {
        document.getElementById('statusText').innerText = msg;
    }

    const delay = ms => new Promise(r => setTimeout(r, ms));

    // Auto-Initialize Graph
    function initGraph() {
        // Create 5 Nodes in a circle/pentagon shape
        const centerX = canvas.clientWidth / 2;
        const centerY = canvas.clientHeight / 2;
        const radius = 150;
        
        const positions = [];
        for(let i=0; i<6; i++) {
            const angle = (i * 2 * Math.PI) / 6 - Math.PI/2; // Start from top
            positions.push({
                x: centerX + radius * Math.cos(angle),
                y: centerY + radius * Math.sin(angle)
            });
        }
        
        // Add Nodes
        positions.forEach(pos => addNode(pos.x, pos.y));
        
        // Add Edges with weights
        const connections = [
            [0,1, 4], [0,5, 2], [1,2, 5], [2,3, 10], [3,4, 3], [4,5, 8], [0,3, 6], [1,4, 1]
        ];
        
        connections.forEach(quartet => {
            const u = quartet[0];
            const v = quartet[1];
            const w = quartet[2];
            
            edges.push({u, v, w});
            const n1 = nodes[u];
            const n2 = nodes[v];
            
            const len = Math.hypot(n2.x - n1.x, n2.y - n1.y);
            const ang = Math.atan2(n2.y - n1.y, n2.x - n1.x) * 180 / Math.PI;
            
            const line = document.createElement('div');
            line.className = 'g-edge';
            line.id = `edge-${u}-${v}`;
            line.style.width = len + 'px';
            line.style.left = n1.x + 'px';
            line.style.top = n1.y + 'px';
            line.style.transform = `rotate(${ang}deg)`;
            
            const lbl = document.createElement('div');
            lbl.className = 'edge-weight';
            lbl.innerText = w;
            lbl.style.left = '50%';
            lbl.style.top = '-15px';
            lbl.style.transform = `translateX(-50%) rotate(${-ang}deg)`;
            
            line.appendChild(lbl);
            canvas.insertBefore(line, canvas.firstChild);
        });
        
        updateTableInitial();
        setStatus("Auto-initialized default graph.");
    }

    // Run Init
    window.onload = () => {
        setTimeout(initGraph, 100); 
    };
</script>
</body>
</html>
