<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circular Queue - Concepts & Operations</title>
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
        
        /* Circular specific styles for mini-viz */
        .cq-ring {
            width: 100px;
            height: 100px;
            border: 4px solid #334155;
            border-radius: 50%;
            position: relative;
        }
        .cq-item {
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
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
            <a href="circular_queue_simulation.php" class="cta-button">🚀 Go to Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Circular Queue Operations</h1>
            <p class="subtitle">Efficient Queue Implementation using Circular Array</p>
        </header>

        <section class="card">
            <h2>What is a Circular Queue?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                A Circular Queue is a linear data structure in which the operations are performed based on FIFO (First In First Out) principle and the last position is connected back to the first position to make a circle. It is also called "Ring Buffer".
            </p>
        </section>

        <div class="cards-grid">
            <!-- Setup Card -->
            <div class="card">
                <h2>0. Class Setup</h2>
                <p style="color: var(--text-secondary)">Define the class and initialize front/rear pointers.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">circular_queue.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">#define SIZE 5

class CircularQueue {
    int front, rear;
    int items[SIZE];

public:
    CircularQueue() {
        front = -1;
        rear = -1;
    }
};</code></pre>
                    </div>
                </div>
            </div>
            <!-- Enqueue Card -->
            <div class="card">
                <h2>1. Enqueue(x)</h2>
                <p style="color: var(--text-secondary)">Adds an element <code>x</code> to the rear. If rear reaches end, it wraps around.</p>
                
                <div class="mini-viz-container" id="viz-enqueue"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">enqueue.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void enqueue(int x) {
    if ((rear + 1) % size == front) {
        cout << "Queue Overflow";
        return;
    }
    if (front == -1) front = 0;
    rear = (rear + 1) % size;
    arr[rear] = x;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Dequeue Card -->
            <div class="card">
                <h2>2. Dequeue()</h2>
                <p style="color: var(--text-secondary)">Removes element from front. If front reaches end, it wraps around.</p>
                
                <div class="mini-viz-container" id="viz-dequeue"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">dequeue.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int dequeue() {
    if (front == -1) {
        cout << "Queue Underflow";
        return -1;
    }
    int val = arr[front];
    if (front == rear) front = rear = -1;
    else front = (front + 1) % size;
    return val;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Peek Card -->
            <div class="card">
                <h2>3. Peek()</h2>
                <p style="color: var(--text-secondary)">Returns the element at the front.</p>
                
                <div class="mini-viz-container" id="viz-peek"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">peek.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int peek() {
    if (front == -1) return -1;
    return arr[front];
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- isFull Card -->
            <div class="card">
                <h2>4. isFull()</h2>
                <p style="color: var(--text-secondary)">Checks if the queue is full.</p>
                
                <div class="mini-viz-container" id="viz-isfull"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">isfull.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">bool isFull() {
    return (rear + 1) % size == front;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- isEmpty Card -->
            <div class="card">
                <h2>5. isEmpty()</h2>
                <p style="color: var(--text-secondary)">Checks if the queue is empty.</p>
                
                <div class="mini-viz-container" id="viz-isempty"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">isempty.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">bool isEmpty() {
    return front == -1;
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
                        <li><strong>Memory Efficiency:</strong> Reuses empty spaces freed by dequeue operations, unlike linear queues.</li>
                        <li><strong>No Shifting Needed:</strong> Elimination of the need to shift elements to the front after a dequeue operation.</li>
                        <li><strong>Continuous Loop:</strong> Ideal for applications requiring continuous cyclic buffering.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Complex Implementation:</strong> Slightly more complex logic (modulo arithmetic) compared to a linear queue.</li>
                        <li><strong>Fixed Capacity:</strong> Still relies on a fixed size (if array-based), so overflow is possible.</li>
                        <li><strong>One Slot Sacrificed:</strong> In some implementations, one array slot is kept empty to distinguish full vs empty states.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">🚥</span>
                    <div class="example-title">Traffic Lights</div>
                    <div class="example-desc">
                        Traffic lights cycle through Red, Green, and Yellow continuously, a classic example of a circular queue.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">💾</span>
                    <div class="example-title">CPU Scheduling (Round Robin)</div>
                    <div class="example-desc">
                        Processes are assigned CPU time slices in a circular order. If a process isn't done, it goes to the back of the queue.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🎹</span>
                    <div class="example-title">Audio Buffering</div>
                    <div class="example-desc">
                        Streaming audio uses ring buffers to write incoming data while simultaneously reading/playing it to prevent skipping.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">⌨️</span>
                    <div class="example-title">Computer Memory Management</div>
                    <div class="example-desc">
                        Used in memory management where memory addresses are allocated in a circular manner.
                    </div>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Circular Queue implementation handling the wrap-around case.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">CircularQueue.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

#define SIZE 5

class CQueue {
    int items[SIZE], front, rear;

public:
    CQueue() {
        front = -1;
        rear = -1;
    }

    bool isFull() {
        if (front == 0 && rear == SIZE - 1) {
            return true;
        }
        if (front == rear + 1) {
            return true;
        }
        return false;
    }

    bool isEmpty() {
        if (front == -1)
            return true;
        else
            return false;
    }

    void enQueue(int element) {
        if (isFull()) {
            cout &lt;&lt; "Queue is full";
        } else {
            if (front == -1) front = 0;
            rear = (rear + 1) % SIZE;
            items[rear] = element;
            cout &lt;&lt; "Inserted " &lt;&lt; element &lt;&lt; endl;
        }
    }

    int deQueue() {
        int element;
        if (isEmpty()) {
            cout &lt;&lt; "Queue is empty" &lt;&lt; endl;
            return -1;
        } else {
            element = items[front];
            if (front == rear) {
                front = -1;
                rear = -1;
            } else {
                front = (front + 1) % SIZE;
            }
            return element;
        }
    }

    void display() {
        int i;
        if (isEmpty()) {
            cout &lt;&lt; "Empty Queue" &lt;&lt; endl;
        } else {
            cout &lt;&lt; "Front -&gt; " &lt;&lt; front;
            cout &lt;&lt; "\nItems -&gt; ";
            for (i = front; i != rear; i = (i + 1) % SIZE)
                cout &lt;&lt; items[i] &lt;&lt; " ";
            cout &lt;&lt; items[i];
            cout &lt;&lt; "\nRear -&gt; " &lt;&lt; rear &lt;&lt; endl;
        }
    }
};

int main() {
    CQueue q;

    // Fails because front = -1
    q.deQueue();

    q.enQueue(1);
    q.enQueue(2);
    q.enQueue(3);
    q.enQueue(4);
    q.enQueue(5);

    // Fails to enqueue because front == 0 && rear == SIZE - 1
    q.enQueue(6);

    q.display();

    int elem = q.deQueue();

    if (elem != -1)
        cout &lt;&lt; "Deleted Element is " &lt;&lt; elem &lt;&lt; endl;

    q.display();

    q.enQueue(7);

    q.display();

    q.enQueue(8); // Overflow check
    return 0;
}</code></pre>
                </div>
            </div>




        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="circular_queue_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>

    <script>
    // Circular Queue Implementation
    class CircularQueue {
        constructor(capacity = 5) {
            this.items = new Array(capacity).fill(null);
            this.capacity = capacity;
            this.front = -1;
            this.rear = -1;
            this.size = 0;
        }

        enqueue(element) {
            if (this.isFull()) {
                return { success: false, message: 'Queue Overflow! Queue is full.' };
            }

            if (this.front === -1) {
                this.front = 0;
            }

            this.rear = (this.rear + 1) % this.capacity;
            this.items[this.rear] = element;
            this.size++;

            return { success: true, message: `Enqueued: ${element}`, value: element };
        }

        dequeue() {
            if (this.isEmpty()) {
                return { success: false, message: 'Queue Underflow! Queue is empty.' };
            }

            const element = this.items[this.front];
            this.items[this.front] = null; // Clear it for visualization

            if (this.front === this.rear) {
                // Last element reset
                this.front = -1;
                this.rear = -1;
            } else {
                this.front = (this.front + 1) % this.capacity;
            }

            this.size--;
            return { success: true, message: `Dequeued: ${element}`, value: element };
        }

        peek() {
            if (this.isEmpty()) {
                return { success: false, message: 'Queue is empty!' };
            }
            return { success: true, message: `Front element: ${this.items[this.front]}`, value: this.items[this.front] };
        }

        isEmpty() {
            return this.size === 0;
        }

        isFull() {
            return this.size === this.capacity;
        }

        // Get full array including nulls/empty spots for visualization
        getItems() {
            return [...this.items];
        }
    }

    document.addEventListener('DOMContentLoaded', () => {

        function createCircleBase() {
            const ring = document.createElement('div');
            ring.className = 'cq-ring';
            return ring;
        }

        function createItem(val, angle) {
            const item = document.createElement('div');
            item.className = 'cq-item';
            // Position on circle: r = 50px - 10px(half item) = 40px
            const r = 40;
            // center is 50, 50.
            // angle in radians
            const rad = (angle * Math.PI) / 180;
            const x = 50 + r * Math.cos(rad) - 10;
            const y = 50 + r * Math.sin(rad) - 10;

            item.style.left = `${x}px`;
            item.style.top = `${y}px`;

            return item;
        }

        // 1. Enqueue
        const vizEnqueue = document.getElementById('viz-enqueue');
        setInterval(() => {
            vizEnqueue.innerHTML = '';
            const ring = createCircleBase();

            // Existing items
            ring.appendChild(createItem('', 0));
            ring.appendChild(createItem('', 72));

            vizEnqueue.appendChild(ring);

            setTimeout(() => {
                const newItem = createItem('', 144);
                newItem.style.opacity = '0';
                newItem.style.transform = 'scale(0)';
                newItem.style.transition = 'all 0.5s ease';
                ring.appendChild(newItem);

                requestAnimationFrame(() => {
                    newItem.style.opacity = '1';
                    newItem.style.transform = 'scale(1)';
                });
            }, 500);

        }, 2000);

        // 2. Dequeue
        const vizDequeue = document.getElementById('viz-dequeue');
        setInterval(() => {
            vizDequeue.innerHTML = '';
            const ring = createCircleBase();
            const item1 = createItem('', 0); // Front
            ring.appendChild(item1);
            ring.appendChild(createItem('', 72));
            ring.appendChild(createItem('', 144));

            ring.appendChild(item1);
            vizDequeue.appendChild(ring);

            setTimeout(() => {
                item1.style.opacity = '0';
                item1.style.transform = 'scale(0)';
                item1.style.transition = 'all 0.5s ease';
            }, 500);
        }, 2000);

        // 3. Peek
        const vizPeek = document.getElementById('viz-peek');
        const peekRing = createCircleBase();
        const pItem = createItem('', 0);
        peekRing.appendChild(pItem);
        peekRing.appendChild(createItem('', 72));
        vizPeek.appendChild(peekRing);

        setInterval(() => {
            pItem.style.boxShadow = '0 0 10px white';
            setTimeout(() => pItem.style.boxShadow = 'none', 1000);
        }, 2000);

        // 4. isFull
        const vizFull = document.getElementById('viz-isfull');
        const fullRing = createCircleBase();
        for (let i = 0; i < 5; i++) {
            fullRing.appendChild(createItem('', i * 72));
        }
        vizFull.appendChild(fullRing);

        // 5. isEmpty
        const vizEmpty = document.getElementById('viz-isempty');
        const emptyRing = createCircleBase();
        const msg = document.createElement('div');
        msg.innerText = 'Empty';
        msg.style.position = 'absolute';
        msg.style.top = '50%';
        msg.style.left = '50%';
        msg.style.transform = 'translate(-50%, -50%)';
        msg.style.color = '#fff';
        msg.style.fontSize = '0.8rem';
        emptyRing.appendChild(msg);
        vizEmpty.appendChild(emptyRing);

    });
    </script>
</html>
