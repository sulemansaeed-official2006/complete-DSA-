<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph Simulation (BFS/DFS) - Ultimate DSA</title>
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
            min-height: 550px;
            position: relative;
            user-select: none;
        }

        #graphCanvas {
            width: 100%;
            height: 450px;
            position: relative;
            background: #0f172a; /* Darker bg for contrast */
            border-radius: 12px;
            cursor: crosshair;
            overflow: hidden;
        }

        .g-node {
            width: 45px; height: 45px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-weight: bold;
            font-size: 1rem;
            position: absolute;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            z-index: 10;
            cursor: pointer;
            border: 2px solid white;
        }

        .g-node:hover { transform: scale(1.1); }

        .g-edge {
            position: absolute;
            background: #64748b;
            height: 3px;
            transform-origin: 0 0;
            z-index: 5;
            transition: background 0.3s ease;
        }
        
        /* Visited / Active Styles */
        .node-visited {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            box-shadow: 0 0 15px #10b981;
            transform: scale(1.15);
        }
        
        .node-current {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
            box-shadow: 0 0 20px #f59e0b;
            transform: scale(1.25);
            z-index: 15;
        }

        .edge-visited {
            background: #10b981;
            height: 4px;
        }

        .controls-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .panel { background: var(--card-bg); padding: 2rem; border-radius: 20px; border: 1px solid var(--border-color); }
        .panel h3 { color: var(--accent-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
        
        /* Stack/Queue Viz Area */
        .struct-viz {
            display: flex; gap: 5px; margin-top: 15px;
            min-height: 40px; padding: 5px;
            background: rgba(0,0,0,0.2); border-radius: 8px;
            overflow-x: auto;
        }
        .struct-item {
            padding: 5px 10px; background: #475569; color: white;
            border-radius: 4px; font-family: 'Fira Code', monospace;
            animation: fadeIn 0.3s ease;
        }
        
        .mode-badge {
            position: absolute; top: 10px; left: 10px;
            padding: 5px 10px; background: rgba(0,0,0,0.5);
            color: white; border-radius: 5px; font-size: 0.8rem; pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
             <a href="graph.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-share-nodes"></i> Graph Algorithms
            </div>
        </div>

        <header class="header">
            <h1>Graph Sandbox</h1>
            <p class="subtitle">Draw Nodes, Connect Edges, and Watch Traversals!</p>
        </header>

        <div class="viz-section">
            <div id="graphCanvas" onclick="handleCanvasClick(event)">
                <div class="mode-badge">Mode: <span id="currentMode">Add Node</span></div>
            </div>
             <div id="statusText" style="margin-top: 10px; font-size: 1.2rem; color: var(--text-primary); font-weight: 500; min-height: 1.5em; text-align:center;">
                Click on canvas to add nodes...
            </div>
        </div>

        <div class="controls-grid">
            <div class="panel">
                <h3><i class="fa-solid fa-sliders"></i> Controls</h3>
                
                <div style="margin-bottom: 20px;">
                    <label style="color:var(--text-secondary); display:block; margin-bottom:10px;">Edit Mode:</label>
                    <div style="display:flex; gap:10px;">
                        <button class="btn btn-primary" onclick="setMode('node')"><i class="fa-solid fa-circle-plus"></i> Add Node</button>
                        <button class="btn btn-info" onclick="setMode('edge')"><i class="fa-solid fa-link"></i> Add Edge</button>
                    </div>
                </div>
                
                <div style="margin-bottom: 20px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                    <label style="color:var(--text-secondary); display:block; margin-bottom:10px;">Traversals (Start from Node 0):</label>
                    <div style="display:flex; gap:10px;">
                        <button class="btn btn-success" onclick="startBFS()">Run BFS</button>
                        <button class="btn btn-warning" onclick="startDFS()">Run DFS</button>
                    </div>
                </div>

                <button class="btn btn-danger" style="width:100%;" onclick="clearGraph()">Clear Graph</button>
            </div>

            <div class="panel">
                <h3><i class="fa-solid fa-list-ol"></i> Traversal Result</h3>
                <div id="resultBox" style="margin-bottom: 20px; padding: 15px; background: rgba(0,0,0,0.2); border-radius: 8px; font-family: 'Fira Code', monospace; min-height: 50px; color: #fbbf24; overflow-wrap: break-word;">
                    <span style="color:#94a3b8; font-style:italic;">Run algorithm to see path...</span>
                </div>

                 <h3><i class="fa-solid fa-memory"></i> Memory View</h3>
                 <div style="margin-bottom: 15px;">
                     <label style="color:var(--text-secondary);">Structure Content (Queue/Stack):</label>
                     <div class="struct-viz" id="structViz"></div>
                 </div>
                 
                 <h3><i class="fa-solid fa-terminal"></i> Log</h3>
                 <div class="operation-log" id="logBox" style="height: 150px; margin-bottom: 20px;">
                    <div class="log-entry log-info">Ready. Click to add nodes.</div>
                 </div>
            </div>
        </div>
    </div>

    <!-- Custom Weight Modal -->
    <div id="weightModal" class="modal-overlay">
        <div class="modal-content">
            <h3>Set Edge Weight</h3>
            <div class="input-group">
                <input type="number" id="customWeightInput" placeholder="Enter Weight" value="1" autoselect>
            </div>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeModal(null)">Cancel</button>
                <button class="btn btn-primary" onclick="confirmWeight()">Set Weight</button>
            </div>
            <p style="margin-top:10px; font-size:0.8rem; color:#94a3b8;">(For Unweighted Graph, keep as 1)</p>
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
    let mode = 'node'; // node, edge
    let selectedNode = null;
    let isRunning = false;

    const canvas = document.getElementById('graphCanvas');

    function setMode(m) {
        mode = m;
        selectedNode = null;
        document.getElementById('currentMode').innerText = (m === 'node') ? 'Add Node (Click)' : 'Add Edge (Click Source then Dest)';
        log(`Switched to ${m === 'node' ? 'Node Addition' : 'Edge Connection'} mode.`);
    }

    function handleCanvasClick(e) {
        if(isRunning) return;
        
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if(mode === 'node') {
            // Check collision
            for(let n of nodes) {
                if(Math.hypot(n.x - x, n.y - y) < 50) return; // Too close
            }
            if(x < 25 || x > rect.width-25 || y < 25 || y > rect.height-25) return; // Out of bounds

            addNode(x, y);
        }
    }

    function addNode(x, y) {
        const id = nodes.length;
        const node = { id, x, y };
        nodes.push(node);
        
        const nDiv = document.createElement('div');
        nDiv.className = 'g-node';
        nDiv.innerText = id;
        nDiv.id = `node-${id}`;
        nDiv.style.left = (x - 22.5) + 'px';
        nDiv.style.top = (y - 22.5) + 'px';
        
        nDiv.onclick = (e) => {
            e.stopPropagation();
            handleNodeClick(node);
        };
        
        canvas.appendChild(nDiv);
        log(`Added Node ${id}`);
    }

    function handleNodeClick(node) {
        if(mode !== 'edge' || isRunning) return;
        
        if(!selectedNode) {
            selectedNode = node;
            document.getElementById(`node-${node.id}`).style.borderColor = '#f59e0b'; // Highlight selected
            log(`Selected Node ${node.id}. Click another to connect.`);
        } else {
            if(selectedNode.id !== node.id) {
                addEdge(selectedNode, node);
            }
            document.getElementById(`node-${selectedNode.id}`).style.borderColor = 'white';
            selectedNode = null;
        }
    }

    async function addEdge(n1, n2) {
        // Check duplicate
        if(edges.some(e => (e.u === n1.id && e.v === n2.id) || (e.u === n2.id && e.v === n1.id))) return;
        
        // Use Custom Modal
        const weight = await getCustomWeight(n1.id, n2.id);
        if(weight === null) return; // Cancelled
        
        edges.push({u: n1.id, v: n2.id, w: weight});
        drawEdge(n1.x, n1.y, n2.x, n2.y, n1.id, n2.id, weight);
        log(`Connected Node ${n1.id} <--> Node ${n2.id} (Weight: ${weight})`);
    }

    // Modal Logic
    function getCustomWeight(u, v) {
        return new Promise(resolve => {
            const modal = document.getElementById('weightModal');
            const input = document.getElementById('customWeightInput');
            modal.classList.add('active');
            input.value = 1; // Default to 1 for generic graph
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

    function drawEdge(x1, y1, x2, y2, u, v, w) {
        const len = Math.hypot(x2-x1, y2-y1);
        const ang = Math.atan2(y2-y1, x2-x1) * 180 / Math.PI;
        
        const edge = document.createElement('div');
        edge.className = 'g-edge';
        edge.id = `edge-${u}-${v}`;
        edge.style.width = len + 'px';
        edge.style.left = x1 + 'px';
        edge.style.top = y1 + 'px';
        edge.style.transform = `rotate(${ang}deg)`;
        
        // Weight Label
        const label = document.createElement('div');
        label.innerText = w;
        label.className = 'edge-weight';
        label.style.position = 'absolute';
        label.style.left = '50%';
        label.style.top = '-15px';
        label.style.transform = `translateX(-50%) rotate(${-ang}deg)`; // Counter-rotate text
        label.style.background = '#1e293b';
        label.style.padding = '0 5px';
        label.style.borderRadius = '4px';
        label.style.fontSize = '0.8rem';
        label.style.color = '#fbbf24';
        
        edge.appendChild(label);
        
        // Insert before nodes so it's behind
        canvas.insertBefore(edge, canvas.firstChild);
    }
    
    function highlightEdge(u, v) {
        let el = document.getElementById(`edge-${u}-${v}`);
        if(!el) el = document.getElementById(`edge-${v}-${u}`);
        if(el) el.classList.add('edge-visited');
    }

    async function startBFS() {
        if(nodes.length === 0 || isRunning) return;
        isRunning = true;
        resetViz();
        
        const startNode = 0;
        let queue = [startNode];
        let visited = new Set();
        visited.add(startNode);
        
        let path = [];
        updateResult(path);
        
        log(`Starting BFS from Node ${startNode}...`);
        
        while(queue.length > 0) {
            updateStructViz(queue, 'Queue');
            
            const u = queue.shift();
            
            // Add to Path
            path.push(u);
            updateResult(path);

            // Highlight Current
            document.getElementById(`node-${u}`).classList.add('node-current');
            document.getElementById('statusText').innerText = `Visiting Node ${u}`;
            await new Promise(r => setTimeout(r, 800));
            
            // Mark Visited PERMANENTLY
            document.getElementById(`node-${u}`).classList.remove('node-current');
            document.getElementById(`node-${u}`).classList.add('node-visited');
            
            // Get Neighbors
            let neighbors = [];
            edges.forEach(e => {
                if(e.u === u && !visited.has(e.v)) neighbors.push(e.v);
                if(e.v === u && !visited.has(e.u)) neighbors.push(e.u);
            });
            neighbors.sort(); // Consistent order
            
            for(let v of neighbors) {
                if(!visited.has(v)) {
                    visited.add(v);
                    queue.push(v);
                    highlightEdge(u, v);
                    log(`Discovered Node ${v} (Neighbor of ${u})`);
                    await new Promise(r => setTimeout(r, 400));
                }
            }
        }
        
        updateStructViz([], 'Queue (Empty)');
        document.getElementById('statusText').innerText = "BFS Complete!";
        log("BFS Traversal Finished.", "success");
        isRunning = false;
    }

    async function startDFS() {
        if(nodes.length === 0 || isRunning) return;
        isRunning = true;
        resetViz();
        
        const startNode = 0;
        let stack = [startNode];
        let visited = new Set();
        
        let path = [];
        updateResult(path);
        
        log(`Starting DFS from Node ${startNode}...`);
        
        while(stack.length > 0) {
            updateStructViz(stack, 'Stack');
            
            const u = stack.pop(); // Pop current
             
            if(!visited.has(u)) {
                visited.add(u);
                
                // Add to Path
                path.push(u);
                updateResult(path);
                
                 // Highlight Current
                document.getElementById(`node-${u}`).classList.add('node-current');
                document.getElementById('statusText').innerText = `Visiting Node ${u}`;
                await new Promise(r => setTimeout(r, 800));
                
                document.getElementById(`node-${u}`).classList.remove('node-current');
                document.getElementById(`node-${u}`).classList.add('node-visited');
            
                // Get Neighbors
                let neighbors = [];
                edges.forEach(e => {
                    if(e.u === u && !visited.has(e.v)) neighbors.push(e.v);
                    if(e.v === u && !visited.has(e.u)) neighbors.push(e.u);
                });
                neighbors.sort((a,b) => b-a); // Reverse sort for Stack so lower ID pops first
                
                for(let v of neighbors) {
                     if(!visited.has(v)) {
                        stack.push(v);
                        highlightEdge(u, v);
                     }
                }
            }
        }
        
        updateStructViz([], 'Stack (Empty)');
        document.getElementById('statusText').innerText = "DFS Complete!";
        log("DFS Traversal Finished.", "success");
        isRunning = false;
    }

    function resetViz() {
        document.querySelectorAll('.g-node').forEach(el => {
            el.classList.remove('node-visited');
            el.classList.remove('node-current');
        });
        document.querySelectorAll('.g-edge').forEach(el => el.classList.remove('edge-visited'));
        document.getElementById('resultBox').innerHTML = '<span style="color:#94a3b8; font-style:italic;">Run algorithm to see path...</span>';
    }
    
    function updateResult(path) {
        const box = document.getElementById('resultBox');
        if(path.length === 0) {
            box.innerHTML = '<span style="color:#94a3b8; font-style:italic;">Starting...</span>';
            return;
        }
        box.innerHTML = path.join(' <i class="fa-solid fa-arrow-right" style="font-size:0.7rem; color:#64748b; margin:0 5px;"></i> ');
    }

    function updateStructViz(arr, label) {
        const con = document.getElementById('structViz');
        con.innerHTML = '';
        arr.forEach(val => {
            const div = document.createElement('div');
            div.className = 'struct-item';
            div.innerText = val;
            con.appendChild(div);
        });
        if(arr.length === 0) con.innerHTML = `<span style="color:#94a3b8; font-style:italic;">${label} is empty</span>`;
    }

    function clearGraph() {
        if(isRunning) return;
        nodes = [];
        edges = [];
        canvas.innerHTML = '<div class="mode-badge">Mode: <span id="currentMode">' + (mode === 'node' ? 'Add Node' : 'Add Edge') + '</span></div>';
        log("Graph cleared.");
    }

    function log(msg, type='info') {
        const box = document.getElementById('logBox');
        box.innerHTML += `<div class="log-entry log-${type}">[${new Date().toLocaleTimeString()}] ${msg}</div>`;
        box.scrollTop = box.scrollHeight;
    }

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
        
        // Add Edges (0 is center-ish top)
        // 0 -> 1, 0 -> 5
        // 1 -> 2
        // 2 -> 3
        // 3 -> 4
        // 4 -> 5
        // 0 -> 3 (cross)
        // 1 -> 4 (cross)
        
        const connections = [
            [0,1], [0,5], [1,2], [2,3], [3,4], [4,5], [0,3], [1,4]
        ];
        
        // We need to bypass the "click to add edge" logic and directly interact with data
        connections.forEach(pair => {
            const u = pair[0];
            const v = pair[1];
            // Mock node objects since addEdge expects objects in current implementation or we can just push directly
            // However, addEdge function handles drawing. 
            // Better to wrap the drawing logic:
            
            // Direct push to bypass modal/checks if we want fast init, OR just use the internal logic
            edges.push({u, v, w: 1});
            const n1 = nodes[u];
            const n2 = nodes[v];
            drawEdge(n1.x, n1.y, n2.x, n2.y, n1.id, n2.id, 1);
        });
        
        log("Auto-initialized default graph.", "success");
    }

    // Run Init
    window.onload = () => {
        setTimeout(initGraph, 100); // Small delay to ensure layout
    };
</script>
</body>
</html>
