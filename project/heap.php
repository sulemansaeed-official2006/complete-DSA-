<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heaps - Max & Min Heap</title>
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
             color: var(--text-secondary); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;
        }
        .back-link:hover { color: var(--primary-color); }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="heap_simulation.php" class="cta-button">🚀 Go to Simulation</a>
        </div>

        <header class="header">
            <h1>Heap Data Structure</h1>
            <p class="subtitle">Complete Binary Trees essential for Priority Queues</p>
        </header>

        <section class="card">
            <h2>Concept</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                A <strong>Heap</strong> is a special tree-based data structure that satisfies the <strong>Heap Property</strong>: In a Max Heap, for any given node I, the value of I is greater than or equal to the values of its children.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Array Rep Card -->
            <div class="card">
                <h2>1. Array Representation</h2>
                <p style="color: var(--text-secondary)">Heaps are usually implemented as arrays.</p>
                <ul style="color: var(--text-secondary);">
                    <li><strong>Parent(i):</strong> (i-1)/2</li>
                    <li><strong>Left Child(i):</strong> 2*i + 1</li>
                    <li><strong>Right Child(i):</strong> 2*i + 2</li>
                </ul>
            </div>

            <!-- Operations Card -->
            <div class="card">
                <h2>2. Operations</h2>
                <p style="color: var(--text-secondary)">
                    <strong>Insert:</strong> Add at end, then "Bubble Up".<br>
                    <strong>Extract Max:</strong> Remove root, move last to root, then "Bubble Down" (Heapify).
                </p>
            </div>
            
             <div class="card">
                 <h2>3. Heap Sort</h2>
                 <p style="color: var(--text-secondary)">An O(n log n) sorting algorithm that uses a heap to find the max element repeatedly.</p>
             </div>
        </div>

        <!-- Analysis Section -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Analysis</h2>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:2rem; margin-top:1rem;">
                <div>
                    <h3 style="color:#10b981; margin-bottom:10px;"><i class="fa-solid fa-thumbs-up"></i> Advantages</h3>
                    <ul style="color:var(--text-secondary); line-height:1.6;">
                        <li><strong>Priority Access:</strong> Instant O(1) access to the maximum/minimum element.</li>
                        <li><strong>Efficiency:</strong> Insert and Extract operations are fast O(log n).</li>
                        <li><strong>Space:</strong> Can be implemented in-place using arrays (no pointers needed).</li>
                    </ul>
                </div>
                <div>
                    <h3 style="color:#ef4444; margin-bottom:10px;"><i class="fa-solid fa-thumbs-down"></i> Disadvantages</h3>
                    <ul style="color:var(--text-secondary); line-height:1.6;">
                        <li><strong>Not for Searching:</strong> Searching for an arbitrary element is slow O(n).</li>
                        <li><strong>Not Sorted:</strong> Unlike BSTs, heaps are not fully sorted, only ordered by level.</li>
                        <li><strong>Complexity:</strong> Implementation can be tricky (indices math).</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Applications</h2>
            <div class="cards-grid" style="margin-top:1rem;">
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🚑</div>
                    <h3 style="color:#fbbf24;">Priority Queues</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Task scheduling in Operating Systems (e.g., handling high-priority interrupts first).</p>
                </div>
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">📊</div>
                    <h3 style="color:#3b82f6;">Order Statistics</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Efficiently finding the K-th largest or smallest element in a dataset.</p>
                </div>
                 <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🕸️</div>
                    <h3 style="color:#a855f7;">Graph Algorithms</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Used internally by Dijkstra's and Prim's algorithms to fetch the closest node efficiently.</p>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Here is the complete code for a Max Heap class with insertion, deletion, and heapify operations.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">MaxHeap.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
#include &lt;vector&gt;
using namespace std;

class MaxHeap {
    vector&lt;int&gt; heap;

    void heapifyDown(int i) {
        int largest = i;
        int left = 2 * i + 1;
        int right = 2 * i + 2;

        if (left &lt; heap.size() && heap[left] &gt; heap[largest])
            largest = left;

        if (right &lt; heap.size() && heap[right] &gt; heap[largest])
            largest = right;

        if (largest != i) {
            swap(heap[i], heap[largest]);
            heapifyDown(largest);
        }
    }

    void heapifyUp(int i) {
        int parent = (i - 1) / 2;
        if (i &gt; 0 && heap[i] &gt; heap[parent]) {
            swap(heap[i], heap[parent]);
            heapifyUp(parent);
        }
    }

public:
    void insert(int val) {
        heap.push_back(val);
        heapifyUp(heap.size() - 1);
    }

    void extractMax() {
        if (heap.empty()) return;
        heap[0] = heap.back();
        heap.pop_back();
        heapifyDown(0);
    }

    void printHeap() {
        for (int val : heap) cout &lt;&lt; val &lt;&lt; " ";
        cout &lt;&lt; endl;
    }
};

int main() {
    MaxHeap h;
    h.insert(10);
    h.insert(20);
    h.insert(5);
    h.insert(30); // 30 will bubble up to root
    
    cout &lt;&lt; "Max Heap: ";
    h.printHeap(); // Output: 30 20 5 10

    h.extractMax(); // Removes 30
    cout &lt;&lt; "After Extract Max: ";
    h.printHeap(); // Output: 20 10 5
    
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="heap_simulation.php" class="cta-button">🚀 Try Heap Playground</a>
        </div>
    </div>
</body>
</html>
