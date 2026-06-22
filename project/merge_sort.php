<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merge Sort - Divide & Conquer</title>
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
            <a href="merge_sort_simulation.php" class="cta-button">🚀 Go to Simulation</a>
        </div>

        <header class="header">
            <h1>Merge Sort</h1>
            <p class="subtitle">Stable, consistent sorting using Divide & Conquer Principle</p>
        </header>

        <section class="card">
            <h2>Concept</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Merge Sort repeatedly divides the array into two halves until we reach single elements. Then, it merges the sub-arrays directly into a sorted array.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Divide Card -->
            <div class="card">
                <h2>1. Divide Phase</h2>
                <p style="color: var(--text-secondary)">Split the array into two halves recursively.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">divide.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void mergeSort(int arr[], int l, int r) {
    if (l >= r) return;
    int m = l + (r - l) / 2;
    mergeSort(arr, l, m);
    mergeSort(arr, m + 1, r);
    merge(arr, l, m, r);
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Merge Card -->
            <div class="card">
                <h2>2. Merge Phase</h2>
                <p style="color: var(--text-secondary)">Combine two sorted sub-arrays into one large sorted array.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div><div class="mac-dot yellow"></div><div class="mac-dot green"></div>
                        <span class="mac-title">merge.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void merge(int arr[], int l, int m, int r) {
    // Create temp arrays L[] and R[]
    // Copy data to temp arrays
    // Merge back to arr[l..r]
}</code></pre>
                    </div>
                </div>
            </div>
            
             <!-- Complexity Card -->
            <div class="card">
                <h2>3. Complexity</h2>
                <table class="complexity-table">
                    <tr><th>Case</th><th>Time Complexity</th></tr>
                    <tr><td>All Cases</td><td>O(n log n)</td></tr>
                    <tr><td>Space</td><td>O(n) (Auxiliary)</td></tr>
                    <tr><td>Stability</td><td>Stable</td></tr>
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
                        <li><strong>Consistent:</strong> Guaranteed O(n log n) performance even in worst case.</li>
                        <li><strong>Stable:</strong> Preserves order of equal elements (crucial for multi-key sorting).</li>
                        <li><strong>External Sorting:</strong> Works well with large datasets (Linked Lists, Tape Drives).</li>
                    </ul>
                </div>
                <div>
                    <h3 style="color:#ef4444; margin-bottom:10px;"><i class="fa-solid fa-thumbs-down"></i> Disadvantages</h3>
                    <ul style="color:var(--text-secondary); line-height:1.6;">
                        <li><strong>Space Heavy:</strong> Requires O(n) extra space for temporary arrays.</li>
                        <li><strong>Overhead:</strong> Lots of copying data between arrays.</li>
                        <li><strong>Worse Cache:</strong> Not as cache-friendly as Quick Sort for RAM operations.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Applications</h2>
            <div class="cards-grid" style="margin-top:1rem;">
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🐍</div>
                    <h3 style="color:#fbbf24;">Python & Java</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Python's <code>Timsort</code> (used in Java 7+) is a hybrid of Merge Sort and Insertion Sort.</p>
                </div>
                <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">📦</div>
                    <h3 style="color:#3b82f6;">E-Commerce</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Sort by Price, then by Rating? Stable sort is required to keep the previous order intact.</p>
                </div>
                 <div style="background:rgba(255,255,255,0.05); padding:1.5rem; border-radius:10px;">
                    <div style="font-size:2rem; margin-bottom:10px;">🔗</div>
                    <h3 style="color:#a855f7;">Linked Lists</h3>
                    <p style="color:#94a3b8; font-size:0.9rem;">Merge sort is the preferred algorithm for sorting Linked Lists (no random access).</p>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Full working code for Merge Sort function.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">main.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

// Merges two subarrays of arr[].
// First subarray is arr[l..m]
// Second subarray is arr[m+1..r]
void merge(int arr[], int l, int m, int r) {
    int n1 = m - l + 1;
    int n2 = r - m;

    // Create temp arrays
    int L[n1], R[n2];

    for (int i = 0; i &lt; n1; i++)
        L[i] = arr[l + i];
    for (int j = 0; j &lt; n2; j++)
        R[j] = arr[m + 1 + j];

    // Merge the temp arrays back 
    int i = 0, j = 0, k = l;
    while (i &lt; n1 && j &lt; n2) {
        if (L[i] &lt;= R[j]) {
            arr[k] = L[i];
            i++;
        } else {
            arr[k] = R[j];
            j++;
        }
        k++;
    }

    // Copy remaining elements
    while (i &lt; n1) {
        arr[k] = L[i];
        i++;
        k++;
    }
    while (j &lt; n2) {
        arr[k] = R[j];
        j++;
        k++;
    }
}

void mergeSort(int arr[], int l, int r) {
    if (l &gt;= r) return;
    
    int m = l + (r - l) / 2;
    
    mergeSort(arr, l, m);
    mergeSort(arr, m + 1, r);
    
    merge(arr, l, m, r);
}

int main() {
    int arr[] = {12, 11, 13, 5, 6, 7};
    int arr_size = sizeof(arr) / sizeof(arr[0]);

    mergeSort(arr, 0, arr_size - 1);

    cout &lt;&lt; "\nSorted array is \n";
    for (int i = 0; i &lt; arr_size; i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="merge_sort_simulation.php" class="cta-button">🚀 Try Merge Sort Playground</a>
        </div>
    </div>
</body>
</html>
