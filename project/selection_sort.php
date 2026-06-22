<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selection Sort - Concepts & Code</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
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
            transition: all 0.3s ease;
        }
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.6);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem;">
            <a href="dashboard.php" class="back-link" style="color:var(--text-secondary); text-decoration:none;">← Back to Dashboard</a>
            <a href="selection_sort_simulation.php" class="cta-button">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Selection Sort Algorithm</h1>
            <p class="subtitle">A simple algorithm that repeatedly selects the smallest element from the unsorted portion.</p>
        </header>

        <section class="card">
            <h2>What is Selection Sort?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Selection Sort divides the input list into two parts: the sublist of items already sorted and the sublist of items remaining to be sorted. It finds the smallest element in the unsorted sublist and swaps it with the leftmost unsorted element, moving the sublist boundaries one element to the right.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Concept -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-secondary)">Find the minimum, Swap with the first unsorted position.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">concept.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">// Array: [64, 25, 12, 22, 11]

// Pass 1:
// Find min in [64...11] -> 11
// Swap 11 with 64 (start) -> [11, 25, 12, 22, 64]

// Pass 2:
// Find min in [25...64] -> 12
// Swap 12 with 25 -> [11, 12, 25, 22, 64]
</code></pre>
                    </div>
                </div>
            </div>

            <!-- Swap Helper -->
            <div class="card">
                <h2>2. Swap Function</h2>
                <p style="color: var(--text-secondary)">Helper to swap values.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">swap.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void swap(int &a, int &b) {
    int temp = a;
    a = b;
    b = temp;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Main Logic -->
            <div class="card">
                <h2>3. Selection Sort Function</h2>
                <p style="color: var(--text-secondary)">The core implementation.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">selection_sort.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void selectionSort(int arr[], int n) {
    for (int i = 0; i < n - 1; i++) {
        // Find min element in unsorted array
        int min_idx = i;
        for (int j = i + 1; j < n; j++) {
            if (arr[j] < arr[min_idx])
                min_idx = j;
        }

        // Swap the found minimum element with the first element
        if(min_idx != i)
            swap(arr[min_idx], arr[i]);
    }
}</code></pre>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advantages & Disadvantages -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Advantages & Disadvantages</h2>
            <div class="comparison-grid">
                <div class="pros">
                    <h3>Advantages</h3>
                    <ul>
                        <li><strong>Minimal Swaps:</strong> Makes the minimum possible number of swaps (n-1 in worst case).</li>
                        <li><strong>Simplicity:</strong> Easy to implement and understand.</li>
                        <li><strong>No Extra Memory:</strong> Operates in-place.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Slow O(n²):</strong> Inefficient for large lists.</li>
                        <li><strong>Unstable:</strong> Can change the relative order of elements with equal keys.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">💾</span>
                    <div class="example-title">Write-Heavy Memory</div>
                    <div class="example-desc">
                        Useful where writing to memory is expensive (like Flash memory) because it minimizes swaps (writes).
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">📋</span>
                    <div class="example-title">Small Lists</div>
                    <div class="example-desc">
                        Checking a small list of items (like a grocery receipt) for the cheapest item first.
                    </div>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Standard Selection Sort implementation.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">SelectionSort.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

void selectionSort(int arr[], int n) {
    for (int i = 0; i &lt; n - 1; i++) {
        // Find the minimum element in unsorted array
        int min_idx = i;
        for (int j = i + 1; j &lt; n; j++) {
            if (arr[j] &lt; arr[min_idx])
                min_idx = j;
        }

        // Swap the found minimum element with the first element
        if (min_idx != i)
            swap(arr[min_idx], arr[i]);
    }
}

void printArray(int arr[], int size) {
    for (int i = 0; i &lt; size; i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
    cout &lt;&lt; endl;
}

int main() {
    int arr[] = {64, 25, 12, 22, 11};
    int n = sizeof(arr)/sizeof(arr[0]);
    
    selectionSort(arr, n);
    cout &lt;&lt; "Sorted array: \n";
    printArray(arr, n);
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="selection_sort_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
