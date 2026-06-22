<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radix Sort - Concepts & Code</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem;">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="radix_sort_simulation.php" class="btn">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Radix Sort Algorithm</h1>
            <p class="subtitle">A non-comparison sorting algorithm that avoids comparison by creating and distributing elements into buckets according to their radix.</p>
        </header>

        <section class="card">
            <h2>What is Radix Sort?</h2>
            <p style="color: var(--text-muted); margin-bottom: 1rem;">
                Radix Sort sorts numbers by processing individual digits. It processes digits from the least significant digit (LSD) to the most significant digit (MSD). For each digit, it uses a stable sorting algorithm (usually Counting Sort) to order the elements.
            </p>
        </section>

        <div class="cards-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
            <!-- Algorithm Setup -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-muted)">Sort by Ones place, then Tens place, then Hundreds place...</p>
                
                <div class="code-content">
<pre><code class="cpp">// Example: [170, 45, 75, 90, 802, 24, 2, 66]

// 1. Sort by Ones (LSD):
// [170, 90, 802, 2, 24, 45, 75, 66]

// 2. Sort by Tens:
// [802, 2, 24, 45, 66, 170, 75, 90]

// 3. Sort by Hundreds (MSD):
// [2, 24, 45, 66, 75, 90, 170, 802]</code></pre>
                </div>
            </div>

            <!-- Complexity -->
            <div class="card">
                <h2>2. Complexity Analysis</h2>
                <p style="color: var(--text-muted)">Efficient for integers with fixed number of digits.</p>
                <div class="comparison-grid">
                    <div class="pros">
                        <h3>Time Complexity</h3>
                        <p><strong>O(d * (n + b))</strong></p>
                        <p>d = digits, n = elements, b = base (10).</p>
                    </div>
                    <div class="cons">
                        <h3>Space Complexity</h3>
                        <p><strong>O(n + b)</strong></p>
                        <p>Uses extra space for the buckets/counts.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-muted); margin-bottom:15px;">Standard LSD Radix Sort using Counting Sort.</p>
            
            <div class="code-content" style="height: 400px; overflow-y: auto;">
<pre><code class="cpp">#include &lt;iostream&gt;
#include &lt;vector&gt;
#include &lt;algorithm&gt;
using namespace std;

// A utility function to get maximum value in arr[]
int getMax(int arr[], int n) {
    int mx = arr[0];
    for (int i = 1; i &lt; n; i++)
        if (arr[i] > mx)
            mx = arr[i];
    return mx;
}

// A function to do counting sort of arr[] according to
// the digit represented by exp.
void countSort(int arr[], int n, int exp) {
    int output[n]; 
    int i, count[10] = { 0 };

    // Store count of occurrences in count[]
    for (i = 0; i &lt; n; i++)
        count[(arr[i] / exp) % 10]++;

    // Change count[i] so that count[i] now contains actual
    // position of this digit in output[]
    for (i = 1; i &lt; 10; i++)
        count[i] += count[i - 1];

    // Build the output array
    for (i = n - 1; i >= 0; i--) {
        output[count[(arr[i] / exp) % 10] - 1] = arr[i];
        count[(arr[i] / exp) % 10]--;
    }

    // Copy the output array to arr[], so that arr[] now
    // contains sorted numbers according to current digit
    for (i = 0; i < n; i++)
        arr[i] = output[i];
}

// The main function to that sorts arr[] of size n using 
// Radix Sort
void radixsort(int arr[], int n) {
    int m = getMax(arr, n);

    // Do counting sort for every digit. Note that instead
    // of passing digit number, exp is passed. exp is 10^i
    // where i is current digit number
    for (int exp = 1; m / exp > 0; exp *= 10)
        countSort(arr, n, exp);
}

void print(int arr[], int n) {
    for (int i = 0; i &lt; n; i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
}

int main() {
    int arr[] = { 170, 45, 75, 90, 802, 24, 2, 66 };
    int n = sizeof(arr) / sizeof(arr[0]);
    radixsort(arr, n);
    print(arr, n);
    return 0;
}</code></pre>
            </div>
        </section>

        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="radix_sort_simulation.php" class="btn" style="padding: 15px 30px; font-size: 1.2rem;">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
