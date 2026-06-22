<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MST - Minimum Spanning Tree</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); /* Better response */
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .cta-button {
            display: inline-block;
            margin-top: 2rem;
            padding: 1rem 3rem;
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

        .nav-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .back-link { color: var(--text-secondary); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s; }
        .back-link:hover { color: var(--primary-color); }
        
        /* Revised Table Style */
        .comp-table { 
            width: 100%; border-collapse: separate; border-spacing: 0; margin-top:20px; font-size:1rem; 
            border: 1px solid var(--border-color); border-radius: 10px; overflow: hidden;
        }
        .comp-table th, .comp-table td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border-color); }
        .comp-table th { background: rgba(255,255,255,0.05); color: var(--accent-color); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.85rem; }
        .comp-table td { color: var(--text-secondary); background: var(--card-bg); }
        .comp-table tr:last-child td { border-bottom: none; }
        .comp-table tr:hover td { background: rgba(255,255,255,0.02); }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="mst_simulation.php" class="cta-button" style="padding: 0.8rem 1.5rem; font-size: 1rem; margin:0;">🚀 Simulation</a>
        </div>

        <header class="header" style="text-align:center; max-width:800px; margin:0 auto 4rem auto;">
            <h1 style="font-size: 3rem; background: -webkit-linear-gradient(45deg, #eee, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Minimum Spanning Tree</h1>
            <p class="subtitle" style="font-size: 1.2rem; margin-top: 10px;">Finding the most efficient way to connect everything.</p>
        </header>

        <!-- Intro -->
        <section class="card" style="border-left: 5px solid var(--accent-color);">
            <h2>Graph Concepts</h2>
            <div style="display:flex; gap:40px; flex-wrap:wrap; margin-top: 20px;">
                <div style="flex:1;">
                    <h3 style="color:#fbbf24; margin-bottom: 10px;"><i class="fa-solid fa-code-branch"></i> Spanning Tree</h3>
                    <p style="color:var(--text-secondary); line-height: 1.6;">A subgraph that connects <strong>ALL</strong> vertices with exactly $V-1$ edges and <strong>NO cycles</strong>. It's the "skeleton" of the graph.</p>
                </div>
                <div style="flex:1;">
                    <h3 style="color:#10b981; margin-bottom: 10px;"><i class="fa-solid fa-tags"></i> MST Cost</h3>
                    <p style="color:var(--text-secondary); line-height: 1.6;">The "Cost" is the total sum of edge weights. An <strong>MST</strong> is the specific tree where this cost is the absolute minimum possible.</p>
                </div>
            </div>
        </section>

        <div class="cards-grid">
            <!-- Prim's Card -->
            <div class="card">
                <h2><i class="fa-solid fa-seedling"></i> Prim's Algorithm</h2>
                <p style="color:#94a3b8; margin-bottom:15px; min-height: 60px;">
                    <strong>Strategy:</strong> "Growing a Tree". Start from a seed node, and expand outwards by always picking the cheapest connection.
                </p>
                <div class="mac-window">
                    <div class="mac-header">
                        <span class="mac-title">prim.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">// Priority Queue stores {weight, node}
pq.push({0, startNode});

while(!pq.empty()) {
    int u = pq.top().second; pq.pop();
    if(visited[u]) continue;
    visited[u] = true;
    
    for(auto edge : adj[u]) {
        if(!visited[edge.to]) 
            pq.push({edge.weight, edge.to});
    }
}</code></pre>
                    </div>
                </div>
                <!-- Tag -->
                <div style="margin-top:20px; text-align:right;">
                    <span style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight:600;">Dense Graphs</span>
                </div>
            </div>

            <!-- Kruskal's Card -->
            <div class="card">
                <h2><i class="fa-solid fa-layer-group"></i> Kruskal's Algorithm</h2>
                <p style="color:#94a3b8; margin-bottom:15px; min-height: 60px;">
                    <strong>Strategy:</strong> "Merging Forests". Sort all edges first. Pick valid edges one by one to merge isolated clusters together.
                </p>
                <div class="mac-window">
                    <div class="mac-header">
                        <span class="mac-title">kruskal.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">sort(edges.begin(), edges.end()); // Simple!

for(Edge e : edges) {
    // Check for Cycle using Union-Find
    if(find(e.u) != find(e.v)) {
        union(e.u, e.v);
        mst.push_back(e);
    }
}</code></pre>
                    </div>
                </div>
                <!-- Tag -->
                 <div style="margin-top:20px; text-align:right;">
                    <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight:600;">Sparse Graphs</span>
                </div>
            </div>
        </div>
        
        <section class="card" style="margin-top:3rem;">
            <h2><i class="fa-solid fa-scale-balanced"></i> Algorithm Comparison</h2>
            <table class="comp-table">
                <thead>
                    <tr>
                        <th width="20%">Feature</th>
                        <th width="40%">Prim's Algorithm</th>
                        <th width="40%">Kruskal's Algorithm</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Approach</strong></td>
                        <td>Vertex-based (Greedy)</td>
                        <td>Edge-based (Greedy)</td>
                    </tr>
                    <tr>
                        <td><strong>Data Structure</strong></td>
                        <td>Priority Queue (Min Heap)</td>
                        <td>Union-Find (Disjoint Set)</td>
                    </tr>
                    <tr>
                        <td><strong>Time Complexity</strong></td>
                        <td>O(E log V)</td>
                        <td>O(E log E)</td>
                    </tr>
                    <tr>
                        <td><strong>Best For</strong></td>
                        <td><strong>Dense Graphs</strong> (Many edges)</td>
                        <td><strong>Sparse Graphs</strong> (Few edges)</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Frameworks</h2>
            <div class="cards-grid" style="margin-top:1rem;">
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🔌</div>
                    <h3 style="color:#fbbf24;">Circuit Design</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Connecting components on a PCB with the least amount of wire to reduce cost and latency.</p>
                </div>
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🚰</div>
                    <h3 style="color:#3b82f6;">Water/Pipe Networks</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Designing a water distribution network that connects all houses with minimum pipe length.</p>
                </div>
                 <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">📡</div>
                    <h3 style="color:#a855f7;">Telecommunications</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Laying cables to connect multiple cities with the minimum total cost of cabling.</p>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Implementation of Prim's Algorithm to find MST logic.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">prim.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
#include &lt;vector&gt;
#include &lt;queue&gt;
using namespace std;

typedef pair&lt;int, int&gt; pii;

int primMST(int n, vector&lt;vector&lt;pii&gt;&gt;& adj) {
    priority_queue&lt;pii, vector&lt;pii&gt;, greater&lt;pii&gt;&gt; pq;
    vector&lt;bool&gt; visited(n, false);
    int mstCost = 0;

    // Start from node 0
    pq.push({0, 0}); 

    while (!pq.empty()) {
        int w = pq.top().first;
        int u = pq.top().second;
        pq.pop();

        if (visited[u]) continue;
        
        visited[u] = true;
        mstCost += w;

        for (auto& edge : adj[u]) {
            int weight = edge.first;
            int v = edge.second;
            if (!visited[v]) {
                pq.push({weight, v});
            }
        }
    }
    return mstCost;
}

int main() {
    int n = 4;
    vector&lt;vector&lt;pii&gt;&gt; adj(n);

    // Edge: {weight, neighbor}
    adj[0].push_back({10, 1}); adj[1].push_back({10, 0});
    adj[0].push_back({20, 2}); adj[2].push_back({20, 0});
    adj[1].push_back({5, 3}); adj[3].push_back({5, 1});
    adj[2].push_back({15, 3}); adj[3].push_back({15, 2});

    cout &lt;&lt; "MST Cost: " &lt;&lt; primMST(n, adj);
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 4rem; margin-bottom: 4rem;">
            <a href="mst_simulation.php" class="cta-button">🚀 Launch Interactive Sandbox</a>
            <p style="margin-top:15px; color:var(--text-secondary);">Switch between algorithms in real-time!</p>
        </div>
    </div>
</body>
</html>
