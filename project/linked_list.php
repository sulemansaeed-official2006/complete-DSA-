<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linked List - Concepts & Operations</title>
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
        
        .ll-node {
            display: flex;
            align-items: center;
        }
        .ll-box {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            font-weight: bold;
        }
        .ll-arrow {
            width: 20px;
            height: 2px;
            background: #cbd5e1;
            position: relative;
            margin: 0 5px;
        }
        .ll-arrow::after {
            content: '';
            position: absolute;
            right: 0;
            top: -4px;
            border: 5px solid transparent;
            border-left-color: #cbd5e1;
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
            <a href="linked_list_simulation.php" class="cta-button">🚀 Go to Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Linked List Operations</h1>
            <p class="subtitle">Understanding Dynamic Memory & Pointers</p>
        </header>

        <section class="card">
            <h2>What is a Linked List?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                A Linked List is a linear data structure where elements are not stored in contiguous memory locations. The elements are linked using pointers.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Setup Card -->
            <div class="card">
                <h2>0. Node & Class</h2>
                <p style="color: var(--text-secondary)">Define the Node structure and LinkedList class with the head pointer.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">linked_list.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">struct Node {
    int data;
    Node* next;
};

class LinkedList {
    Node* head;

public:
    LinkedList() {
        head = NULL;
    }
};</code></pre>
                    </div>
                </div>
            </div>


            <!-- Insert at Front Card -->
            <div class="card">
                <h2>1. Insert at Front</h2>
                <p style="color: var(--text-secondary)">Adds a new node at the beginning of the list.</p>
                
                <div class="mini-viz-container" id="viz-prepend"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">insert_front.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void insertAtFront(int val) {
    Node* newNode = new Node(val);
    newNode->next = head;
    head = newNode;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Insert at Last Card -->
            <div class="card">
                <h2>2. Insert at Last</h2>
                <p style="color: var(--text-secondary)">Adds a new node at the end of the list.</p>
                
                <div class="mini-viz-container" id="viz-append"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">insert_last.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void insertAtLast(int val) {
    Node* newNode = new Node(val);
    if (!head) {
        head = newNode;
        return;
    }
    Node* temp = head;
    while (temp->next) temp = temp->next;
    temp->next = newNode;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Insert at Position Card -->
            <div class="card">
                <h2>3. Insert at Position</h2>
                <p style="color: var(--text-secondary)">Inserts a node at a specific position (1-based index).</p>
                
                <div class="mini-viz-container" id="viz-insertpos"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">insert_pos.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void insertAtPosition(int val, int pos) {
    if (pos == 1) {
        insertAtFront(val);
        return;
    }
    Node* newNode = new Node(val);
    Node* temp = head;
    for (int i = 1; i < pos - 1 && temp; i++) {
        temp = temp->next;
    }
    if (!temp) return; // Position out of bounds
    newNode->next = temp->next;
    temp->next = newNode;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Delete at Front Card -->
            <div class="card">
                <h2>4. Delete at Front</h2>
                <p style="color: var(--text-secondary)">Removes the first node from the list.</p>
                
                <div class="mini-viz-container" id="viz-delstart"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">delete_front.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void deleteAtFront() {
    if (!head) return;
    Node* temp = head;
    head = head->next;
    delete temp;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Delete at Last Card -->
            <div class="card">
                <h2>5. Delete at Last</h2>
                <p style="color: var(--text-secondary)">Removes the last node from the list.</p>
                
                <div class="mini-viz-container" id="viz-dellast"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">delete_last.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void deleteAtLast() {
    if (!head) return;
    if (!head->next) {
        delete head;
        head = NULL;
        return;
    }
    Node* temp = head;
    while (temp->next->next) {
        temp = temp->next;
    }
    delete temp->next;
    temp->next = NULL;
}</code></pre>
                    </div>
                </div>
            </div>
            
            <!-- Delete at Position Card -->
            <div class="card">
                <h2>6. Delete at Position</h2>
                <p style="color: var(--text-secondary)">Removes the node at a specific position.</p>
                
                <div class="mini-viz-container" id="viz-deletepos"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">delete_pos.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void deleteAtPosition(int pos) {
    if (!head) return;
    if (pos == 1) {
        deleteAtFront();
        return;
    }
    Node* temp = head;
    for (int i = 1; i < pos - 1 && temp; i++) {
        temp = temp->next;
    }
    if (!temp || !temp->next) return;
    Node* toDelete = temp->next;
    temp->next = toDelete->next;
    delete toDelete;
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
                        <li><strong>Dynamic Size:</strong> Can grow or shrink at runtime, no fixed capacity constraint like arrays.</li>
                        <li><strong>Efficient Insertion/Deletion:</strong> Adding or removing elements does not require shifting other elements (O(1) if pointer is known).</li>
                        <li><strong>Memory Utilization:</strong> No memory is wasted for unused space, as memory is allocated only when needed.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Random Access:</strong> Cannot access elements directly by index; must traverse from the head (O(n)).</li>
                        <li><strong>Memory Overhead:</strong> Extra memory is required for storing pointers/references for each node.</li>
                        <li><strong>Cache Locality:</strong> Nodes are not stored contiguously, leading to poor cache performance.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">🖼️</span>
                    <div class="example-title">Image Viewer</div>
                    <div class="example-desc">
                        Previous and Next images are linked. A doubly linked list is perfect for navigating back and forth.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🎵</span>
                    <div class="example-title">Music Playlist</div>
                    <div class="example-desc">
                        Songs in a playlist are linked. You can easily add or remove a song from anywhere in the list.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">📃</span>
                    <div class="example-title">Undo/Redo Functionality</div>
                    <div class="example-desc">
                        Applications use linked lists to traverse through states (history) for undo and redo operations.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🚄</span>
                    <div class="example-title">Train Carriages</div>
                    <div class="example-desc">
                        A train is a real-world analogy where each carriage (node) is connected to the next one.
                    </div>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Singly Linked List with common operations.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">LinkedList.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

// Node structure
struct Node {
    int data;
    Node* next;
    Node(int val) : data(val), next(nullptr) {}
};

class LinkedList {
    Node* head;
public:
    LinkedList() : head(nullptr) {}

    // Insert at front
    void insertFront(int val) {
        Node* newNode = new Node(val);
        newNode-&gt;next = head;
        head = newNode;
    }

    // Insert at end
    void insertEnd(int val) {
        Node* newNode = new Node(val);
        if (!head) {
            head = newNode;
            return;
        }
        Node* temp = head;
        while (temp-&gt;next) temp = temp-&gt;next;
        temp-&gt;next = newNode;
    }

    // Delete value
    void deleteValue(int val) {
        if (!head) return;
        
        if (head-&gt;data == val) {
            Node* temp = head;
            head = head-&gt;next;
            delete temp;
            return;
        }

        Node* temp = head;
        while (temp-&gt;next && temp-&gt;next-&gt;data != val) {
            temp = temp-&gt;next;
        }

        if (temp-&gt;next) {
            Node* toDelete = temp-&gt;next;
            temp-&gt;next = toDelete-&gt;next;
            delete toDelete;
        }
    }

    void display() {
        Node* temp = head;
        while (temp) {
            cout &lt;&lt; temp-&gt;data &lt;&lt; " -&gt; ";
            temp = temp-&gt;next;
        }
        cout &lt;&lt; "NULL" &lt;&lt; endl;
    }
};

int main() {
    LinkedList ll;
    ll.insertEnd(10);
    ll.insertEnd(20);
    ll.insertFront(5);
    ll.display(); // 5 -> 10 -> 20 -> NULL
    
    ll.deleteValue(10);
    ll.display(); // 5 -> 20 -> NULL
    
    return 0;
}</code></pre>
                </div>
            </div>




        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="linked_list_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>

    <script>
    class Node {
        constructor(value) {
            this.value = value;
            this.next = null;
        }
    }

    class LinkedList {
        constructor() {
            this.head = null;
            this.tail = null; // Keeping tail for O(1) append
            this.size = 0;
        }

        append(value) {
            const newNode = new Node(value);
            if (!this.head) {
                this.head = newNode;
                this.tail = newNode;
            } else {
                this.tail.next = newNode;
                this.tail = newNode;
            }
            this.size++;
            return { success: true, message: `Appended: ${value}` };
        }

        prepend(value) {
            const newNode = new Node(value);
            if (!this.head) {
                this.head = newNode;
                this.tail = newNode;
            } else {
                newNode.next = this.head;
                this.head = newNode;
            }
            this.size++;
            return { success: true, message: `Prepended: ${value}` };
        }

        deleteFirst() {
            if (!this.head) return { success: false, message: 'List is empty' };

            const val = this.head.value;
            this.head = this.head.next;
            this.size--;

            if (this.size === 0) this.tail = null;

            return { success: true, message: `Deleted First: ${val}` };
        }

        deleteLast() {
            if (!this.head) return { success: false, message: 'List is empty' };

            const val = this.tail.value;

            if (this.head === this.tail) {
                this.head = null;
                this.tail = null;
            } else {
                let current = this.head;
                while (current.next !== this.tail) {
                    current = current.next;
                }
                current.next = null;
                this.tail = current;
            }
            this.size--;
            return { success: true, message: `Deleted Last: ${val}` };
        }

        getItems() {
            const items = [];
            let current = this.head;
            while (current) {
                items.push(current.value);
                current = current.next;
            }
            return items;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {

        function createNode(val) {
            const container = document.createElement('div');
            container.className = 'll-node';
            const box = document.createElement('div');
            box.className = 'll-box';
            box.innerText = val;
            container.appendChild(box);
            return container;
        }

        function addArrow(container) {
            const arrow = document.createElement('div');
            arrow.className = 'll-arrow';
            container.appendChild(arrow);
        }

        // 1. Append
        const vizAppend = document.getElementById('viz-append');
        setInterval(() => {
            vizAppend.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            base.style.alignItems = 'center';

            const n1 = createNode(10); addArrow(n1);
            const n2 = createNode(20); addArrow(n2);

            base.appendChild(n1);
            base.appendChild(n2);
            vizAppend.appendChild(base);

            setTimeout(() => {
                const n3 = createNode(30);
                n3.style.opacity = '0';
                n3.style.transform = 'translateX(20px)';
                base.appendChild(n3);
                requestAnimationFrame(() => {
                    n3.style.transition = 'all 0.5s ease';
                    n3.style.opacity = '1';
                    n3.style.transform = 'translateX(0)';
                });
            }, 500);
        }, 2000);

        // 2. Prepend
        const vizPrepend = document.getElementById('viz-prepend');
        setInterval(() => {
            vizPrepend.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            base.style.alignItems = 'center';

            const n1 = createNode(20); addArrow(n1);
            const n2 = createNode(30);

            // Wrapper for existing
            const existing = document.createElement('div');
            existing.style.display = 'flex';
            existing.style.alignItems = 'center';
            existing.appendChild(n1);
            existing.appendChild(n2);

            vizPrepend.appendChild(base);

            setTimeout(() => {
                const nNew = createNode(10); addArrow(nNew);
                nNew.style.opacity = '0';
                nNew.style.transform = 'translateX(-20px)';
                base.appendChild(nNew);
                base.appendChild(existing);

                requestAnimationFrame(() => {
                    nNew.style.transition = 'all 0.5s ease';
                    nNew.style.opacity = '1';
                    nNew.style.transform = 'translateX(0)';
                });
            }, 500);

        }, 2000);

        // 3. Insert at Position (Insert 15 at pos 2)
        const vizInsertPos = document.getElementById('viz-insertpos');
        setInterval(() => {
            vizInsertPos.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            base.style.alignItems = 'center';

            const n1 = createNode(10); addArrow(n1);
            const n2 = createNode(20);

            base.appendChild(n1);
            base.appendChild(n2);
            vizInsertPos.appendChild(base);

            setTimeout(() => {
                const nNew = createNode(15); addArrow(nNew);
                nNew.style.opacity = '0';
                nNew.style.transform = 'translateY(-20px)';
                nNew.style.position = 'absolute';
                nNew.style.left = '60px'; // Approx middle
                base.appendChild(nNew);

                requestAnimationFrame(() => {
                    nNew.style.transition = 'all 0.5s ease';
                    nNew.style.opacity = '1';
                    nNew.style.transform = 'translateY(0)';
                });
                
                // Visual cleanup after animation would go here in real app
            }, 500);
        }, 2000);

        // 4. Delete at Front
        const vizDelStart = document.getElementById('viz-delstart');
        setInterval(() => {
            vizDelStart.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            base.style.alignItems = 'center';

            const n1 = createNode(10); addArrow(n1);
            const n2 = createNode(20); addArrow(n2);
            const n3 = createNode(30);

            base.appendChild(n1);
            base.appendChild(n2);
            base.appendChild(n3);
            vizDelStart.appendChild(base);

            setTimeout(() => {
                n1.style.transition = 'all 0.5s ease';
                n1.style.opacity = '0';
                n1.style.transform = 'translateY(-20px)';
            }, 500);
        }, 2000);

        // 5. Delete at Last
        const vizDelLast = document.getElementById('viz-dellast');
        setInterval(() => {
            vizDelLast.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            base.style.alignItems = 'center';

            const n1 = createNode(10); addArrow(n1);
            const n2 = createNode(20); addArrow(n2);
            const n3 = createNode(30);

            base.appendChild(n1);
            base.appendChild(n2);
            base.appendChild(n3);
            vizDelLast.appendChild(base);

            setTimeout(() => {
                n3.style.transition = 'all 0.5s ease';
                n3.style.opacity = '0';
                n3.style.transform = 'translateY(20px)';
            }, 500);
        }, 2000);

        // 6. Delete at Position (Delete 20 at pos 2)
        const vizDeletePos = document.getElementById('viz-deletepos');
        setInterval(() => {
            vizDeletePos.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            base.style.alignItems = 'center';

            const n1 = createNode(10); addArrow(n1);
            const n2 = createNode(20); addArrow(n2);
            const n3 = createNode(30);

            base.appendChild(n1);
            base.appendChild(n2);
            base.appendChild(n3);
            vizDeletePos.appendChild(base);

            setTimeout(() => {
                n2.style.transition = 'all 0.5s ease';
                n2.style.opacity = '0';
                n2.style.transform = 'scale(0)';
            }, 500);
        }, 2000);

    });
    </script>
</html>
