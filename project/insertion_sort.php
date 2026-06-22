<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion Sort - Concepts & Code</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
     <style>
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem; margin-top: 2rem; }
        .cta-button { display: inline-block; margin-top: 2rem; padding: 1rem 2rem; background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); color: white; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 1.2rem; box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4); transition: all 0.3s ease; }
        .cta-button:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(102, 126, 234, 0.6); }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem;">
            <a href="dashboard.php" class="back-link" style="color:var(--text-secondary); text-decoration:none;">← Back to Dashboard</a>
            <a href="insertion_sort_simulation.php" class="cta-button">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Insertion Sort Algorithm</h1>
            <p class="subtitle">Builds the sorted array one item at a time, similar to sorting playing cards in your hand.</p>
        </header>

        <section class="card">
            <h2>What is Insertion Sort?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Insertion Sort works by taking elements from the unsorted part and inserting them into the correct position in the sorted part. It is efficient for small data sets and works like sorting cards in your hand: you pick a card, shift the greater cards to the right, and place the card in its spot.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Concept -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-secondary)">Pick key, Shift elements > key, Insert key.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">concept.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">// Array: [12, 11, 13, 5, 6]
// Sorted Part | Unsorted Part

// Pass 1: Key = 11
// Is 12 > 11? Yes. Shift 12 to right.
// Insert 11. -> [11, 12, 13, 5, 6]

// Pass 2: Key = 13
// Is 12 > 13? No. Insert 13. -> [11, 12, 13, 5, 6]

// Pass 3: Key = 5
// Shift 13, 12, 11... Insert 5 -> [5, 11, 12, 13, 6]</code></pre>
                    </div>
                </div>
            </div>

            <!-- Main Logic -->
            <div class="card">
                <h2>2. Insertion Sort Function</h2>
                <p style="color: var(--text-secondary)">The core implementation.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">insertion_sort.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void insertionSort(int arr[], int n) {
    for (int i = 1; i < n; i++) {
        int key = arr[i];
        int j = i - 1;

        // Move elements of arr[0..i-1] that are greater than key
        // to one position ahead of their current position
        while (j >= 0 && arr[j] > key) {
            arr[j + 1] = arr[j];
            j = j - 1;
        }
        arr[j + 1] = key;
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
                        <li><strong>Adaptive:</strong> Efficient for data sets that are already substantially sorted.</li>
                        <li><strong>Stable:</strong> Does not change the relative order of elements with equal keys.</li>
                        <li><strong>Online:</strong> Can sort adjacent elements as they receive it.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Slow O(n²):</strong> Inefficient for large lists.</li>
                        <li><strong>Shifting:</strong> Requires many shifts for reverse-sorted data.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">🃏</span>
                    <div class="example-title">Card Games</div>
                    <div class="example-desc">
                        Sorting a hand of playing cards is the classic example of Insertion Sort.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">📡</span>
                    <div class="example-title">Live Data</div>
                    <div class="example-desc">
                        Sorting data as it arrives in real-time (online algorithm), e.g., incoming network packets.
                    </div>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Standard Insertion Sort implementation.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">InsertionSort.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

void insertionSort(int arr[], int n) {
    for (int i = 1; i &lt; n; i++) {
        int key = arr[i];
        int j = i - 1;

        // Move elements of arr[0..i-1], that are greater than key,
        // to one position ahead of their current position
        while (j &gt;= 0 && arr[j] &gt; key) {
            arr[j + 1] = arr[j];
            j = j - 1;
        }
        arr[j + 1] = key;
    }
}

void printArray(int arr[], int size) {
    for (int i = 0; i &lt; size; i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
    cout &lt;&lt; endl;
}

int main() {
    int arr[] = {12, 11, 13, 5, 6};
    int n = sizeof(arr)/sizeof(arr[0]);
    
    insertionSort(arr, n);
    cout &lt;&lt; "Sorted array: \n";
    printArray(arr, n);
    return 0;
}</code></pre>
                </div>
            </div>


        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="insertion_sort_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
