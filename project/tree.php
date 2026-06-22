<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Data Structure - Concepts & Operations</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .mini-viz-container {
            height: 200px;
            background: #0f172a;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem 0;
            overflow: hidden;
            border: 1px dashed #334155;
            position: relative;
        }

        .cta-button {
            display: inline-block;
            margin-top: 2rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.6);
        }

        .nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .back-link {
            color: var(--text-secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--primary-color);
        }
        
        /* Tree Specific Viz Styles */
        .node {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            position: absolute;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        
        .edge {
            position: absolute;
            background: #94a3b8;
            height: 2px;
            transform-origin: 0 0;
        }
        
        .highlight-node {
            box-shadow: 0 0 15px #f59e0b;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="tree_simulation.php" class="cta-button">🚀 Go to Tree Playground</a>
        </div>

        <header class="header">
            <h1>Tree Data Structure</h1>
            <p class="subtitle">Hierarchical Data Organization: Nodes, Edges, and Traversals</p>
        </header>

        <section class="card">
            <h2>What is a Tree?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Unlike Arrays or Linked Lists which are linear, a <strong>Tree</strong> is a hierarchical data structure. 
                It consists of <strong>nodes</strong> connected by <strong>edges</strong>. The top-most node is called the <strong>Root</strong>.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Node Structure Card -->
            <div class="card">
                <h2>1. Node Structure</h2>
                <p style="color: var(--text-secondary)">A node contains data and pointers to its children (Left & Right in a Binary Tree).</p>
                
                <div class="mini-viz-container" id="viz-node">
                     <!-- Viz here -->
                </div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">node.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">struct Node {
    int data;
    Node* left;
    Node* right;

    Node(int val) {
        data = val;
        left = right = NULL;
    }
};</code></pre>
                    </div>
                </div>
            </div>

            <!-- Root & Leaves Card -->
            <div class="card">
                <h2>2. Root, Parent & Leaf</h2>
                <p style="color: var(--text-secondary)">
                    <strong>Root:</strong> Top node.<br>
                    <strong>Parent:</strong> Node with children.<br>
                    <strong>Leaf:</strong> Node with no children.
                </p>
                
                <div class="mini-viz-container" id="viz-structure"></div>
            </div>

            <!-- BST Card -->
            <div class="card">
                <h2>3. Binary Search Tree (BST)</h2>
                <p style="color: var(--text-secondary)">
                    A special tree where: <br>
                    <code>Left Child < Parent < Right Child</code>
                </p>
                
                <div class="mini-viz-container" id="viz-bst"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">bst_insert.cpp</span>
                    </div>
                    <div class="code-content">
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

            <!-- Traversals Card -->
            <div class="card">
                <h2>4. Tree Traversals</h2>
                <p style="color: var(--text-secondary)">Ways to visit every node in the tree.</p>
                <div class="mini-viz-container" id="viz-traversal"></div>
                
                <div style="font-size: 0.9rem; color: var(--text-secondary); margin-top: 10px;">
                    <ul>
                        <li><strong>Inorder:</strong> Left -> Root -> Right (Sorted in BST)</li>
                        <li><strong>Preorder:</strong> Root -> Left -> Right</li>
                        <li><strong>Postorder:</strong> Left -> Right -> Root</li>
                    </ul>
                </div>
            </div>
            
             <!-- BST Operations (New) -->
            <div class="card" style="grid-column: 1 / -1;">
                <h2>5. BST Operations: Search & Delete</h2>
                <div style="display:flex; gap:20px; flex-wrap:wrap;">
                    <div style="flex:1;">
                        <h3 style="color:#fbbf24; margin-bottom:10px;">Search</h3>
                         <div class="mac-window">
                        <div class="mac-header"><span class="mac-title">search.cpp</span></div>
                        <div class="code-content">
<pre><code class="cpp">Node* search(Node* root, int key) {
    if (root == NULL || root->data == key)
       return root;
    
    if (root->data < key)
       return search(root->right, key);
 
    return search(root->left, key);
}</code></pre>
                        </div>
                        </div>
                    </div>
                    <div style="flex:1;">
                         <h3 style="color:#ef4444; margin-bottom:10px;">Delete</h3>
                          <div class="mac-window">
                        <div class="mac-header"><span class="mac-title">delete.cpp</span></div>
                        <div class="code-content">
<pre><code class="cpp">Node* deleteNode(Node* root, int k) {
    if (!root) return root;
    if (k < root->data) root->left = deleteNode(root->left, k);
    else if (k > root->data) root->right = deleteNode(root->right, k);
    else {
        if (!root->left) return root->right;
        else if (!root->right) return root->left;
        
        Node* temp = minValueNode(root->right);
        root->data = temp->data;
        root->right = deleteNode(root->right, temp->data);
    }
    return root;
}</code></pre>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advantages & Disadvantages -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Analysis</h2>
            <div class="comparison-grid">
                <div class="pros">
                    <h3>Advantages</h3>
                    <ul>
                        <li><strong>Hierarchical:</strong> Fits natural hierarchies (File systems, HTML DOM).</li>
                        <li><strong>Searching:</strong> BST provides O(log n) search, insert, and delete (balanced).</li>
                        <li><strong>Dynamic Size:</strong> Grows and shrinks as needed unlike arrays.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Complex:</strong> More complex to implement than linear structures.</li>
                        <li><strong>Overhead:</strong> Extra memory for pointers (Left/Right).</li>
                        <li><strong>Worst Case:</strong> Unbalanced BST can degrade to O(n) (Linked List).</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">📂</span>
                    <div class="example-title">File Systems</div>
                    <div class="example-desc">Folders and files are organized in a tree structure.</div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🌐</span>
                    <div class="example-title">DOM (HTML)</div>
                    <div class="example-desc">Web pages are structured as a Document Object Model tree.</div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🧠</span>
                    <div class="example-title">AI Decisions</div>
                    <div class="example-desc">Decision Trees used in Game AI (Chess) and Machine Learning.</div>
                </div>
            </div>
        </section>

        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="tree_simulation.php" class="cta-button">🚀 Try the Tree Playground</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Helper to Draw Node
        function createNode(x, y, val, color='#10b981') {
            const node = document.createElement('div');
            node.className = 'node';
            node.innerText = val;
            node.style.left = x + 'px';
            node.style.top = y + 'px';
            if(color) node.style.background = `linear-gradient(135deg, ${color}, #059669)`;
            return node;
        }

        function createEdge(x1, y1, x2, y2) {
            const len = Math.hypot(x2-x1, y2-y1);
            const ang = Math.atan2(y2-y1, x2-x1) * 180 / Math.PI;
            
            const edge = document.createElement('div');
            edge.className = 'edge';
            edge.style.width = len + 'px';
            edge.style.left = (x1 + 20) + 'px'; // Center offset
            edge.style.top = (y1 + 20) + 'px';
            edge.style.transform = `rotate(${ang}deg)`;
            return edge;
        }

        // Viz 1: Node
        const vizNode = document.getElementById('viz-node');
        const n1 = createNode(155, 60, 50);
        const lLine = document.createElement('div'); 
        lLine.innerHTML = '<span style="color:#94a3b8; font-size:12px; position:absolute; top:90px; left:110px;">Left*</span>';
        const rLine = document.createElement('div');
        rLine.innerHTML = '<span style="color:#94a3b8; font-size:12px; position:absolute; top:90px; left:210px;">Right*</span>';
        
        vizNode.appendChild(createEdge(155, 60, 115, 120));
        vizNode.appendChild(createEdge(155, 60, 195, 120));
        vizNode.appendChild(n1);
        vizNode.appendChild(lLine);
        vizNode.appendChild(rLine);
        
        // Viz 2: Structure (Root, Leaf)
        const vizStruct = document.getElementById('viz-structure');
        // Root
        vizStruct.appendChild(createEdge(175, 20, 125, 80));
        vizStruct.appendChild(createEdge(175, 20, 225, 80));
        vizStruct.appendChild(createEdge(125, 80, 100, 140));
        
        const root = createNode(175, 20, 'R', '#f59e0b'); // Root
        const c1 = createNode(125, 80, 'P', '#3b82f6'); // Parent
        const c2 = createNode(225, 80, 'L', '#10b981'); // Leaf
        const c3 = createNode(100, 140, 'L', '#10b981'); // Leaf
        
        vizStruct.appendChild(root);
        vizStruct.appendChild(c1);
        vizStruct.appendChild(c2);
        vizStruct.appendChild(c3);
        
        // Labels
        const lblR = document.createElement('div'); lblR.innerText = "Root"; lblR.style.position='absolute'; lblR.style.color='#f59e0b'; lblR.style.top='25px'; lblR.style.left='220px';
        const lblL = document.createElement('div'); lblL.innerText = "Leaf"; lblL.style.position='absolute'; lblL.style.color='#10b981'; lblL.style.top='145px'; lblL.style.left='150px';
        vizStruct.appendChild(lblR);
        vizStruct.appendChild(lblL);

        // Viz 3: BST Logic
        const vizBST = document.getElementById('viz-bst');
        const bRoot = createNode(175, 20, 50);
        const bL = createNode(125, 80, 30);
        const bR = createNode(225, 80, 70);
        const bLL = createNode(100, 140, 20);
        
        vizBST.appendChild(createEdge(175, 20, 125, 80));
        vizBST.appendChild(createEdge(175, 20, 225, 80));
        vizBST.appendChild(createEdge(125, 80, 100, 140));
        
        vizBST.appendChild(bRoot);
        vizBST.appendChild(bL);
        vizBST.appendChild(bR);
        vizBST.appendChild(bLL);
        
        setInterval(() => {
            // Animate check 20 < 50
            bRoot.classList.add('highlight-node');
            setTimeout(() => {
                bRoot.classList.remove('highlight-node');
                bL.classList.add('highlight-node');
                setTimeout(() => {
                    bL.classList.remove('highlight-node');
                    bLL.classList.add('highlight-node');
                    setTimeout(() => bLL.classList.remove('highlight-node'), 1000);
                }, 1000);
            }, 1000);
        }, 4000);
        
    });
    </script>
</body>
</html>
