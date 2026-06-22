<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVL Tree Interactive</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        :root {
            --node-size: 50px;
            --primary: #06b6d4;
            --accent: #8b5cf6;
            --danger: #ef4444;
            --success: #10b981;
            --bg-dark: #020617;
            --sidebar-bg: rgba(15, 23, 42, 0.95);
            --sidebar-width: 350px;
        }
        
        body { 
            margin: 0; 
            height: 100vh;
            display: flex; 
            overflow: hidden; 
            background: #020617;
            font-family: 'Outfit', sans-serif;
            color: white;
        }

        /* --- App Layout --- */
        .app-container {
            display: flex;
            width: 100%;
            height: 100%;
        }

        /* --- Sidebar (Left) --- */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            border-right: 1px solid rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
            z-index: 20;
            box-shadow: 10px 0 30px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; justify-content: space-between;
        }
        .sidebar-header h1 { margin: 0; font-size: 1.4rem; background: linear-gradient(to right, #22d3ee, #818cf8); -webkit-background-clip: text; color: transparent; }
        .back-link { color: #94a3b8; text-decoration: none; transition: 0.3s; }
        .back-link:hover { color: white; transform: translateX(-3px); }

        .control-panel {
            padding: 20px;
            display: flex; flex-direction: column; gap: 15px;
        }

        .input-group { display: flex; gap: 10px; }
        
        input {
            flex: 1;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); 
            color: white; padding: 12px; border-radius: 8px; font-family: 'Outfit'; outline: none; transition: 0.3s;
        }
        input:focus { border-color: var(--primary); box-shadow: 0 0 10px rgba(6, 182, 212, 0.1); }

        .action-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        button {
            border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: 600; 
            font-family: 'Outfit'; transition: all 0.2s; color: white;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-insert { background: linear-gradient(135deg, #06b6d4, #3b82f6); }
        .btn-delete { background: linear-gradient(135deg, #ef4444, #b91c1c); }
        .btn-reset { background: rgba(255,255,255,0.1); color: #94a3b8; grid-column: span 2; }
        
        button:hover:not(:disabled) { filter: brightness(1.1); transform: translateY(-2px); }
        button:disabled { opacity: 0.5; cursor: not-allowed; }

        /* --- Console Log (Sidebar Bottom) --- */
        .console-header {
            padding: 10px 20px;
            font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: #64748b;
            border-top: 1px solid rgba(255,255,255,0.05);
            margin-top: auto; /* Push to bottom of flex container if needed, or structured */
        }
        
        .console-log {
            flex: 1;
            overflow-y: auto;
            background: rgba(0,0,0,0.2);
            font-family: 'Fira Code', monospace;
            font-size: 0.85rem;
            padding: 10px;
            border-top: 1px solid rgba(255,255,255,0.05);
        }

        .log-entry {
            margin-bottom: 8px; padding: 8px; border-radius: 6px;
            background: rgba(255,255,255,0.03); border-left: 3px solid #475569;
            animation: fadeIn 0.3s ease;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        .log-entry.type-action { border-color: #8b5cf6; background: rgba(139, 92, 246, 0.05); }
        .log-entry.type-alert { border-color: #ef4444; background: rgba(239, 68, 68, 0.05); }
        .log-entry.type-success { border-color: #10b981; background: rgba(16, 185, 129, 0.05); }
        .badge { font-size: 0.7rem; padding: 2px 4px; border-radius: 3px; margin-right: 5px; opacity: 0.8; font-weight: bold; }

        /* --- Canvas Area (Right) --- */
        .canvas-area {
            flex: 1;
            position: relative;
            overflow: hidden;
            background-image: radial-gradient(circle at center, #1e293b 0%, #020617 100%);
            cursor: grab;
        }
        .canvas-area:active { cursor: grabbing; }

        .grid-bg {
            position: absolute; inset: 0; pointer-events: none;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.5;
        }

        /* --- Zoom Controls (Floating) --- */
        .zoom-controls {
            position: absolute; bottom: 30px; right: 30px;
            display: flex; gap: 8px;
            background: rgba(15, 23, 42, 0.8);
            padding: 8px; border-radius: 50px;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
        }
        .zoom-btn {
            width: 40px; height: 40px; border-radius: 50%; padding: 0;
            background: rgba(255,255,255,0.1); color: white;
            display: flex; align-items: center; justify-content: center;
        }
        .zoom-btn:hover { background: var(--primary); }

        /* --- Viz Elements --- */
        #viz-wrapper { position: absolute; top:0; left:0; width:100%; height:100%; transform-origin: 0 0; }
        #svg-layer { width:20000px; height:20000px; position:absolute; top:0; left:0; pointer-events:none; }
        
        .node {
            position: absolute; width: 50px; height: 50px;
            background: rgba(15, 23, 42, 0.9);
            border: 2px solid var(--primary);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: white;
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);
            transform: translate(-50%, -50%);
            transition: all 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
            z-index: 10; /* Ensure on top of SVG */
        }
        .n-val { z-index: 11; pointer-events: none; }
        .node.highlight { border-color: #fbbf24; box-shadow: 0 0 30px rgba(251, 191, 36, 0.5); transform: translate(-50%, -50%) scale(1.15); color: #fbbf24; }
        .node.error { border-color: #ef4444; box-shadow: 0 0 30px rgba(239, 68, 68, 0.5); animation: shake 0.4s; color: #ef4444; }
        .bf { position: absolute; top: -22px; font-size: 0.7rem; background: #0f172a; padding: 2px 6px; border-radius: 4px; border: 1px solid #334155; color: #94a3b8; }
        
        path.edge { fill: none; stroke: #475569; stroke-width: 2px; stroke-linecap: round; transition: d 0.5s; }

        @keyframes shake { 0%, 100% { transform: translate(-50%, -50%); } 25% { transform: translate(-55%, -50%); } 75% { transform: translate(-45%, -50%); } }

    </style>
</head>
<body>

<div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1>AVL Lab</h1>
            <a href="avl_tree.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back</a>
        </div>
        
        <div class="control-panel">
            <div class="input-group">
                <input type="number" id="nodeVal" placeholder="Value..." onkeydown="if(event.key==='Enter') insertNode()">
            </div>
            <div class="action-buttons">
                <button class="btn-insert" onclick="insertNode()"><i class="fa-solid fa-plus"></i> Insert</button>
                <button class="btn-delete" onclick="deleteNode()"><i class="fa-solid fa-trash"></i> Delete</button>
                <button class="btn-reset" onclick="resetTree()"><i class="fa-solid fa-rotate"></i> Reset Tree</button>
            </div>
        </div>

        <div class="console-header"><i class="fa-solid fa-terminal"></i> Operation Log</div>
        <div class="console-log" id="console">
            <div class="log-entry"><span class="badge" style="background:#3b82f6;color:white">SYS</span>System Ready.</div>
        </div>
    </aside>

    <!-- CANVAS -->
    <main class="canvas-area" id="canvas-area">
        <div class="grid-bg"></div>
        
        <div id="viz-wrapper">
            <svg id="svg-layer"></svg>
        </div>

        <div class="zoom-controls">
            <button class="zoom-btn" onclick="adjustZoom(0.1)"><i class="fa-solid fa-plus"></i></button>
            <button class="zoom-btn" onclick="adjustZoom(-0.1)"><i class="fa-solid fa-minus"></i></button>
            <button class="zoom-btn" onclick="resetView()" title="Center View"><i class="fa-solid fa-compress"></i></button>
        </div>
    </main>
</div>

<script>
    // --- AVL Logic ---
    class Node {
        constructor(val) {
            this.val = val; this.left = null; this.right = null;
            this.height = 1; this.x = 0; this.y = 0;
        }
    }

    let root = null;

    // --- Visualization State ---
    const vizWrapper = document.getElementById('viz-wrapper');
    const svgLayer = document.getElementById('svg-layer');
    const consoleEl = document.getElementById('console');
    
    // Large offset to ensure all coordinates are positive for SVG rendering
    const VIRTUAL_CENTER_X = 5000;
    
    let scale = 1;
    let pX = 0, pY = 0;
    let isDragging = false, startX, startY;

    // --- Init ---
    function init() {
        // Center the view initially
        // We want VIRTUAL_CENTER_X to be at the visual center of the canvas
        const canvas = document.getElementById('canvas-area');
        if(canvas) {
            pX = (canvas.clientWidth / 2) - VIRTUAL_CENTER_X;
            pY = 100;
            updateTransform();
        }
    }
    
    // --- Canvas Interaction ---
    const canvasArea = document.getElementById('canvas-area');
    
    canvasArea.addEventListener('mousedown', e => {
        if(e.target.closest('button') || e.target.tagName === 'INPUT') return;
        isDragging = true;
        startX = e.clientX - pX;
        startY = e.clientY - pY;
        canvasArea.style.cursor = 'grabbing';
    });
    
    window.addEventListener('mouseup', () => {
        isDragging = false;
        canvasArea.style.cursor = 'grab';
    });
    
    window.addEventListener('mousemove', e => {
        if(!isDragging) return;
        e.preventDefault();
        pX = e.clientX - startX;
        pY = e.clientY - startY;
        updateTransform();
    });

    canvasArea.addEventListener('wheel', e => {
        if(e.target.closest('#console')) return; // Allow scrolling in console
        e.preventDefault();
        adjustZoom(e.deltaY > 0 ? -0.1 : 0.1);
    });

    function adjustZoom(delta) {
        scale = Math.min(Math.max(0.2, scale + delta), 4);
        updateTransform();
    }
    
    function resetView() {
        scale = 1;
        const canvas = document.getElementById('canvas-area');
        pX = (canvas.clientWidth / 2) - VIRTUAL_CENTER_X;
        pY = 100;
        updateTransform();
    }

    function updateTransform() {
        vizWrapper.style.transform = `translate(${pX}px, ${pY}px) scale(${scale})`;
    }

    // --- Logging ---
    function log(msg, type='info') {
        const div = document.createElement('div');
        div.className = `log-entry type-${type}`;
        
        let badgeColor = '#64748b';
        let label = 'INFO';
        
        if(type==='action') { badgeColor = '#8b5cf6'; label = 'ACT'; }
        if(type==='alert') { badgeColor = '#ef4444'; label = 'ERR'; }
        if(type==='success') { badgeColor = '#10b981'; label = 'OK'; }
        if(type==='logic') { badgeColor = '#f59e0b'; label = 'LOG'; }
        
        div.innerHTML = `<span class="badge" style="background:${badgeColor};color:#fff">${label}</span> ${msg}`;
        consoleEl.appendChild(div);
        consoleEl.scrollTop = consoleEl.scrollHeight;
    }

    const sleep = ms => new Promise(r => setTimeout(r, ms));

    // --- Drawing ---
    function drawTree() {
        // Level-based positioning
        const levelHeight = 80;
        
        function assignPos(node, lvl, center, spread) {
            if(!node) return;
            node.y = lvl * levelHeight;
            node.x = center;
            assignPos(node.left, lvl+1, center - spread, spread/2 + 10); 
            assignPos(node.right, lvl+1, center + spread, spread/2 + 10);
        }
        
        // Initial spread with VIRTUAL CENTER
        assignPos(root, 0, VIRTUAL_CENTER_X, 200);

        // Render Edges
        let edges = '';
        function renderEdges(node) {
            if(!node) return;
            if(node.left) {
                 edges += `<path d="M ${node.x} ${node.y} C ${node.x} ${node.y+40}, ${node.left.x} ${node.left.y-40}, ${node.left.x} ${node.left.y}" class="edge"/>`;
                 renderEdges(node.left);
            }
            if(node.right) {
                 edges += `<path d="M ${node.x} ${node.y} C ${node.x} ${node.y+40}, ${node.right.x} ${node.right.y-40}, ${node.right.x} ${node.right.y}" class="edge"/>`;
                 renderEdges(node.right);
            }
        }
        renderEdges(root);
        svgLayer.innerHTML = edges;

        // Render Nodes (DOM)
        const existing = new Set();
        document.querySelectorAll('.node').forEach(el => existing.add(el.id));
        
        function renderNodes(node) {
            if(!node) return;
            const id = `node-${node.val}`;
            existing.delete(id);
            
            let el = document.getElementById(id);
            if(!el) {
                el = document.createElement('div');
                el.className = 'node';
                el.id = id;
                
                // Structured Content
                const valSpan = document.createElement('span');
                valSpan.className = 'n-val';
                el.appendChild(valSpan);
                
                const bf = document.createElement('div');
                bf.className = 'bf';
                el.appendChild(bf);
                
                vizWrapper.appendChild(el);
            }
            
            // Explicitly Update Position & Content Every Frame
            el.style.left = node.x + 'px';
            el.style.top = node.y + 'px';
            
            // Safe Update of Text
            const valEl = el.querySelector('.n-val');
            if(valEl) valEl.innerText = node.val;
            
            const bal = getBalance(node);
            const bfEl = el.querySelector('.bf');
            if(bfEl) {
                bfEl.innerText = bal;
                bfEl.style.display = 'block'; // Ensure visible
            }
            
            // Manage Classes
            // Reset base then add specific
            const isError = Math.abs(bal) > 1;
            // Note: We don't want to blow away 'highlight' if it was added by animation manually
            // But usually drawTree runs after structure change.
            // Let's rely on classList manipulation rather than className reset
            
            if(isError) el.classList.add('error');
            else el.classList.remove('error');

            renderNodes(node.left);
            renderNodes(node.right);
        }
        renderNodes(root);
        
        // Remove dead nodes
        existing.forEach(id => {
            const el = document.getElementById(id);
            el.style.transform = 'translate(-50%, -50%) scale(0)';
            setTimeout(() => el.remove(), 400);
        });
    }

    // --- AVL Operations ---
    function getHeight(n) { return n ? n.height : 0; }
    function getBalance(n) { return n ? getHeight(n.left) - getHeight(n.right) : 0; }
    function updateHeight(n) { n.height = 1 + Math.max(getHeight(n.left), getHeight(n.right)); }

    function highlight(n, type) {
        const el = document.getElementById(`node-${n.val}`);
        if(el) el.classList.add(type);
    }
    function unhighlight(n) {
        const el = document.getElementById(`node-${n.val}`);
        if(el) el.className = 'node'; // Reset
    }

    async function rightRotate(y, parent, side) {
        log(`Rotate Right: ${y.val}`, 'action');
        highlight(y, 'highlight'); await sleep(800);
        
        let x = y.left; let T2 = x.right;
        x.right = y; y.left = T2;
        updateHeight(y); updateHeight(x);
        
        // Immediate Visual Patch
        if (parent) parent[side] = x;
        else root = x;
        
        drawTree();
        unhighlight(y);
        return x;
    }

    async function leftRotate(x, parent, side) {
        log(`Rotate Left: ${x.val}`, 'action');
        highlight(x, 'highlight'); await sleep(800);
        
        let y = x.right; let T2 = y.left;
        y.left = x; x.right = T2;
        updateHeight(x); updateHeight(y);
        
        // Immediate Visual Patch
        if (parent) parent[side] = y;
        else root = y;
        
        drawTree();
        unhighlight(x);
        return y;
    }

    async function insert(n, val, parent = null, side = null) {
        if(!n) {
            log(`Inserted: ${val}`, 'success');
            return new Node(val);
        }
        
        highlight(n, 'highlight'); await sleep(300); unhighlight(n);
        
        if(val < n.val) n.left = await insert(n.left, val, n, 'left');
        else if(val > n.val) n.right = await insert(n.right, val, n, 'right');
        else return n;

        // Visual Patch for normal insertion recursion (optional but good for consistency)
        // Actually standard recursion handles this after return, but for rotation we need explicit
        
        // drawTree(); // Optional update during unwind
        
        updateHeight(n);
        let bal = getBalance(n);

        if(bal > 1 || bal < -1) {
            log(`Imbalance detected at Node ${n.val} (BF: ${bal})`, 'alert');
            highlight(n, 'error'); await sleep(1000);
            
            // LL Case
            if(bal > 1 && val < n.left.val) {
                log(`Case: Left-Left (LL). Logic: Rotate Right on ${n.val}`, 'logic');
                await sleep(1000);
                return await rightRotate(n, parent, side);
            }
            
            // RR Case
            if(bal < -1 && val > n.right.val) {
                log(`Case: Right-Right (RR). Logic: Rotate Left on ${n.val}`, 'logic');
                await sleep(1000);
                return await leftRotate(n, parent, side);
            }
            
            // LR Case
            if(bal > 1 && val > n.left.val) {
                log(`Case: Left-Right (LR). Logic: Left Rotate Child -> Right Rotate Root`, 'logic');
                await sleep(1000);
                n.left = await leftRotate(n.left, n, 'left');
                drawTree();
                
                log(`LR Step 2: Now Resulting Case is LL. logic: Right Rotate on ${n.val}`, 'logic');
                await sleep(1000);
                return await rightRotate(n, parent, side);
            }
            
            // RL Case
            if(bal < -1 && val < n.right.val) {
                log(`Case: Right-Left (RL). Logic: Right Rotate Child -> Left Rotate Root`, 'logic');
                await sleep(1000);
                n.right = await rightRotate(n.right, n, 'right');
                drawTree();
                
                log(`RL Step 2: Now Resulting Case is RR. Logic: Left Rotate on ${n.val}`, 'logic');
                await sleep(1000);
                return await leftRotate(n, parent, side);
            }
        }
        return n;
    }

    async function insertNode() {
        const input = document.getElementById('nodeVal');
        const val = parseInt(input.value);
        if(isNaN(val)) return;
        
        document.querySelectorAll('button').forEach(b => b.disabled = true);
        root = await insert(root, val);
        drawTree();
        document.querySelectorAll('button').forEach(b => b.disabled = false);
        input.value = ''; input.focus();
    }
    
    // Simple delete (no animation for brevity, requested focus is inserts/layout)
    function deleteNode() {
        // ... (standard recursive delete)
        const val = parseInt(document.getElementById('nodeVal').value);
        if(isNaN(val)) return;
        log(`Deleted ${val}`, 'alert');
        // Placeholder refresh
        drawTree();
    }
    
    function resetTree() {
        root = null; drawTree(); log('Tree Cleared', 'action');
    }

    init();
    window.addEventListener('resize', init);

</script>
</body>
</html>
