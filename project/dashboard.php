<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2e8b57;
            --secondary: #3cb371;
            --bg-body: #f0f2f5;
            --bg-card: #ffffff;
            --text-main: #333;
            --text-muted: #666;
            --border: #2e8b57;
            --shadow-card: 0 4px 6px rgba(0,0,0,0.05);
            --shadow-hover: 0 10px 20px rgba(46,139,87,0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body { 
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        a { text-decoration: none; color: inherit; transition: color 0.3s; }

        /* HEADER */
        .navbar {
            background: #fff;
            height: 80px; padding: 0 5%;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 2px solid var(--primary);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky; top: 0; z-index: 1000;
        }

        .brand {
            font-size: 24px; font-weight: 700;
            color: var(--primary);
            display: flex; align-items: center; gap: 10px;
        }
        
        .brand-icon {
            color: var(--primary); 
            font-size: 24px;
        }

        .nav-items { display: flex; gap: 30px; align-items: center; }
        
        /* Profile */
        .avatar {
            width: 40px; height: 40px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none; position: absolute; right: 0; top: 60px;
            background: #fff;
            width: 200px;
            border: 1px solid #eee;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 2000;
        }

        .dropdown-item {
            padding: 12px 16px;
            display: flex; align-items: center; gap: 10px;
            color: var(--text-main);
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }
        .dropdown-item:hover { background-color: #f8f9fa; color: var(--primary); }

        /* MAIN */
        .container { 
            flex: 1; max-width: 1200px; margin: 0 auto; padding: 40px 20px; width: 100%; 
        }

        .hero-section { text-align: center; margin-bottom: 50px; }
        .hero-title { 
            font-size: 36px; font-weight: 700; color: var(--text-main); margin-bottom: 10px; 
        }
        .hero-subtitle { color: var(--text-muted); font-size: 16px; }

        /* Search */
        .search-container {
            margin: 30px auto; max-width: 500px; position: relative;
        }
        .search-input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            font-size: 16px;
            border: 2px solid #eee;
            border-radius: 50px;
            outline: none;
            transition: all 0.3s;
        }
        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(46, 139, 87, 0.1);
        }
        .search-icon-inside {
            position: absolute; left: 20px; top: 50%; transform: translateY(-50%);
            color: #aaa;
        }

        /* Sections */
        .section-header { 
            margin: 50px 0 20px; 
            display: flex; align-items: center; gap: 15px; 
        }
        .section-title { 
            font-size: 20px; font-weight: 600; color: var(--primary); 
            text-transform: uppercase; letter-spacing: 1px;
        }
        .section-line { flex: 1; height: 1px; background: #eee; }

        .tools-grid { 
            display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; 
        }

        /* Cards */
        .tool-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
            background: #fff;
        }
        
        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--secondary);
        }

        .icon-box {
            width: 50px; height: 50px;
            background: rgba(46, 139, 87, 0.1);
            border-radius: 10px;
            display: flex; justify-content: center; align-items: center;
            font-size: 24px; color: var(--primary);
            margin-bottom: 15px;
        }

        .tool-card h3 { font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text-main); }
        .tool-card p { font-size: 14px; color: var(--text-muted); margin-bottom: 20px; line-height: 1.5; }

        .btn-card {
            display: inline-block;
            width: 100%;
            padding: 10px;
            background: white;
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
            transition: 0.3s;
        }
        .btn-card:hover {
            background: var(--primary);
            color: white;
        }

        /* Footer */
        .footer {
            background: #f8f9fa;
            border-top: 1px solid #eee;
            padding: 40px 5%;
            margin-top: auto;
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
        }

    </style>
</head>
<body>

    <nav class="navbar">
        <div class="brand">
            <div class="brand-icon"><i class="fa-solid fa-code"></i></div>
            DSA Visualization
        </div>

        <div class="nav-items">
            <div class="profile-wrapper" onclick="toggleDropdown()">
                <div class="avatar">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                </div>
                
                <div class="dropdown-menu" id="userDropdown">
                    <div style="padding: 16px 24px; border-bottom: 1px solid var(--border);">
                        <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Signed in as</div>
                        <div style="font-weight: 600; color: var(--text-main);"><?php echo htmlspecialchars($_SESSION['user_name']); ?></div>
                    </div>
                    <a href="history.php" class="dropdown-item">
                        <i class="fa-solid fa-clock-rotate-left"></i> History
                    </a>
                    <a href="profile.php" class="dropdown-item">
                        <i class="fa-regular fa-id-card"></i> Account
                    </a>
                    <a href="logout.php" class="dropdown-item danger">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        
        <div class="hero-section">
            <h1 class="hero-title">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
            <p class="hero-subtitle">Explore data structures and visualize algorithms in real-time.</p>
        </div>

        <!-- SEARCH BAR -->
        <div class="search-container">
            <input type="text" id="toolSearch" class="search-input" placeholder="Search algorithms..." onkeyup="filterTools()">
            <i class="fa-solid fa-magnifying-glass search-icon-inside"></i>
        </div>
        
        <div class="section-header">
            <span class="section-title">Linear Data Structures</span>
            <div class="section-line"></div>
        </div>
        
        <div class="tools-grid">
            <!-- Queue -->
            <div class="tool-card">
                <div class="icon-box icon-orange"><i class="fa-solid fa-layer-group"></i></div>
                <h3>Queue (FIFO)</h3>
                <p>Enqueue and Dequeue operations visualized step-by-step.</p>
                <a href="queue.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Stack -->
            <div class="tool-card">
                <div class="icon-box icon-red"><i class="fa-solid fa-layer-group" style="transform: rotate(180deg);"></i></div>
                <h3>Stack (LIFO)</h3>
                <p>Push, Pop, and Peek operations with vertical interactive stacks.</p>
                <a href="stack.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Circular Queue -->
             <div class="tool-card">
                <div class="icon-box icon-blue"><i class="fa-solid fa-spinner"></i></div>
                <h3>Circular Queue</h3>
                <p>Ring buffer visualization with head and tail pointers.</p>
                <a href="circular_queue.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

             <!-- Linked List -->
             <div class="tool-card">
                <div class="icon-box icon-purple"><i class="fa-solid fa-diagram-project"></i></div>
                <h3>Linked List</h3>
                <p>Insert, delete, and traverse nodes in a dynamic list.</p>
                <a href="linked_list.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="section-header">
            <span class="section-title">Sorting Algorithms</span>
            <div class="section-line"></div>
        </div>

        <div class="tools-grid">
            <!-- Bubble Sort -->
            <div class="tool-card">
                <div class="icon-box icon-blue"><i class="fa-solid fa-soap"></i></div>
                <h3>Bubble Sort</h3>
                <p>Simple sorting by repeatedly stepping through the list.</p>
                <a href="bubble_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Selection Sort -->
            <div class="tool-card">
                <div class="icon-box icon-blue"><i class="fa-solid fa-check-double"></i></div>
                <h3>Selection Sort</h3>
                <p>Repeatedly finding the minimum element from unsorted part.</p>
                <a href="selection_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Insertion Sort -->
            <div class="tool-card">
                <div class="icon-box icon-blue"><i class="fa-solid fa-arrow-right-to-bracket"></i></div>
                <h3>Insertion Sort</h3>
                <p>Builds the final sorted array one item at a time.</p>
                <a href="insertion_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Quick Sort -->
            <div class="tool-card">
                <div class="icon-box icon-orange"><i class="fa-solid fa-bolt"></i></div>
                <h3>Quick Sort</h3>
                <p>Divide and conquer algorithm using a pivot element.</p>
                <a href="quick_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Merge Sort -->
             <div class="tool-card">
                <div class="icon-box icon-purple"><i class="fa-solid fa-code-merge"></i></div>
                <h3>Merge Sort</h3>
                <p> efficient, stable, comparison-based sorting algorithm.</p>
                <a href="merge_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Count Sort -->
            <div class="tool-card">
                <div class="icon-box icon-purple"><i class="fa-solid fa-arrow-down-1-9"></i></div>
                <h3>Count Sort</h3>
                <p>Non-comparison sort using frequency counting.</p>
                <a href="count_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Radix Sort -->
            <div class="tool-card">
                <div class="icon-box icon-purple"><i class="fa-solid fa-layer-group"></i></div>
                <h3>Radix Sort</h3>
                <p>Integer sorting by processing individual digits.</p>
                <a href="radix_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- Bucket Sort -->
            <div class="tool-card">
                <div class="icon-box icon-purple"><i class="fa-solid fa-box-open"></i></div>
                <h3>Bucket Sort</h3>
                <p>Scatter-gather approach for uniform distributions.</p>
                <a href="bucket_sort.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        
        <div class="section-header">
            <span class="section-title">Searching Algorithms</span>
            <div class="section-line"></div>
        </div>
        
        <div class="tools-grid">
             <!-- Linear Search -->
            <div class="tool-card">
                <div class="icon-box icon-green"><i class="fa-solid fa-list-ol"></i></div>
                <h3>Linear Search</h3>
                <p>Sequential search algorithm.</p>
                <a href="linear_search.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            
            <!-- Binary Search -->
            <div class="tool-card">
                <div class="icon-box icon-green"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                <h3>Binary Search</h3>
                <p>Search in a sorted array by repeated division.</p>
                <a href="binary_search.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="section-header" style="margin-top: 50px;">
            <span class="section-title">Tree Data Structures</span>
            <div class="section-line"></div>
        </div>
        
        <div class="tools-grid">
            <!-- Trees -->
            <div class="tool-card">
                <div class="icon-box icon-green"><i class="fa-solid fa-network-wired"></i></div>
                <h3>Trees</h3>
                <p>Binary Search Trees and Traversals.</p>
                <a href="tree.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

             <!-- AVL Trees -->
             <div class="tool-card">
                <div class="icon-box" style="background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%); color: #0891b2;"><i class="fa-solid fa-scale-balanced"></i></div>
                <h3>AVL Tree</h3>
                <p>Self-balancing BST with Rotations (LL, RR, LR, RL).</p>
                <a href="avl_tree.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

             <!-- Heaps -->
             <div class="tool-card">
                <div class="icon-box icon-blue"><i class="fa-solid fa-cubes-stacked"></i></div>
                <h3>Heaps</h3>
                <p>Max/Min heap construction and operations.</p>
                <a href="heap.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
        
        <div class="section-header" style="margin-top: 50px;">
            <span class="section-title">Graph Algorithms</span>
            <div class="section-line"></div>
        </div>
        
        <div class="tools-grid">
             <!-- Graphs -->
            <div class="tool-card">
                <div class="icon-box icon-blue"><i class="fa-solid fa-share-nodes"></i></div>
                <h3>Graphs</h3>
                <p>BFS, DFS and Adjacency representations.</p>
                <a href="graph.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

             <!-- Dijkstra -->
            <div class="tool-card">
                <div class="icon-box icon-red"><i class="fa-solid fa-route"></i></div>
                <h3>Dijkstra's Algo</h3>
                <p>Finding the shortest paths between nodes in a graph.</p>
                <a href="dijkstra.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <!-- MST -->
            <div class="tool-card">
                <div class="icon-box icon-green"><i class="fa-solid fa-bezier-curve"></i></div>
                <h3>MST</h3>
                <p>Minimum Spanning Tree visualization (Prim's/Kruskal's).</p>
                <a href="mst.php" class="btn-card">Launch <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- PROFESSIONAL FOOTER -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="brand" style="margin-bottom: 20px; font-size: 20px;">
                    <span style="color: var(--primary);">Algo</span>NEXUS
                </div>
                <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 20px;">
                    <strong>The Central Hub of Algorithms.</strong><br>
                    An advanced interactive platform for mastering data structures and algorithms through real-time visualization.
                </p>
                <a href="https://www.linkedin.com/in/muhammad-usman-7739a8229?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; color: #0a66c2; font-weight: 600; background: rgba(10, 102, 194, 0.1); padding: 8px 16px; border-radius: 8px; transition: 0.3s;">
                    <i class="fa-brands fa-linkedin"></i> Connect on LinkedIn
                </a>
            </div>
            
            <div class="footer-col">
                <h4>Quick Links</h4>
                <div class="footer-links">
                    <a href="dashboard.php">Dashboard</a>
                    <a href="profile.php">My Profile</a>
                    <a href="history.php">Learning History</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            
            <div class="footer-col">
                <h4>Resources</h4>
                <div class="footer-links">
                    <a href="#">Documentation</a>
                    <a href="#">Algorithm Wiki</a>
                    <a href="#">Report a Bug</a>
                    <a href="#">Contact Support</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            &copy; 2025 AlgoNEXUS Professional. All rights reserved.
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const menu = document.getElementById("userDropdown");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }
        
        window.addEventListener('click', function(e) {
            if (!document.querySelector('.profile-wrapper').contains(e.target)) {
                document.getElementById("userDropdown").style.display = 'none';
            }
        });

        function filterTools() {
            const input = document.getElementById('toolSearch');
            const filter = input.value.toUpperCase();
            const cards = document.querySelectorAll('.tool-card');

            cards.forEach(card => {
                const title = card.querySelector('h3');
                const desc = card.querySelector('p');
                const txtValue = title.textContent || title.innerText;
                const descValue = desc.textContent || desc.innerText;

                if (txtValue.toUpperCase().indexOf(filter) > -1 || descValue.toUpperCase().indexOf(filter) > -1) {
                    card.style.display = "";
                    card.style.animation = "fadeInUp 0.5s ease-out"; 
                } else {
                    card.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>