<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counting Sort - Concepts & Code</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="nav-header" style="display:flex; justify-content:space-between; margin-bottom:2rem;">
            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
            <a href="count_sort_simulation.php" class="btn">🚀 Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Counting Sort Algorithm</h1>
            <p class="subtitle">A non-comparison-based sorting algorithm that works by counting the number of objects having distinct key values.</p>
        </header>

        <section class="card">
            <h2>What is Counting Sort?</h2>
            <p style="color: var(--text-muted); margin-bottom: 1rem;">
                Counting sort is an integer sorting algorithm that operates by counting the number of objects that have each distinct key value. The count of each key value is then stored in an auxiliary array, which is used to determine the positions of each key value in the output sequence. It is efficient when the range of input values (k) is not significantly greater than the number of values to be sorted (n).
            </p>
        </section>

        <div class="cards-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
            <!-- Algorithm Setup -->
            <div class="card">
                <h2>1. The Concept</h2>
                <p style="color: var(--text-muted)">We count the occurrences of each element in the input array and store them in a 'Count Array'.</p>
                
                <div class="code-content">
<pre><code class="cpp">// Basic Idea
// Input: [4, 2, 2, 8, 3, 3, 1]
// Range: 0 to 9

// 1. Count Frequencies:
// Index:  0  1  2  3  4 ... 8
// Count: [0, 1, 2, 2, 1 ... 1]

// 2. Accumulate Counts:
// Count: [0, 1, 3, 5, 6 ... 7]

// 3. Build Output:
// Place elements based on accumulated index.</code></pre>
                </div>
            </div>

            <!-- Complexity -->
            <div class="card">
                <h2>2. Complexity Analysis</h2>
                <p style="color: var(--text-muted)">Efficient for small ranges.</p>
                <div class="comparison-grid">
                    <div class="pros">
                        <h3>Time Complexity</h3>
                        <p><strong>O(n + k)</strong></p>
                        <p>Where n is the number of elements and k is the range of input.</p>
                    </div>
                    <div class="cons">
                        <h3>Space Complexity</h3>
                        <p><strong>O(n + k)</strong></p>
                        <p>Requires auxiliary space for count array and output array.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-muted); margin-bottom:15px;">Standard Counting Sort implementation.</p>
            
            <div class="code-content" style="height: 400px; overflow-y: auto;">
<pre><code class="cpp">#include &lt;iostream&gt;
#include &lt;vector&gt;
#include &lt;algorithm&gt;
using namespace std;

void countSort(vector&lt;int&gt;& arr) {
    int max = *max_element(arr.begin(), arr.end());
    int min = *min_element(arr.begin(), arr.end());
    int range = max - min + 1;

    vector&lt;int&gt; count(range), output(arr.size());

    // 1. Store count of each character
    for (int i = 0; i &lt; arr.size(); i++)
        count[arr[i] - min]++;

    // 2. Change count[i] so that count[i] now contains actual
    // position of this character in output array
    for (int i = 1; i &lt; count.size(); i++)
        count[i] += count[i - 1];

    // 3. Build the output character array
    for (int i = arr.size() - 1; i >= 0; i--) {
        output[count[arr[i] - min] - 1] = arr[i];
        count[arr[i] - min]--;
    }

    // 4. Copy the output array to arr, so that arr now
    // contains sorted characters
    for (int i = 0; i &lt; arr.size(); i++)
        arr[i] = output[i];
}

void printArray(vector&lt;int&gt;& arr) {
    for (int i = 0; i &lt; arr.size(); i++)
        cout &lt;&lt; arr[i] &lt;&lt; " ";
    cout &lt;&lt; endl;
}

int main() {
    vector&lt;int&gt; arr = { -5, -10, 0, -3, 8, 5, -1, 10 };
    countSort(arr);
    cout &lt;&lt; "Sorted array: \n";
    printArray(arr);
    return 0;
}</code></pre>
            </div>
        </section>

        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="count_sort_simulation.php" class="btn" style="padding: 15px 30px; font-size: 1.2rem;">🚀 Try the Simulation Playground</a>
        </div>
    </div>
</body>
</html>
