<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MST Visualization (Prim's & Kruskal's) - Ultimate DSA</title>
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
        }

        #graphCanvas {
            width: 100%;
            height: 450px;
            background: #0f172a;
            border-radius: 12px;
            cursor: crosshair;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .g-node {
            width: 40px; height: 40px;
            background: #3b82f6; 
            color: white;
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-weight: bold;
            position: absolute;
            z-index: 10;
            border: 2px solid white;
            transition: all 0.3s ease;
        }
        
        /* Set Colors for Kruskal's */
        .g-node[data-set="0"] { background: #ef4444; box-shadow: 0 0 10px #ef4444; }
        .g-node[data-set="1"] { background: #f97316; box-shadow: 0 0 10px #f97316; }
        .g-node[data-set="2"] { background: #f59e0b; box-shadow: 0 0 10px #f59e0b; }
        .g-node[data-set="3"] { background: #84cc16; box-shadow: 0 0 10px #84cc16; }
        .g-node[data-set="4"] { background: #10b981; box-shadow: 0 0 10px #10b981; }
        .g-node[data-set="5"] { background: #06b6d4; box-shadow: 0 0 10px #06b6d4; }
        .g-node[data-set="6"] { background: #3b82f6; box-shadow: 0 0 10px #3b82f6; }
        .g-node[data-set="7"] { background: #6366f1; box-shadow: 0 0 10px #6366f1; }
        .g-node[data-set="8"] { background: #8b5cf6; box-shadow: 0 0 10px #8b5cf6; }
        
        .g-node.in-mst {
             border: 3px solid #fff;
             transform: scale(1.1);
        }

        .g-edge {
            position: absolute;
            background: #64748b;
            height: 2px;
            transform-origin: 0 0;
            z-index: 5;
            transition: all 0.3s ease;
        }
        
        .g-edge.mst-edge { background: #10b981; height: 5px; box-shadow: 0 0 15px #10b981; z-index: 6; }
        .g-edge.checking { background: #f59e0b; height: 4px; z-index: 7; }
        .g-edge.discarded { background: #ef4444; opacity: 0.3; }

        .edge-weight {
            position: absolute;
            background: #1e293b;
            padding: 2px 6px;
            border-radius: 4px;
            color: #fbbf24;
            font-size: 0.8rem;
            border: 1px solid #475569;
        }
        
        .kruskal-list {
            max-height: 300px;
            overflow-y: auto;
            background: rgba(0,0,0,0.2);
            border-radius: 8px;
            padding: 10px;
        }
        .edge-item {
             padding: 5px 10px;
             margin-bottom: 5px;
             background: #334155;
             border-radius: 4px;
             display: flex; justify-content: space-between;
             font-family: 'Fira Code', monospace;
             font-size: 0.9rem;
        }
        .edge-item.active { background: #f59e0b; color: black; font-weight: bold; }
        .edge-item.taken { background: #10b981; color: white; }
        .edge-item.skipped { text-decoration: line-through; opacity: 0.6; }
    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
             <a href="mst.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-bezier-curve"></i> MST Sandbox
            </div>
        </div>

        <header class="header">
            <h1>MST Visualization</h1>
            <p class="subtitle">Compare Prim's and Kruskal's Algorithms</p>
        </header>

        <div class="viz-grid">
            <!-- Left: Graph -->
            <div class="viz-section">
                <div id="graphCanvas" onclick="handleCanvasClick(event)">
                    <div style="position:absolute; top:10px; left:10px; background:rgba(0,0,0,0.6); color:white; padding:5px 10px; border-radius:5px; pointer-events:none;">
                        Mode: <span id="currentMode">Add Node</span>
                    </div>
                </div>
                <div id="statusText" style="text-align:center; margin-top:15px; font-weight:500; min-height:1.2em; font-size:1.1rem; color: #fbbf24;">Ready to Build Graph.</div>
            </div>

            <!-- Right: Controls & Lists -->
            <div class="viz-section">
                 <h3><i class="fa-solid fa-sliders"></i> Algorithm</h3>
                 <div style="margin-bottom: 20px;">
                     <select id="algoSelect" class="form-select" onchange="resetViz()" style="width:100%; padding:10px; background:var(--input-bg); color:white; border:1px solid var(--border-color); border-radius:5px;">
                         <option value="prim">Prim's Algorithm</option>
                         <option value="kruskal">Kruskal's Algorithm</option>
                     </select>
                 </div>
                 
                 <div id="kruskalPanel" style="display:none;">
                     <h4>Sorted Edges</h4>
                     <div class="kruskal-list" id="edgeList">
                         <div style="color:#94a3b8; font-style:italic;">Add edges to see them here...</div>
                     </div>
                 </div>
                 
                 <div id="primPanel">
                     <p style="color:#94a3b8; font-size:0.9rem;">
                         Start from Node 0. Grow the MST by picking the minimum weight edge from visited to unvisited nodes.
                     </p>
                 </div>

                 <hr style="border-color:var(--border-color); margin: 20px 0;">
                 
                 <div class="controls">
                     <div style="display:flex; gap:10px; margin-bottom:10px;">
                         <button class="btn btn-primary" onclick="setMode('node')" style="font-size:0.8rem; flex:1;">+ Node</button>
                         <button class="btn btn-info" onclick="setMode('edge')" style="font-size:0.8rem; flex:1;">+ Edge</button>
                     </div>
                     <button class="btn btn-success" style="width:100%;" onclick="runAlgorithm()">RUN ALGORITHM</button>
                     <button class="btn btn-danger" style="width:100%; margin-top:10px;" onclick="clearGraph()">Reset Graph</button>
                 </div>
            </div>
        </div>
    </div>

    <!-- Custom Weight Modal -->
    <div id="weightModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Set Edge Weight</h3>
            <div class="input-group">
                <input type="number" id="customWeightInput" placeholder="Enter Cost" min="1" value="10" autoselect>
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
            background: #1e293b; border: 1px solid #10b981; /* Green for MST */
            padding: 2rem; border-radius: 15px;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.3);
            text-align: center; transform: scale(0.9); transition: transform 0.3s ease;
            width: 300px;
        }
        .modal-overlay.active .modal-content { transform: scale(1); }
        .modal-content h3 { color: white; margin-bottom: 1.5rem; font-family: 'Inter', sans-serif; }
        .input-group input {
            width: 100%; padding: 15px; font-size: 1.5rem;
            background: #0f172a; border: 2px solid #475569; border-radius: 8px;
            color: #10b981; text-align: center; font-weight: bold;
            outline: none; transition: border-color 0.3s;
        }
        .input-group input:focus { border-color: #10b981; }
        .modal-actions { display: flex; gap: 10px; margin-top: 1.5rem; }
        .modal-actions button { flex: 1; padding: 10px; border-radius: 8px; cursor: pointer; border: none; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #10b981, #059669); color: white; }
        .btn-secondary { background: #475569; color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4); }
    </style>

<script>
    let nodes = [];
    let edges = [];
    let mode = 'node';
    let selectedNode = null;
    let isRunning = false;
    const canvas = document.getElementById('graphCanvas');

    function setMode(m) {
        mode = m;
        selectedNode = null;
        document.getElementById('currentMode').innerText = m === 'node' ? 'Add Node' : 'Add Edge';
    }

    function handleCanvasClick(e) {
        if(isRunning) return;
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        if (mode === 'node') addNode(x, y);
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
    }

    function nodeClick(id) {
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

    async function addEdge(u, v) {
        // Prevent duplicate edges
        if(edges.some(e => (e.u === u && e.v === v) || (e.u === v && e.v === u))) return;
        
        // Use Custom Modal
        const w = await getCustomWeight(u, v);
        if(w === null) return;
        
        const edgeId = edges.length;
        edges.push({id: edgeId, u, v, w});
        
        const n1 = nodes[u];
        const n2 = nodes[v];
        const len = Math.hypot(n2.x - n1.x, n2.y - n1.y);
        const ang = Math.atan2(n2.y - n1.y, n2.x - n1.x) * 180 / Math.PI;
        
        const line = document.createElement('div');
        line.className = 'g-edge';
        line.id = `edge-${edgeId}`;
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
        
        updateEdgeList();
    }
    
    // Modal Logic
    function getCustomWeight(u, v) {
        return new Promise(resolve => {
            const modal = document.getElementById('weightModal');
            const input = document.getElementById('customWeightInput');
            modal.classList.add('active');
            input.value = 10;
            input.focus();
            input.select();
            
            window.confirmWeight = () => {
                const val = parseInt(input.value);
                closeModal(val > 0 ? val : 1);
            };
            window.closeModal = (val) => {
                modal.classList.remove('active');
                resolve(val);
            };
            input.onkeydown = (e) => {
                if(e.key === 'Enter') confirmWeight();
                if(e.key === 'Escape') closeModal(null);
            };
        });
    }
    
    function updateEdgeList() {
        const list = document.getElementById('edgeList');
        if(edges.length === 0) { list.innerHTML = '<div style="color:#94a3b8;">No edges...</div>'; return; }
        
        // Show unsorted list briefly or just refresh
        // For Kruskal's, we really care about the sorted view during execution
        let html = '';
        let sorted = [...edges].sort((a,b) => a.w - b.w);
        sorted.forEach(e => {
            html += `<div class="edge-item" id="list-edge-${e.id}">
                        <span>${e.u} ↔ ${e.v}</span>
                        <span>Weights: ${e.w}</span>
                     </div>`;
        });
        list.innerHTML = html;
    }

    document.getElementById('algoSelect').addEventListener('change', function() {
        const val = this.value;
        document.getElementById('primPanel').style.display = val === 'prim' ? 'block' : 'none';
        document.getElementById('kruskalPanel').style.display = val === 'kruskal' ? 'block' : 'none';
        resetViz();
    });

    async function runAlgorithm() {
        if(nodes.length === 0 || isRunning) return;
        isRunning = true;
        resetViz(); // Clear previous runs visuals only
        
        const algo = document.getElementById('algoSelect').value;
        if(algo === 'prim') await runPrims();
        else await runKruskal();
        
        isRunning = false;
    }

    async function runPrims() {
        setStatus("Starting Prim's Algorithm from Node 0...");
        let visited = new Set();
        visited.add(0);
        document.getElementById(`node-0`).classList.add('in-mst');
        
        await delay(1000);
        
        while(visited.size < nodes.length) {
            let minEdge = null;
            let minWeight = Infinity;
            
            // Find Cut Edge
            for(let e of edges) {
                let uIn = visited.has(e.u);
                let vIn = visited.has(e.v);
                
                if((uIn && !vIn) || (!uIn && vIn)) {
                    if(e.w < minWeight) {
                        minWeight = e.w;
                        minEdge = e; 
                    }
                }
            }
            
            if(!minEdge) break;
            
            // Add to MST
            const target = visited.has(minEdge.u) ? minEdge.v : minEdge.u;
            visited.add(target);
            
            highlightEdge(minEdge.id, 'mst-edge');
            document.getElementById(`node-${target}`).classList.add('in-mst');
            setStatus(`Added Edge ${minEdge.u}-${minEdge.v} (Weight: ${minEdge.w})`);
            await delay(1000);
        }
        setStatus("Prim's MST Complete!");
    }

    async function runKruskal() {
        setStatus("Sorting edges by weight...");
        let sortedEdges = [...edges].sort((a,b) => a.w - b.w);
        
        // Initialize Sets (Quick Union-Find)
        let parent = new Array(nodes.length).fill(0).map((_, i) => i);
        // Visual: Color each node differently
        nodes.forEach((n, i) => {
            document.getElementById(`node-${n.id}`).dataset.set = i % 9;
        });
        
        await delay(1000);
        
        function find(i) {
            if(parent[i] === i) return i;
            return find(parent[i]);
        }
        
        function union(i, j) {
            let rootI = find(i);
            let rootJ = find(j);
            if(rootI !== rootJ) {
                parent[rootI] = rootJ;
                return true;
            }
            return false;
        }

        let edgeCount = 0;
        
        for(let e of sortedEdges) {
            // Highlight in list
            document.querySelectorAll('.edge-item').forEach(el => el.classList.remove('active'));
            document.getElementById(`list-edge-${e.id}`).classList.add('active');
            
            setStatus(`Checking Edge ${e.u}-${e.v} (Weight: ${e.w})`);
            highlightEdge(e.id, 'checking');
            await delay(800);
            
            let rootU = find(e.u);
            let rootV = find(e.v);
            
            if(rootU !== rootV) {
                union(e.u, e.v);
                highlightEdge(e.id, 'mst-edge');
                document.getElementById(`list-edge-${e.id}`).classList.add('taken');
                setStatus(`No Cycle! Adding Edge ${e.u}-${e.v}`);
                
                // Merge Colors visually
                let newRoot = find(e.u); // After union, they share a root
                let color = newRoot % 9;
                
                // Update all nodes in this component set
                for(let i=0; i<nodes.length; i++) {
                    if(find(i) === newRoot) {
                        document.getElementById(`node-${i}`).dataset.set = color;
                    }
                }
                
                edgeCount++;
            } else {
                highlightEdge(e.id, 'discarded');
                document.getElementById(`list-edge-${e.id}`).classList.add('skipped');
                setStatus(`Cycle detected! Discarding ${e.u}-${e.v}`);
            }
            
            await delay(800);
            // Remove 'checking' class if not taken (if taken, it has mst-edge)
            document.getElementById(`edge-${e.id}`).classList.remove('checking');
        }
        
        setStatus("Kruskal's MST Complete!");
    }

    function highlightEdge(id, cls) {
        document.getElementById(`edge-${id}`).classList.add(cls);
    }

    function resetViz() {
        document.querySelectorAll('.g-node').forEach(el => {
            el.classList.remove('in-mst');
            delete el.dataset.set;
            el.style.background = ''; // clear explicit style
        });
        document.querySelectorAll('.g-edge').forEach(el => {
            el.className = 'g-edge'; // remove all extra classes
        });
        document.querySelectorAll('.edge-item').forEach(el => {
            el.className = 'edge-item';
        });
    }

    function clearGraph() {
        if(isRunning) return;
        nodes = []; edges = [];
        canvas.innerHTML = '<div style="position:absolute; top:10px; left:10px; background:rgba(0,0,0,0.6); color:white; padding:5px 10px; border-radius:5px; pointer-events:none;">Mode: <span id="currentMode">Add Node</span></div>';
        updateEdgeList();
    }
    
    function setStatus(msg) { document.getElementById('statusText').innerText = msg; }
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
            
            const edgeId = edges.length;
            edges.push({id: edgeId, u, v, w});
            
            const n1 = nodes[u];
            const n2 = nodes[v];
            const len = Math.hypot(n2.x - n1.x, n2.y - n1.y);
            const ang = Math.atan2(n2.y - n1.y, n2.x - n1.x) * 180 / Math.PI;
            
            const line = document.createElement('div');
            line.className = 'g-edge';
            line.id = `edge-${edgeId}`;
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
        
        updateEdgeList();
        setStatus("Auto-initialized default graph.");
    }

    // Run Init
    window.onload = () => {
        setTimeout(initGraph, 100); 
    };
</script>
</body>
</html>
