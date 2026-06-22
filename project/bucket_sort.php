<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucket Sort - Concepts & Code</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem;">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="bucket_sort_simulation.php" class="btn">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Bucket Sort Algorithm</h1>
            <p class="subtitle">A distribution sort that works by scattering elements into buckets, sorting each bucket, and obtaining the final result.</p>
        </header>

        <section class="card">
            <h2>What is Bucket Sort?</h2>
            <p style="color: var(--text-muted); margin-bottom: 1rem;">
                Bucket sort, or bin sort, is a sorting algorithm that works by distributing the elements of an array into a number of buckets. Each bucket is then sorted individually, either using a different sorting algorithm, or by recursively applying the bucket sorting algorithm. It is most effective when input is uniformly distributed over a range.
            </p>
        </section>

        <div class="cards-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
            <!-- Algorithm Setup -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-muted)">Scatter to buckets, Sort buckets, Confirm order.</p>
                
                <div class="code-content">
<pre><code class="cpp">// Example: [0.78, 0.17, 0.39, 0.26, 0.72, 0.94]

// 1. Create Buckets (e.g. 10 buckets for range 0-1)
// 2. Scatter:
// Bucket 1: [0.17]
// Bucket 2: [0.26]
// Bucket 3: [0.39]
// Bucket 7: [0.78, 0.72]
// Bucket 9: [0.94]

// 3. Sort Buckets:
// Bucket 7 becomes [0.72, 0.78]

// 4. Gather:
// [0.17, 0.26, 0.39, 0.72, 0.78, 0.94]</code></pre>
                </div>
            </div>

            <!-- Complexity -->
            <div class="card">
                <h2>2. Complexity Analysis</h2>
                <p style="color: var(--text-muted)">Depends on distribution and inner sort.</p>
                <div class="comparison-grid">
                    <div class="pros">
                        <h3>Time Complexity</h3>
                        <p><strong>O(n + k)</strong></p>
                        <p>Average case when uniformly distributed.</p>
                    </div>
                    <div class="cons">
                        <h3>Space Complexity</h3>
                        <p><strong>O(n)</strong></p>
                        <p>Requires extra space for buckets.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-muted); margin-bottom:15px;">Bucket Sort for floating point numbers.</p>
            
            <div class="code-content" style="height: 400px; overflow-y: auto;">
<pre><code class="cpp">#include &lt;iostream&gt;
#include &lt;algorithm&gt;
#include &lt;vector&gt;
using namespace std;

void bucketSort(float arr[], int n) {
    // 1. Create n empty buckets
    vector&lt;float&gt; b[n];

    // 2. Put array elements in different buckets
    for (int i = 0; i &lt; n; i++) {
        int bi = n * arr[i]; // Index in bucket
        b[bi].push_back(arr[i]);
    }

    // 3. Sort individual buckets
    for (int i = 0; i &lt; n; i++)
        sort(b[i].begin(), b[i].end());

    // 4. Concatenate all buckets into arr[]
    int index = 0;
    for (int i = 0; i &lt; n; i++)
        for (int j = 0; j &lt; b[i].size(); j++)
            arr[index++] = b[i][j];
}

int main() {
    float arr[] = { 0.897, 0.565, 0.656, 0.1234, 0.665, 0.3434 };
    int n = sizeof(arr) / sizeof(arr[0]);
    bucketSort(arr, n);

    cout &lt;&lt; "Sorted array is \n";
    for (int i = 0; i &lt; n; i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
    return 0;
}</code></pre>
            </div>
        </section>

        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="bucket_sort_simulation.php" class="btn" style="padding: 15px 30px; font-size: 1.2rem;">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
