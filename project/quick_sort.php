<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Sort - Divide & Conquer</title>
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
            <a href="quick_sort_simulation.php" class="cta-button">🚀 Go to Simulation</a>
        </div>

        <header class="header">
            <h1>Quick Sort</h1>
            <p class="subtitle">The fastest standard sorting algorithm using Divide & Conquer!</p>
        </header>

        <section class="card">
            <h2>Concept</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Quick Sort works by selecting a 'pivot' element from the array and partitioning the other elements into two sub-arrays, according to whether they are less than or greater than the pivot.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Partition Card -->
            <div class="card">
                <h2>1. Partitioning</h2>
                <p style="color: var(--text-secondary)">Rearranging array so that elements < Pivot are on left, > Pivot are on right.</p>
                <div class="mini-viz-container" id="viz-partition"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">partition.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int partition(int arr[], int low, int high) {
    int pivot = arr[high];
    int i = (low - 1);
    for (int j = low; j < high; j++) {
        if (arr[j] < pivot) {
            i++;
            swap(arr[i], arr[j]);
        }
    }
    swap(arr[i + 1], arr[high]);
    return (i + 1);
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Recursion Card -->
            <div class="card">
                <h2>2. Recursive Step</h2>
                <p style="color: var(--text-secondary)">Recursively applying the same logic to the left and right sub-arrays.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">quickSort.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void quickSort(int arr[], int low, int high) {
    if (low < high) {
        int pi = partition(arr, low, high);
        
        quickSort(arr, low, pi - 1);
        quickSort(arr, pi + 1, high);
    }
}</code></pre>
                    </div>
                </div>
            </div>
            
             <!-- Complexity Card -->
            <div class="card">
                <h2>3. Complexity</h2>
                <table class="complexity-table">
                    <tr><th>Case</th><th>Time Complexity</th></tr>
                    <tr><td>Best</td><td>O(n log n)</td></tr>
                    <tr><td>Average</td><td>O(n log n)</td></tr>
                    <tr><td>Worst</td><td>O(n²) (Bad Pivot)</td></tr>
                    <tr><td>Space</td><td>O(log n) (Stack)</td></tr>
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
                        <li><strong>Fastest on Average:</strong> Generally faster than Merge Sort for arrays due to good cache locality.</li>
                        <li><strong>In-Place:</strong> Requires little additional memory (O(log n) stack space).</li>
                        <li><strong>Tail Recursion:</strong> Can be optimized to minimize stack usage.</li>
                    </ul>
                </div>
                <div>
                    <h3 style="color:#ef4444; margin-bottom:10px;"><i class="fa-solid fa-thumbs-down"></i> Disadvantages</h3>
                    <ul style="color:var(--text-secondary); line-height:1.6;">
                        <li><strong>Unstable:</strong> Relative order of equal elements is not preserved.</li>
                        <li><strong>Worst Case:</strong> Degrades to O(n²) if the array is already sorted (and pivot is bad).</li>
                        <li><strong>Sensitive:</strong> Choice of pivot dramatically affects performance.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Applications</h2>
            <div class="cards-grid" style="margin-top:1rem;">
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">💻</div>
                    <h3 style="color:#fbbf24;">Standard Libraries</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">C++ STL <code>std::sort</code>, C <code>qsort</code> often use Introsort (QuickSort + HeapSort).</p>
                </div>
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">💾</div>
                    <h3 style="color:#3b82f6;">Virtual Memory</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Preferred for sorting in RAM because of its excellent locality of reference.</p>
                </div>
                 <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">📊</div>
                    <h3 style="color:#a855f7;">Numerical Analysis</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Used in scientific computing where speed is critical and stability is not required.</p>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Full working code for Quick Sort function.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">main.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

// Partition: Places pivot at correct position
int partition(int arr[], int low, int high) {
    int pivot = arr[high]; // Choosing last element as pivot
    int i = (low - 1); 

    for (int j = low; j &lt; high; j++) {
        // If current element is smaller than pivot
        if (arr[j] &lt; pivot) {
            i++;
            swap(arr[i], arr[j]);
        }
    }
    swap(arr[i + 1], arr[high]);
    return (i + 1);
}

void quickSort(int arr[], int low, int high) {
    if (low &lt; high) {
        int pi = partition(arr, low, high);

        // Recursively sort elements before and after partition
        quickSort(arr, low, pi - 1);
        quickSort(arr, pi + 1, high);
    }
}

int main() {
    int arr[] = {10, 7, 8, 9, 1, 5};
    int n = sizeof(arr) / sizeof(arr[0]);
    
    quickSort(arr, 0, n - 1);
    
    cout &lt;&lt; "Sorted array: \n";
    for (int i = 0; i &lt; n; i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="quick_sort_simulation.php" class="cta-button">🚀 Try Quick Sort Playground</a>
        </div>
    </div>
    
    <script>
        // Simple viz
        document.addEventListener('DOMContentLoaded', () => {
             const viz = document.getElementById('viz-partition');
             viz.innerHTML = `<div style="display:flex; align-items:flex-end; gap:5px;">
                <div style="width:20px; height:40px; background:#ef4444; border-radius:3px;"></div>
                <div style="width:20px; height:20px; background:#ef4444; border-radius:3px;"></div>
                <div style="width:20px; height:80px; background:#f59e0b; border-radius:3px; text-align:center; color:white; font-size:10px;">P</div>
                <div style="width:20px; height:100px; background:#10b981; border-radius:3px;"></div>
                <div style="width:20px; height:120px; background:#10b981; border-radius:3px;"></div>
             </div>`;
        });
    </script>
</body>
</html>
