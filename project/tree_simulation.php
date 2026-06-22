<?php
session_start();
include 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Search Tree Simulation - Ultimate DSA</title>
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
            min-height: 500px;
            position: relative;
            overflow: hidden;
        }

        #treeCanvas {
            width: 100%;
            height: 450px;
            position: relative;
        }

        .tree-node {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-weight: bold;
            position: absolute;
            transition: all 0.5s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 10;
        }

        .tree-edge {
            position: absolute;
            background: #94a3b8;
            height: 2px;
            transform-origin: 0 0;
            z-index: 5;
            transition: all 0.5s ease;
        }

        .node-highlight {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            transform: scale(1.2);
            box-shadow: 0 0 20px #f59e0b;
        }
        
        .node-found {
            background: linear-gradient(135deg, #10b981, #059669);
            transform: scale(1.2);
            box-shadow: 0 0 20px #10b981;
        }

        .controls-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .panel { background: var(--card-bg); padding: 2rem; border-radius: 20px; border: 1px solid var(--border-color); }
        .panel h3 { color: var(--accent-color); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px; }
        
        .wrapper { display: flex; gap: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="sim-container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem; align-items:center;">
             <a href="tree.php" class="back-link" style="color:var(--text-secondary); text-decoration:none; display:flex; align-items:center; gap:5px; transition:0.3s;">
                <i class="fa-solid fa-arrow-left"></i> Back to Theory
            </a>
            <div style="font-weight:700; color:var(--text-primary);">
                <i class="fa-solid fa-network-wired"></i> Binary Search Tree (BST)
            </div>
        </div>

        <header class="header">
            <h1>BST Playground</h1>
            <p class="subtitle">Build, Search, and Traverse your own Tree!</p>
        </header>

        <div class="viz-section">
            <div id="treeCanvas"></div>
             <div id="statusText" style="margin-top: 10px; font-size: 1.2rem; color: var(--text-primary); font-weight: 500; min-height: 1.5em; text-align:center;">
                Ready to build...
            </div>
        </div>

        <div class="controls-grid">
            <div class="panel">
                <h3><i class="fa-solid fa-sliders"></i> Operations</h3>
                
                <div class="wrapper">
                    <input type="number" id="nodeVal" placeholder="Value" class="value-input" style="width: 100px;">
                    <button class="btn btn-primary" onclick="insertNode()">Insert</button>
                    <button class="btn btn-danger" onclick="deleteNode()">Delete</button>
                    <button class="btn btn-info" onclick="searchNode()">Search</button>
                </div>
                
                <div style="margin-top: 20px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                    <label style="color: var(--text-secondary);">Traversals:</label>
                    <div class="wrapper" style="margin-top: 10px;">
                        <button class="btn" style="background:#4b5563; color:white;" onclick="traverse('inorder')">Inorder</button>
                        <button class="btn" style="background:#4b5563; color:white;" onclick="traverse('preorder')">Preorder</button>
                        <button class="btn" style="background:#4b5563; color:white;" onclick="traverse('postorder')">Postorder</button>
                    </div>
                </div>

                <div style="margin-top: 20px;">
                    <button class="btn btn-danger" style="width:100%;" onclick="clearTree()">Clear Tree</button>
                    <button class="btn btn-primary" style="width:100%; margin-top: 10px;" onclick="generateRandomTree()">Generate Random Tree</button>
                </div>
            </div>

            <div class="panel">
                 <h3><i class="fa-solid fa-code"></i> Log & Code</h3>
                 <div class="operation-log" id="logBox" style="height: 150px; margin-bottom: 20px;">
                    <div class="log-entry log-info">System Ready.</div>
                 </div>
                 
                 <div class="mac-window">
                     <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title" id="codeTitle">operation.cpp</span>
                     </div>
                     <div class="code-content" id="codeDisplay" style="display:block;">
<pre><code class="cpp">Node* insert(Node* root, int val) {
    if (!root) return new Node(val);
    if (val < root->data)
        root->left = insert(root->left, val);
    else
        root->right = insert(root->right, val);
    return root;
}</code></pre>
                     </div>
                 </div>
            </div>
        </div>
    </div>

<script>
    // BST Implementation
    class Node {
        constructor(value) {
            this.value = value;
            this.left = null;
            this.right = null;
            this.x = 0;
            this.y = 0;
        }
    }

    class BST {
        constructor() {
            this.root = null;
        }

        insert(value) {
            const newNode = new Node(value);
            if (!this.root) {
                this.root = newNode;
                return true;
            }
            let current = this.root;
            while (true) {
                if (value === current.value) return false;
                if (value < current.value) {
                    if (!current.left) {
                        current.left = newNode;
                        return true;
                    }
                    current = current.left;
                } else {
                    if (!current.right) {
                        current.right = newNode;
                        return true;
                    }
                    current = current.right;
                }
            }
        }
        
        // Simple Delete for now (visualizing complex delete is hard, simplifying to leaf/one child if possible or just standard)
        delete(value) {
            this.root = this.deleteNode(this.root, value);
        }

        deleteNode(root, value) {
            if (root === null) return null;
            if (value < root.value) root.left = this.deleteNode(root.left, value);
            else if (value > root.value) root.right = this.deleteNode(root.right, value);
            else {
                if (!root.left && !root.right) return null;
                if (!root.left) return root.right;
                if (!root.right) return root.left;
                let temp = this.findMin(root.right);
                root.value = temp.value;
                root.right = this.deleteNode(root.right, temp.value);
            }
            return root;
        }

        findMin(node) {
            while (node.left) node = node.left;
            return node;
        }
    }

    const bst = new BST();
    const canvas = document.getElementById('treeCanvas');
    let isBusy = false;

    // Visualization Config
    const LEVEL_HEIGHT = 70;
    
    function drawTree() {
        canvas.innerHTML = '';
        if(!bst.root) return;
        
        // BFS to assign positions
        const queue = [{node: bst.root, x: canvas.clientWidth / 2, y: 30, range: canvas.clientWidth / 2}];
        // Reset positions for redrawing
        // Note: Simple static drawing for now. Animated insert follows path.
        
        // Recursive draw
        drawNodeRecursive(bst.root, canvas.clientWidth / 2, 40, canvas.clientWidth / 4);
    }

    function drawNodeRecursive(node, x, y, offset) {
        if (!node) return;
        
        node.x = x;
        node.y = y;

        // Draw edges first (so they are behind)
        if (node.left) {
            const childX = x - offset;
            const childY = y + LEVEL_HEIGHT;
            drawEdge(x, y, childX, childY);
            drawNodeRecursive(node.left, childX, childY, offset / 1.8); // 1.8 to reduce spread
        }
        if (node.right) {
            const childX = x + offset;
            const childY = y + LEVEL_HEIGHT;
            drawEdge(x, y, childX, childY);
            drawNodeRecursive(node.right, childX, childY, offset / 1.8);
        }

        // Draw Node
        const nDiv = document.createElement('div');
        nDiv.className = 'tree-node';
        nDiv.id = `node-${node.value}`;
        nDiv.innerText = node.value;
        nDiv.style.left = (x - 20) + 'px';
        nDiv.style.top = (y - 20) + 'px';
        canvas.appendChild(nDiv);
    }

    function drawEdge(x1, y1, x2, y2) {
        const len = Math.hypot(x2-x1, y2-y1);
        const ang = Math.atan2(y2-y1, x2-x1) * 180 / Math.PI;
        
        const edge = document.createElement('div');
        edge.className = 'tree-edge';
        edge.style.width = len + 'px';
        edge.style.left = x1 + 'px';
        edge.style.top = y1 + 'px';
        edge.style.transform = `rotate(${ang}deg)`;
        canvas.appendChild(edge);
    }

    async function insertNode() {
        if(isBusy) return;
        const val = parseInt(document.getElementById('nodeVal').value);
        if(isNaN(val)) return;
        
        isBusy = true;
        log(`Inserting ${val}...`);
        
        // Animate Traversal
        let current = bst.root;
        let path = [];
        
        if (!bst.root) {
            bst.insert(val);
            drawTree();
            highlightNode(val, 'node-found');
             log(`Inserted Root ${val}`, 'success');
        } else {
            // Find Path
            while(current) {
                path.push(current.value);
                if(val === current.value) { log("Value already exists", "error"); isBusy=false; return; }
                if(val < current.value) current = current.left;
                else current = current.right;
            }
            
            // Visual Walk
            for(let v of path) {
                highlightNode(v, 'node-highlight');
                await new Promise(r => setTimeout(r, 600));
                unhighlightNode(v, 'node-highlight');
            }
            
            bst.insert(val);
            drawTree();
            
            // Pop effect on new node
            const newNode = document.getElementById(`node-${val}`);
            if(newNode) {
                newNode.style.transform = 'scale(0)';
                setTimeout(() => newNode.style.transform = 'scale(1)', 100);
            }
            log(`Inserted ${val}`, 'success');
        }
        
        document.getElementById('nodeVal').value = '';
        isBusy = false;
    }

    async function traverse(type) {
        if(isBusy || !bst.root) return;
        isBusy = true;
        log(`Starting ${type} traversal...`);
        let result = [];
        
        if (type === 'inorder') inorder(bst.root, result);
        else if (type === 'preorder') preorder(bst.root, result);
        else postorder(bst.root, result);
        
        document.getElementById('statusText').innerText = "Traversal: " + result.join(" -> ");
        
        for(let val of result) {
             highlightNode(val, 'node-found');
             await new Promise(r => setTimeout(r, 600));
             unhighlightNode(val, 'node-found');
        }
        
        isBusy = false;
    }

    function inorder(node, res) {
        if(!node) return;
        inorder(node.left, res);
        res.push(node.value);
        inorder(node.right, res);
    }
    function preorder(node, res) {
        if(!node) return;
        res.push(node.value);
        preorder(node.left, res);
        preorder(node.right, res);
    }
    function postorder(node, res) {
        if(!node) return;
        postorder(node.left, res);
        postorder(node.right, res);
        res.push(node.value);
    }
    
    async function searchNode() {
        const val = parseInt(document.getElementById('nodeVal').value);
        if(isNaN(val) || isBusy) return;
        isBusy = true;
        
        let current = bst.root;
        let found = false;
        log(`Searching for ${val}...`);
        
        while(current) {
            highlightNode(current.value, 'node-highlight');
            await new Promise(r => setTimeout(r, 600));
            unhighlightNode(current.value, 'node-highlight');
            
            if(current.value === val) {
                highlightNode(current.value, 'node-found');
                log(`Found ${val}!`, 'success');
                found = true;
                break;
            }
            
            if(val < current.value) current = current.left;
            else current = current.right;
        }
        
        if(!found) log(`${val} not found.`, 'error');
        isBusy = false;
    }

    function highlightNode(val, cls) {
        const el = document.getElementById(`node-${val}`);
        if(el) el.classList.add(cls);
    }
    function unhighlightNode(val, cls) {
        const el = document.getElementById(`node-${val}`);
        if(el) el.classList.remove(cls);
    }

    function log(msg, type='info') {
        const box = document.getElementById('logBox');
        box.innerHTML += `<div class="log-entry log-${type}">[${new Date().toLocaleTimeString()}] ${msg}</div>`;
        box.scrollTop = box.scrollHeight;
    }

    function clearTree() {
        bst.root = null;
        drawTree();
        log("Tree cleared.");
    }

    function generateRandomTree() {
        clearTree();
        for(let i=0; i<10; i++) {
            bst.insert(Math.floor(Math.random() * 100) + 1);
        }
        drawTree();
        log("Random tree generated.");
    }
    
    // Initial Draw
    generateRandomTree();

</script>
</body>
</html>
