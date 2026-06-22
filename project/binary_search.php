<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Search - Concepts & Code</title>
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
            <a href="binary_search_simulation.php" class="cta-button">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Binary Search Algorithm</h1>
            <p class="subtitle">A highly efficient O(log n) search algorithm for sorted arrays.</p>
        </header>

        <section class="card">
            <h2>What is Binary Search?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Binary Search finds the position of a target value within a **sorted** array. It works by repeatedly dividing the search interval in half. If the value of the search key is less than the item in the middle of the interval, narrow the interval to the lower half. Otherwise, narrow it to the upper half.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Concept -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-secondary)">Divide and Conquer approach.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">concept.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">// Sorted Array: [2, 5, 8, 12, 16, 23, 38, 56, 72, 91]
// Target: 23

// L=0, R=9, Mid=4 (Val=16). 16 < 23.
// Move L to Mid+1 (5). Range: [23...91]

// L=5, R=9, Mid=7 (Val=56). 56 > 23.
// Move R to Mid-1 (6). Range: [23...38]

// L=5, R=6, Mid=5 (Val=23). 23 == 23. Found!</code></pre>
                    </div>
                </div>
            </div>

            <!-- Iterative Logic -->
            <div class="card">
                <h2>2. Iterative Implementation</h2>
                <p style="color: var(--text-secondary)">Standard loop-based approach.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">binary_search.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int binarySearch(int arr[], int l, int r, int x) {
    while (l <= r) {
        int m = l + (r - l) / 2;

        // Check if x is present at mid
        if (arr[m] == x) return m;

        // If x greater, ignore left half
        if (arr[m] < x) l = m + 1;

        // If x is smaller, ignore right half
        else r = m - 1;
    }
    return -1;
}</code></pre>
                    </div>
                </div>
            </div>
            
            <!-- Recursive Logic -->
             <div class="card">
                <h2>3. Recursive Implementation</h2>
                <p style="color: var(--text-secondary)">Elegant recursive approach.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">binary_search_rec.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int binarySearchRec(int arr[], int l, int r, int x) {
    if (r >= l) {
        int mid = l + (r - l) / 2;
        if (arr[mid] == x) return mid;
        if (arr[mid] > x) return binarySearchRec(arr, l, mid - 1, x);
        return binarySearchRec(arr, mid + 1, r, x);
    }
    return -1;
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
                        <li><strong>Fast O(log n):</strong> Extremely efficient for large datasets.</li>
                        <li><strong>Standard:</strong> Default search method for sorted collections in most libraries.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Prerequisite:</strong> The list MUST be sorted first.</li>
                        <li><strong>Complexity:</strong> Slightly more complex logic to implement correctly than linear search.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">📖</span>
                    <div class="example-title">Dictionary</div>
                    <div class="example-desc">
                        Finding a word in a physical dictionary by flipping to the middle, then deciding to go left or right.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🗄️</span>
                    <div class="example-title">Databases</div>
                    <div class="example-desc">
                        DBs use trees (B-Trees) which are essentially dynamic binary search structures to find records fast.
                    </div>
                </div>
            </div>
        </section>

        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="binary_search_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
