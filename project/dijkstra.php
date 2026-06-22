<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dijkstra's Algorithm - Shortest Path</title>
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
            height: 150px;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="dijkstra_simulation.php" class="cta-button">🚀 Go to Simulation</a>
        </div>

        <header class="header">
            <h1>Dijkstra's Algorithm</h1>
            <p class="subtitle">Finding the Shortest Path in Weighted Graphs</p>
        </header>

        <section class="card">
            <h2>Concept</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Dijkstra's algorithm finds the shortest path from a source node to all other nodes in a graph with non-negative edge weights. It uses a <strong>Min-Priority Queue</strong> to greedily select the closest unvisited node.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Relaxation Card -->
            <div class="card">
                <h2>1. Relaxation</h2>
                <p style="color: var(--text-secondary)">Updating the shortest distance to a neighbor if a better path is found.</p>
                <div class="mini-viz-container" id="viz-relax"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">relax.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">if (dist[u] + weight < dist[v]) {
    dist[v] = dist[u] + weight;
    pq.push({dist[v], v});
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Algorithm Steps -->
            <div class="card">
                <h2>2. The Algorithm</h2>
                <ol style="color: var(--text-secondary); padding-left: 20px; line-height: 1.6;">
                    <li>Initialize distances: Source = 0, others = ∞.</li>
                    <li>Add Source to Priority Queue.</li>
                    <li>While PQ is not empty:
                        <ul style="margin-top: 5px;">
                            <li>Pop node <code>u</code> with min distance.</li>
                            <li>For each neighbor <code>v</code> of <code>u</code>:</li>
                            <li><strong>Relax</strong> edge (u, v).</li>
                        </ul>
                    </li>
                </ol>
            </div>
            
             <!-- Complexity Card -->
            <div class="card">
                <h2>3. Complexity</h2>
                <table class="complexity-table">
                    <tr><th>Metric</th><th>Value</th></tr>
                    <tr><td>Time</td><td>O(E log V)</td></tr>
                    <tr><td>Space</td><td>O(V + E)</td></tr>
                    <tr><td>Constraint</td><td>Non-negative weights</td></tr>
                </table>
            </div>
        </div>

        <!-- Analysis Section -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Analysis</h2>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:2rem; margin-top:1rem;">
                <div>
                    <h3 style="color:#10b981; margin-bottom:10px;"><i class="fa-solid fa-thumbs-up"></i> Advantages</h3>
                    <ul style="color:var(--text-secondary); line-height:1.6;">
                        <li><strong>Optimal:</strong> Guarantees the shortest path for non-negative weights.</li>
                        <li><strong>Versatile:</strong> Works for both directed and undirected graphs.</li>
                        <li><strong>Standard:</strong> Widely used standard for routing protocols (OSPF).</li>
                    </ul>
                </div>
                <div>
                    <h3 style="color:#ef4444; margin-bottom:10px;"><i class="fa-solid fa-thumbs-down"></i> Disadvantages</h3>
                    <ul style="color:var(--text-secondary); line-height:1.6;">
                        <li><strong>Negative Weights:</strong> Fails if edge weights are negative (Use Bellman-Ford).</li>
                        <li><strong>Blind Search:</strong> Explores all directions equally (unlike A* which uses heuristics).</li>
                        <li><strong>Slow for Large Graphs:</strong> Can be slow if the graph is massive (O(E log V)).</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Frameworks</h2>
            <div class="cards-grid" style="margin-top:1rem;">
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🗺️</div>
                    <h3 style="color:#fbbf24;">Google Maps</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Finding the quickest route between two locations, considering distance (weight) and traffic.</p>
                </div>
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">📡</div>
                    <h3 style="color:#3b82f6;">Network Routing</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">IP Routing (OSPF) uses Dijkstra to find the best path for data packets across the internet.</p>
                </div>
                 <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🎮</div>
                    <h3 style="color:#a855f7;">Game AI</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Characters finding their way around obstacles to reach a target player.</p>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Standard Dijkstra implementation using Adjacency List and Priority Queue.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">dijkstra.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
#include &lt;vector&gt;
#include &lt;queue&gt;
using namespace std;

#define INF 1e9

// Pair of (weight, node)
typedef pair&lt;int, int&gt; pii;

void dijkstra(int start, int n, vector&lt;vector&lt;pii&gt;&gt;& adj) {
    priority_queue&lt;pii, vector&lt;pii&gt;, greater&lt;pii&gt;&gt; pq;
    vector&lt;int&gt; dist(n, INF);

    pq.push({0, start});
    dist[start] = 0;

    while (!pq.empty()) {
        int u = pq.top().second;
        int d = pq.top().first;
        pq.pop();

        if (d &gt; dist[u]) continue;

        for (auto& edge : adj[u]) {
            int v = edge.second;
            int weight = edge.first;

            if (dist[u] + weight &lt; dist[v]) {
                dist[v] = dist[u] + weight;
                pq.push({dist[v], v});
            }
        }
    }

    cout &lt;&lt; "Shortest distances from node " &lt;&lt; start &lt;&lt; ":\n";
    for (int i = 0; i &lt; n; ++i)
        cout &lt;&lt; "Node " &lt;&lt; i &lt;&lt; " : " &lt;&lt; dist[i] &lt;&lt; endl;
}

int main() {
    int n = 5; // Number of nodes
    vector&lt;vector&lt;pii&gt;&gt; adj(n);

    // Edges (weight, node)
    adj[0].push_back({10, 1});
    adj[0].push_back({5, 2});
    adj[1].push_back({1, 2});
    adj[2].push_back({2, 3});
    adj[1].push_back({2, 4});

    dijkstra(0, n, adj);
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="dijkstra_simulation.php" class="cta-button">🚀 Try Dijkstra Playground</a>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
             // Viz Logic for Relaxation
             const viz = document.getElementById('viz-relax');
             viz.style.color = 'white';
             viz.innerHTML = `
                <div style="display:flex; align-items:center; gap:20px;">
                    <div style="text-align:center;">
                        <div style="width:40px; height:40px; background:#10b981; border-radius:50%; display:flex; align-items:center; justify-content:center;">A</div>
                        <div style="font-size:0.8rem; margin-top:5px; color:#10b981;">0</div>
                    </div>
                    <div style="height:2px; width:50px; background:#64748b; position:relative;">
                        <div style="position:absolute; top:-20px; left:20px; color:#fbbf24;">5</div>
                    </div>
                    <div style="text-align:center;">
                         <div style="width:40px; height:40px; background:#3b82f6; border-radius:50%; display:flex; align-items:center; justify-content:center;">B</div>
                        <div style="font-size:0.8rem; margin-top:5px; color:#ef4444;">∞ → 5</div>
                    </div>
                </div>
             `;
        });
    </script>
</body>
</html>
