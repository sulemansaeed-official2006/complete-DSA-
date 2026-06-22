<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Search - Concepts & Code</title>
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
            <a href="linear_search_simulation.php" class="cta-button">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Linear Search Algorithm</h1>
            <p class="subtitle">The simplest search algorithm: checks every element until the target is found.</p>
        </header>

        <section class="card">
            <h2>What is Linear Search?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                Linear Search sequentially checks each element of the list until a match is found or the whole list has been searched. It works on both sorted and unsorted lists.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Concept -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-secondary)">Iterate through the array and compare each element with the target.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">concept.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">// Array: [10, 50, 30, 70, 80, 20]
// Target: 30

// Index 0: Is 10 == 30? No.
// Index 1: Is 50 == 30? No.
// Index 2: Is 30 == 30? Yes! Return Index 2.</code></pre>
                    </div>
                </div>
            </div>

            <!-- Main Logic -->
            <div class="card">
                <h2>2. Linear Search Function</h2>
                <p style="color: var(--text-secondary)">Function returns index if found, else -1.</p>
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">linear_search.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int linearSearch(int arr[], int n, int target) {
    for (int i = 0; i < n; i++) {
        if (arr[i] == target)
            return i;
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
                        <li><strong>Universal:</strong> Works on unsorted and sorted arrays alike.</li>
                        <li><strong>Simple:</strong> Very easy to implement.</li>
                        <li><strong>No Preprocessing:</strong> Does not require the array to be sorted first.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Slow O(n):</strong> Inefficient for large datasets compared to Binary Search.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">👕</span>
                    <div class="example-title">Finding an Item</div>
                    <div class="example-desc">
                        Looking for a specific shirt in a pile of unsorted laundry.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">📝</span>
                    <div class="example-title">Simple Check</div>
                    <div class="example-desc">
                        Scanning a grocery list to see if "Milk" is written on it.
                    </div>
                </div>
            </div>
        </section>

        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="linear_search_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
