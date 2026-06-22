<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bubble Sort - Concepts & Code</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .mini-viz-container {
            height: 100px;
            background: rgba(0,0,0,0.5);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem 0;
            border: 1px dashed var(--text-muted);
        }
        .bar {
            width: 20px;
            background: var(--primary);
            margin: 0 2px;
            transition: height 0.3s;
            box-shadow: 0 0 5px var(--primary);
        }
        
        .cta-button {
            display: inline-block;
            margin-top: 2rem;
            padding: 1rem 2rem;
            background: transparent;
            color: var(--primary);
            text-decoration: none;
            border: 2px solid var(--primary);
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-family: 'Orbitron', sans-serif;
            transition: all 0.3s ease;
            clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px);
        }
        .cta-button:hover {
            background: var(--primary);
            color: black;
            box-shadow: 0 0 20px var(--primary);
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem;">
            <a href="dashboard.php" class="back-link" style="color:var(--text-secondary); text-decoration:none;">← Back to Dashboard</a>
            <a href="bubble_sort_simulation.php" class="cta-button">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Bubble Sort Algorithm</h1>
            <p class="subtitle">The simplest sorting algorithm that works by repeatedly swapping adjacent elements.</p>
        </header>

        <section class="card">
            <h2>What is Bubble Sort?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Bubble Sort is a simple sorting algorithm that checks each pair of adjacent elements. If they are in the wrong order, it swaps them. This process repeats until the list is sorted. It's named "Bubble Sort" because smaller elements "bubble" to the top of the list like air bubbles in water.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Algorithm Setup -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-secondary)">We iterate through the array multiple times. In each pass, we push the largest unsorted element to its correct position at the end.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">concept.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">// Basic Idea
// Array: [5, 1, 4, 2, 8]

// Pass 1:
// Compare 5, 1 -> Swap -> [1, 5, 4, 2, 8]
// Compare 5, 4 -> Swap -> [1, 4, 5, 2, 8]
// Compare 5, 2 -> Swap -> [1, 4, 2, 5, 8]
// Compare 5, 8 -> No Swap -> [1, 4, 2, 5, 8]
// 8 is now sorted at the end.</code></pre>
                    </div>
                </div>
            </div>

            <!-- Swap Function -->
            <div class="card">
                <h2>2. Swap Helper</h2>
                <p style="color: var(--text-secondary)">A helper function to swap two elements in the array.</p>
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

            <!-- Main Algorithm -->
            <div class="card">
                <h2>3. Bubble Sort Function</h2>
                <p style="color: var(--text-secondary)">The main loop logic.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">bubble_sort.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void bubbleSort(int arr[], int n) {
    for (int i = 0; i < n - 1; i++) {
        // Last i elements are already in place
        for (int j = 0; j < n - i - 1; j++) {
            if (arr[j] > arr[j + 1]) {
                swap(arr[j], arr[j + 1]);
            }
        }
    }
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Optimization -->
            <div class="card">
                <h2>4. Optimized Version</h2>
                <p style="color: var(--text-secondary)">If no swaps occur in a pass, the array is already sorted.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">optimized.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void optimizedBubbleSort(int arr[], int n) {
    bool swapped;
    for (int i = 0; i < n - 1; i++) {
        swapped = false;
        for (int j = 0; j < n - i - 1; j++) {
            if (arr[j] > arr[j + 1]) {
                swap(arr[j], arr[j + 1]);
                swapped = true;
            }
        }
        // If no two elements were swapped
        // by inner loop, then break
        if (swapped == false)
            break;
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
                        <li><strong>Simplicity:</strong> Easy to understand and implement.</li>
                        <li><strong>No Extra Space:</strong> Sorts in-place (O(1) space complexity).</li>
                        <li><strong>Stable:</strong> Does not change the relative order of elements with equal keys.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Slow Performance:</strong> O(n²) time complexity makes it inefficient for large datasets.</li>
                        <li><strong>Too Many Swaps:</strong> Performs more swaps than other O(n²) algorithms like Selection Sort.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">👨‍🏫</span>
                    <div class="example-title">Education</div>
                    <div class="example-desc">
                        Used primarily to teach the concept of sorting algorithms to computer science students.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🤏</span>
                    <div class="example-title">Small Datasets</div>
                    <div class="example-desc">
                        Can be efficient enough for very small or nearly sorted lists where overhead of complex algorithms is unnecessary.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🖥️</span>
                    <div class="example-title">Computer Graphics</div>
                    <div class="example-desc">
                        Sometimes used in polygon filling algorithms where edges need to be sorted by x-coordinate.
                    </div>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Optimized Bubble Sort implementation.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">BubbleSort.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

void bubbleSort(int arr[], int n) {
    bool swapped;
    for (int i = 0; i &lt; n - 1; i++) {
        swapped = false;
        for (int j = 0; j &lt; n - i - 1; j++) {
            if (arr[j] &gt; arr[j + 1]) {
                swap(arr[j], arr[j + 1]);
                swapped = true;
            }
        }
        // If no two elements were swapped by inner loop, then break
        if (!swapped)
            break;
    }
}

void printArray(int arr[], int size) {
    for (int i = 0; i &lt; size; i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
    cout &lt;&lt; endl;
}

int main() {
    int arr[] = {64, 34, 25, 12, 22, 11, 90};
    int n = sizeof(arr)/sizeof(arr[0]);
    
    bubbleSort(arr, n);
    cout &lt;&lt; "Sorted array: \n";
    printArray(arr, n);
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="bubble_sort_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
