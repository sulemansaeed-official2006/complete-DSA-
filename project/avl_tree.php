<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AVL Tree - Self Balancing BST</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .mini-viz-container {
            height: 220px;
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

        .back-link:hover { color: var(--primary-color); }
        
        .node {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            position: absolute;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: all 0.5s ease;
            z-index: 2;
        }
        
        .edge {
            position: absolute;
            background: #94a3b8;
            height: 2px;
            transform-origin: 0 0;
            transition: all 0.5s ease;
            z-index: 1;
        }

        .bf-badge {
            position: absolute;
            top: -10px; right: -10px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
        }
        .bf-ok { background: #10b981; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="avl_tree_simulation.php" class="cta-button">🚀 Go to Simulation</a>
        </div>

        <header class="header">
            <h1>AVL Tree</h1>
            <p class="subtitle">Adelson-Velsky and Landis: The First Self-Balancing Binary Search Tree</p>
        </header>

        <section class="card">
            <h2>What is an AVL Tree?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                An AVL tree is a <strong>self-balancing Binary Search Tree (BST)</strong>. The difference between heights of left and right subtrees cannot be more than one for all nodes.
            </p>
            <div style="background: rgba(6, 182, 212, 0.1); padding: 15px; border-left: 4px solid #06b6d4; border-radius: 4px; color: #cbd5e1;">
                <strong>Balance Factor (BF)</strong> = Height(Left Subtree) - Height(Right Subtree)<br>
                Allowed BF: <code>-1, 0, 1</code>
            </div>
        </section>

        <div class="cards-grid">
            <!-- LL Rotation -->
            <div class="card">
                <h2>1. Left-Left (LL) Case</h2>
                <p style="color: var(--text-secondary)">Occurs when a node is inserted into the <strong>left</strong> child of the <strong>left</strong> subtree.</p>
                <div class="mini-viz-container" id="viz-ll"></div>
                <p style="font-size: 0.9rem; color: #94a3b8; margin-top: 10px;">Fix: <strong>Right Rotation</strong></p>
            </div>

            <!-- RR Rotation -->
            <div class="card">
                <h2>2. Right-Right (RR) Case</h2>
                <p style="color: var(--text-secondary)">Occurs when a node is inserted into the <strong>right</strong> child of the <strong>right</strong> subtree.</p>
                <div class="mini-viz-container" id="viz-rr"></div>
                <p style="font-size: 0.9rem; color: #94a3b8; margin-top: 10px;">Fix: <strong>Left Rotation</strong></p>
            </div>
            
            <!-- LR Rotation -->
            <div class="card">
                <h2>3. Left-Right (LR) Case</h2>
                <p style="color: var(--text-secondary)">Left child, then Right child.</p>
                <div class="mini-viz-container" id="viz-lr"></div>
                <p style="font-size: 0.9rem; color: #94a3b8; margin-top: 10px;">Fix: <strong>Left Rotation on Child, then Right on Root</strong></p>
            </div>

             <!-- RL Rotation -->
             <div class="card">
                <h2>4. Right-Left (RL) Case</h2>
                <p style="color: var(--text-secondary)">Right child, then Left child.</p>
                <div class="mini-viz-container" id="viz-rl"></div>
                <p style="font-size: 0.9rem; color: #94a3b8; margin-top: 10px;">Fix: <strong>Right Rotation on Child, then Left on Root</strong></p>
            </div>
        </div>

        <!-- Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <div class="mac-window" style="height: 500px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">avl.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

class Node {
public:
    int key;
    Node *left;
    Node *right;
    int height;
};

int height(Node *N) {
    if (N == NULL) return 0;
    return N->height;
}

int max(int a, int b) {
    return (a > b)? a : b;
}

Node* newNode(int key) {
    Node* node = new Node();
    node->key = key;
    node->left = NULL;
    node->right = NULL;
    node->height = 1;
    return(node);
}

Node *rightRotate(Node *y) {
    Node *x = y->left;
    Node *T2 = x->right;
    x->right = y;
    y->left = T2;
    y->height = max(height(y->left), height(y->right)) + 1;
    x->height = max(height(x->left), height(x->right)) + 1;
    return x;
}

Node *leftRotate(Node *x) {
    Node *y = x->right;
    Node *T2 = y->left;
    y->left = x;
    x->right = T2;
    x->height = max(height(x->left), height(x->right)) + 1;
    y->height = max(height(y->left), height(y->right)) + 1;
    return y;
}

int getBalance(Node *N) {
    if (N == NULL) return 0;
    return height(N->left) - height(N->right);
}

Node* insert(Node* node, int key) {
    if (node == NULL) return(newNode(key));
    if (key < node->key)
        node->left = insert(node->left, key);
    else if (key > node->key)
        node->right = insert(node->right, key);
    else return node;

    node->height = 1 + max(height(node->left), height(node->right));
    int balance = getBalance(node);

    // Left Left Case
    if (balance > 1 && key < node->left->key)
        return rightRotate(node);

    // Right Right Case
    if (balance < -1 && key > node->right->key)
        return leftRotate(node);

    // Left Right Case
    if (balance > 1 && key > node->left->key) {
        node->left = leftRotate(node->left);
        return rightRotate(node);
    }

    // Right Left Case
    if (balance < -1 && key < node->right->key) {
        node->right = rightRotate(node->right);
        return leftRotate(node);
    }
    return node;
}</code></pre>
                </div>
            </div>
        </section>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        function createNode(x, y, val, bf=0) {
            const node = document.createElement('div');
            node.className = 'node';
            node.innerText = val;
            node.style.left = x + 'px';
            node.style.top = y + 'px';
            
            const badge = document.createElement('span');
            badge.className = 'bf-badge ' + (Math.abs(bf) < 2 ? 'bf-ok' : '');
            badge.innerText = bf;
            node.appendChild(badge);
            
            return node;
        }
        function createEdge(x1, y1, x2, y2) {
            const len = Math.hypot(x2-x1, y2-y1);
            const ang = Math.atan2(y2-y1, x2-x1) * 180 / Math.PI;
            const edge = document.createElement('div');
            edge.className = 'edge';
            edge.style.width = len + 'px';
            edge.style.left = (x1 + 20) + 'px'; 
            edge.style.top = (y1 + 20) + 'px';
            edge.style.transform = `rotate(${ang}deg)`;
            return edge;
        }

        // Viz LL
        const vizLL = document.getElementById('viz-ll');
        vizLL.appendChild(createEdge(170, 40, 120, 100)); // 3->2
        vizLL.appendChild(createEdge(120, 100, 70, 160)); // 2->1
        vizLL.appendChild(createNode(170, 40, 30, 2));
        vizLL.appendChild(createNode(120, 100, 20, 1));
        vizLL.appendChild(createNode(70, 160, 10, 0));
        
        // Viz RR
        const vizRR = document.getElementById('viz-rr');
        vizRR.appendChild(createEdge(120, 40, 170, 100)); // 1->2
        vizRR.appendChild(createEdge(170, 100, 220, 160)); // 2->3
        vizRR.appendChild(createNode(120, 40, 10, -2));
        vizRR.appendChild(createNode(170, 100, 20, -1));
        vizRR.appendChild(createNode(220, 160, 30, 0));

    });
    </script>
</body>
</html>
