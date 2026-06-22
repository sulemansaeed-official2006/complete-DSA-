<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph Data Structure - Concepts & Traversals</title>
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
        
        /* Graph Specific Viz Styles */
        .g-node {
            width: 35px; height: 35px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
            position: absolute;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 2;
        }
        
        .g-edge {
            position: absolute;
            background: #94a3b8;
            height: 2px;
            transform-origin: 0 0;
            z-index: 1;
        }
        
        .arrow {
            position: absolute;
            width: 0; 
            height: 0; 
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
            border-left: 8px solid #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="graph_simulation.php" class="cta-button">🚀 Go to Graph Playground</a>
        </div>

        <header class="header">
            <h1>Graph Data Structure</h1>
            <p class="subtitle">Networks, Connections, and Pathfinding</p>
        </header>

        <section class="card">
            <h2>What is a Graph?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                A <strong>Graph</strong> is a collection of <strong>Vertices (Nodes)</strong> and <strong>Edges (Connections)</strong>. 
                They model real-world networks like social media connections, city maps, and internet routing.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Basics Card -->
            <div class="card">
                <h2>1. Vertices & Edges</h2>
                <p style="color: var(--text-secondary)">
                    <strong>Vertex (V):</strong> A node in the graph.<br>
                    <strong>Edge (E):</strong> A link between two vertices.
                </p>
                
                <div class="mini-viz-container" id="viz-basic"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">adj_list.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">vector&lt;int&gt; adj[V];

void addEdge(int u, int v) {
    adj[u].push_back(v);
    adj[v].push_back(u); // Undirected
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Directed vs Undirected -->
            <div class="card">
                <h2>2. Directed vs Undirected</h2>
                <p style="color: var(--text-secondary)">Edges can be one-way (Directed) or two-way (Undirected).</p>
                <div class="mini-viz-container" id="viz-types"></div>
            </div>

            <!-- BFS Card -->
            <div class="card">
                <h2>3. BFS (Breadth First Search)</h2>
                <p style="color: var(--text-secondary)">Explores neighbors level by level. Uses a <strong>Queue</strong>.</p>
                <div class="mini-viz-container" id="viz-bfs"></div>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">bfs.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void BFS(int s) {
    bool visited[V];
    queue&lt;int&gt; q;
    visited[s] = true;
    q.push(s);
    while(!q.empty()) {
        int u = q.front(); q.pop();
        for(int v : adj[u]) {
            if(!visited[v]) {
                visited[v] = true;
                q.push(v);
            }
        }
    }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- DFS Card -->
            <div class="card">
                <h2>4. DFS (Depth First Search)</h2>
                <p style="color: var(--text-secondary)">Explores as far as possible along each branch. Uses a <strong>Stack</strong> (Recursion).</p>
                <div class="mini-viz-container" id="viz-dfs"></div>

                <div class="mac-window">
                     <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">dfs.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void DFS(int u, bool visited[]) {
    visited[u] = true;
    cout << u << " ";
    for(int v : adj[u]) {
        if(!visited[v]) DFS(v, visited);
    }
}</code></pre>
                    </div>
                </div>
            </div>
            
        </div>

        <!-- Analysis -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Analysis</h2>
            <div class="comparison-grid">
                <div class="pros">
                    <h3>Advantages</h3>
                    <ul>
                        <li><strong>Modeling:</strong> Perfect for complex relationships (Networks, Dependencies).</li>
                        <li><strong>Pathfinding:</strong> Algorithms like BFS find the shortest path in unweighted graphs.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Complexity:</strong> Graph algorithms can be computationally expensive (O(V+E)).</li>
                        <li><strong>Storage:</strong> Adjacency Matrix takes O(V²) space.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">🌐</span>
                    <div class="example-title">Social Networks</div>
                    <div class="example-desc">Users are nodes, friendships are edges.</div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🗺️</span>
                    <div class="example-title">Google Maps</div>
                    <div class="example-desc">Locations are nodes, roads are weighted edges.</div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🔗</span>
                    <div class="example-title">Web Crawlers</div>
                    <div class="example-desc">Webpages are nodes, hyperlinks are directed edges.</div>
                </div>
            </div>
        </section>

        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="graph_simulation.php" class="cta-button">🚀 Try the Graph Playground</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Helper to Draw Node & Edge
        function createGNode(x, y, val, id) {
            const node = document.createElement('div');
            node.className = 'g-node';
            node.innerText = val;
            node.id = id;
            node.style.left = x + 'px';
            node.style.top = y + 'px';
            return node;
        }

        function createGEdge(x1, y1, x2, y2, directed=false) {
            const len = Math.hypot(x2-x1, y2-y1);
            const ang = Math.atan2(y2-y1, x2-x1) * 180 / Math.PI;
            
            const edge = document.createElement('div');
            edge.className = 'g-edge';
            edge.style.width = len + 'px';
            edge.style.left = (x1 + 17) + 'px';
            edge.style.top = (y1 + 17) + 'px';
            edge.style.transform = `rotate(${ang}deg)`;
            
            if(directed) {
                const arrow = document.createElement('div');
                arrow.className = 'arrow';
                arrow.style.left = (len - 10) + 'px'; // approx at end
                arrow.style.top = '-4px';
                edge.appendChild(arrow);
            }
            return edge;
        }

        // Viz 1: Basic
        const vizBasic = document.getElementById('viz-basic');
        vizBasic.appendChild(createGEdge(100, 100, 200, 50));
        vizBasic.appendChild(createGEdge(100, 100, 200, 150));
        vizBasic.appendChild(createGEdge(200, 50, 200, 150));
        
        vizBasic.appendChild(createGNode(100, 100, 'A', 'n1'));
        vizBasic.appendChild(createGNode(200, 50, 'B', 'n2'));
        vizBasic.appendChild(createGNode(200, 150, 'C', 'n3'));
        
        // Viz 2: Types (Directed)
        const vizTypes = document.getElementById('viz-types');
        vizTypes.appendChild(createGEdge(80, 100, 180, 50, true)); // Directed
        vizTypes.appendChild(createGEdge(180, 50, 280, 100, true)); 
        
        vizTypes.appendChild(createGNode(80, 100, 'A', 't1'));
        vizTypes.appendChild(createGNode(180, 50, 'B', 't2'));
        vizTypes.appendChild(createGNode(280, 100, 'C', 't3'));
        
        const typeLbl = document.createElement('div');
        typeLbl.innerText = "Directed (One-Way)";
        typeLbl.style.color = '#94a3b8';
        typeLbl.style.position = 'absolute';
        typeLbl.style.bottom = '20px';
        vizTypes.appendChild(typeLbl);

        // Viz 3: BFS Animation
        const vizBFS = document.getElementById('viz-bfs');
        // Simple 3 node straight line
        vizBFS.appendChild(createGEdge(80, 100, 180, 100));
        vizBFS.appendChild(createGEdge(180, 100, 280, 100));
        
        const b1 = createGNode(80, 100, '1', 'b1');
        const b2 = createGNode(180, 100, '2', 'b2');
        const b3 = createGNode(280, 100, '3', 'b3');
        
        vizBFS.appendChild(b1); vizBFS.appendChild(b2); vizBFS.appendChild(b3);
        
        setInterval(() => {
            b1.style.background = '#10b981'; // Visited 1
            setTimeout(() => {
                b2.style.background = '#10b981'; // Visited 2
                setTimeout(() => {
                    b3.style.background = '#10b981'; // Visited 3
                    setTimeout(() => {
                        // Reset
                        b1.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                        b2.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                        b3.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                    }, 1000);
                }, 800);
            }, 800);
        }, 3500);

        // Viz 4: DFS Animation
        const vizDFS = document.getElementById('viz-dfs');
         // Triangle
        vizDFS.appendChild(createGEdge(175, 50, 125, 140));
        vizDFS.appendChild(createGEdge(125, 140, 225, 140));
        vizDFS.appendChild(createGEdge(225, 140, 175, 50));
        
        const d1 = createGNode(175, 50, '1', 'd1');
        const d2 = createGNode(125, 140, '2', 'd2');
        const d3 = createGNode(225, 140, '3', 'd3');
        
        vizDFS.appendChild(d1); vizDFS.appendChild(d2); vizDFS.appendChild(d3);
        
        setInterval(() => {
            d1.style.background = '#ef4444'; // Visited 1
            setTimeout(() => {
                d2.style.background = '#ef4444'; // Visited 2 (Left child first)
                setTimeout(() => {
                    d3.style.background = '#ef4444'; // Visited 3 (Then back and right)
                     setTimeout(() => {
                        // Reset
                        d1.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                        d2.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                        d3.style.background = 'linear-gradient(135deg, #3b82f6, #2563eb)';
                    }, 1000);
                }, 800);
            }, 800);
        }, 3500);
        
    });
    </script>
</body>
</html>
