<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Data Structure - Concepts & Operations</title>
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
            <a href="queue_simulation.php" class="cta-button">🚀 Go to Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Queue Operations</h1>
            <p class="subtitle">Deep Dive into Queue Functions with Theory & Code</p>
        </header>

        <section class="card">
            <h2>What is a Queue?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                A Queue is a linear data structure that follows the <strong>First In First Out (FIFO)</strong> principle. 
                Imagine a line of people waiting for a bus; the first person to arrive is the first one to board.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Setup Card -->
            <div class="card">
                <h2>0. Class Setup</h2>
                <p style="color: var(--text-secondary)">Define the class, array, and initialize pointers in the constructor.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">queue.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">#define SIZE 100

class Queue {
    int front, rear;
    int arr[SIZE];

public:
    Queue() {
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
                <p style="color: var(--text-secondary)">Adds an element <code>x</code> to the <strong>rear</strong> of the queue.</p>
                
                <div class="mini-viz-container" id="viz-enqueue">
                    <!-- JS will render here -->
                </div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">enqueue.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void enqueue(int x) {
    if (rear == capacity - 1) {
        cout << "Queue Overflow";
        return;
    }
    if (front == -1) front = 0;
    arr[++rear] = x;
    size++;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Dequeue Card -->
            <div class="card">
                <h2>2. Dequeue()</h2>
                <p style="color: var(--text-secondary)">Removes and returns the element from the <strong>front</strong> of the queue.</p>
                
                <div class="mini-viz-container" id="viz-dequeue">
                     <!-- JS will render here -->
                </div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">dequeue.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int dequeue() {
    if (front == -1 || front > rear) {
        cout << "Queue Underflow";
        return -1;
    }
    int val = arr[front++];
    if (front > rear) front = rear = -1;
    size--;
    return val;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Peek Card -->
            <div class="card">
                <h2>3. Peek() / Front()</h2>
                <p style="color: var(--text-secondary)">Returns the element at the <strong>front</strong> without removing it.</p>
                
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
    if (isEmpty()) return -1;
    return arr[front];
}</code></pre>
                    </div>
                </div>
            </div>
            
             <!-- Rear Card -->
            <div class="card">
                <h2>4. Rear()</h2>
                <p style="color: var(--text-secondary)">Returns the element at the <strong>rear</strong> without removing it.</p>
                
                <div class="mini-viz-container" id="viz-rear"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">rear.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int rear() {
    if (isEmpty()) return -1;
    return arr[rear];
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- isEmpty Card -->
            <div class="card">
                <h2>5. isEmpty()</h2>
                <p style="color: var(--text-secondary)">Checks if the queue contains no elements.</p>
                
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
    return size == 0;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- isFull Card -->
            <div class="card">
                <h2>6. isFull()</h2>
                <p style="color: var(--text-secondary)">Checks if the queue has reached its maximum capacity.</p>
                
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
    return size == capacity;
}</code></pre>
                    </div>
                </div>
            </div>

             <!-- Size Card -->
            <div class="card">
                <h2>7. Size()</h2>
                <p style="color: var(--text-secondary)">Returns the total number of elements currently in the queue.</p>
                
                <div class="mini-viz-container" id="viz-size"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">size.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int size() {
    return rear - front + 1;
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
                        <li><strong>Order Preservation:</strong> Maintains the order of elements (FIFO), ensuring fairness in processing.</li>
                        <li><strong>Fast Operations:</strong> Enqueue and Dequeue operations take O(1) time if implemented correctly.</li>
                        <li><strong>Synchronization:</strong> Useful for inter-process communication where data needs to be buffered.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Limited Access:</strong> You can only access the front or rear element, not the middle ones.</li>
                        <li><strong>Fixed Size (Array):</strong> In a static array implementation, the size is fixed and can lead to overflow.</li>
                        <li><strong>Memory Wastage:</strong> In a linear array queue, deleted spaces cannot be reused unless shifted (Solution: Circular Queue).</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">🖨️</span>
                    <div class="example-title">Printer Queue</div>
                    <div class="example-desc">
                        Documents sent to a printer are held in a queue. The first document sent is the first one printed used (FIFO).
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🎟️</span>
                    <div class="example-title">Ticket Counter</div>
                    <div class="example-desc">
                        People standing in line to buy tickets. The person at the front gets served first.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">💻</span>
                    <div class="example-title">CPU Scheduling</div>
                    <div class="example-desc">
                        Processes waiting for the CPU are often organized in a queue (Ready Queue) to ensure fair execution time.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">⌨️</span>
                    <div class="example-title">Keyboard Buffer</div>
                    <div class="example-desc">
                        Keystrokes are stored in a buffer (queue) so that if you type faster than the computer processes, the keys appear in the correct order.
                    </div>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Standard Queue implementation using an array.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">Queue.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

#define MAX 100

class Queue {
    int front, rear, size;
    unsigned capacity;
    int* array;

public:
    Queue(unsigned capacity) {
        this-&gt;capacity = capacity;
        front = size = 0;
        rear = capacity - 1;
        array = new int[this-&gt;capacity];
    }

    bool isFull(Queue* queue) {
        return (queue-&gt;size == queue-&gt;capacity);
    }

    bool isEmpty(Queue* queue) {
        return (queue-&gt;size == 0);
    }

    void enqueue(int item) {
        if (isFull(this)) return;
        rear = (rear + 1) % capacity;
        array[rear] = item;
        size = size + 1;
        cout &lt;&lt; item &lt;&lt; " enqueued to queue\n";
    }

    int dequeue() {
        if (isEmpty(this)) return -1000;
        int item = array[front];
        front = (front + 1) % capacity;
        size = size - 1;
        return item;
    }

    int getFront() {
        if (isEmpty(this)) return -1000;
        return array[front];
    }

    int getRear() {
        if (isEmpty(this)) return -1000;
        return array[rear];
    }
};

int main() {
    Queue queue(1000);

    queue.enqueue(10);
    queue.enqueue(20);
    queue.enqueue(30);
    queue.enqueue(40);

    cout &lt;&lt; queue.dequeue() &lt;&lt; " dequeued from queue\n";
    cout &lt;&lt; "Front item is " &lt;&lt; queue.getFront() &lt;&lt; endl;
    cout &lt;&lt; "Rear item is " &lt;&lt; queue.getRear() &lt;&lt; endl;

    return 0;
}</code></pre>
                </div>
            </div>




        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="queue_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>

    <script>
    // Queue Implementation
    class Queue {
        constructor(capacity = 10) {
            this.items = [];
            this.capacity = capacity;
        }

        enqueue(element) {
            if (this.isFull()) {
                return { success: false, message: 'Queue Overflow! Queue is full.' };
            }
            this.items.push(element);
            return { success: true, message: `Enqueued: ${element}`, value: element };
        }

        dequeue() {
            if (this.isEmpty()) {
                return { success: false, message: 'Queue Underflow! Queue is empty.' };
            }
            const element = this.items.shift();
            return { success: true, message: `Dequeued: ${element}`, value: element };
        }

        peek() {
            if (this.isEmpty()) {
                return { success: false, message: 'Queue is empty!' };
            }
            return { success: true, message: `Front element: ${this.items[0]}`, value: this.items[0] };
        }

        rear() {
            if (this.isEmpty()) {
                return { success: false, message: 'Queue is empty!' };
            }
            return { success: true, message: `Rear element: ${this.items[this.items.length - 1]}`, value: this.items[this.items.length - 1] };
        }

        isEmpty() {
            return this.items.length === 0;
        }

        isFull() {
            return this.items.length >= this.capacity;
        }

        size() {
            return this.items.length;
        }

        clear() {
            this.items = [];
            return { success: true, message: 'Queue cleared!' };
        }

        getItems() {
            return [...this.items];
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Helper to create queue elements
        function createQueueElement(value, color = '#667eea') {
            const el = document.createElement('div');
            el.className = 'queue-element';
            el.innerText = value;
            el.style.minWidth = '40px';
            el.style.height = '40px';
            el.style.fontSize = '0.9rem';
            el.style.margin = '0 5px';
            return el;
        }

        // 1. Enqueue Viz
        const vizEnqueue = document.getElementById('viz-enqueue');
        setInterval(() => {
            vizEnqueue.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            base.appendChild(createQueueElement(10));
            base.appendChild(createQueueElement(20));
            vizEnqueue.appendChild(base);

            setTimeout(() => {
                const newEl = createQueueElement(30);
                newEl.style.opacity = '0';
                newEl.style.transform = 'translateX(20px)';
                base.appendChild(newEl);

                // Animation
                requestAnimationFrame(() => {
                    newEl.style.transition = 'all 0.5s ease';
                    newEl.style.opacity = '1';
                    newEl.style.transform = 'translateX(0)';
                });
            }, 500);
        }, 2000);

        // 2. Dequeue Viz
        const vizDequeue = document.getElementById('viz-dequeue');
        setInterval(() => {
            vizDequeue.innerHTML = '';
            const base = document.createElement('div');
            base.style.display = 'flex';
            const el1 = createQueueElement(10);
            base.appendChild(el1);
            base.appendChild(createQueueElement(20));
            base.appendChild(createQueueElement(30));
            vizDequeue.appendChild(base);

            setTimeout(() => {
                el1.style.transition = 'all 0.5s ease';
                el1.style.opacity = '0';
                el1.style.transform = 'translateY(-20px)';
            }, 500);
        }, 2000);

        // 3. Peek Viz
        const vizPeek = document.getElementById('viz-peek');
        const peekBase = document.createElement('div');
        peekBase.style.display = 'flex';
        const p1 = createQueueElement(10);
        peekBase.appendChild(p1);
        peekBase.appendChild(createQueueElement(20));
        vizPeek.appendChild(peekBase);

        setInterval(() => {
            p1.classList.add('highlight');
            setTimeout(() => p1.classList.remove('highlight'), 1000);
        }, 2000);

        // 4. Rear Viz
        const vizRear = document.getElementById('viz-rear');
        const rearBase = document.createElement('div');
        rearBase.style.display = 'flex';
        rearBase.appendChild(createQueueElement(10));
        const r2 = createQueueElement(20);
        rearBase.appendChild(r2);
        vizRear.appendChild(rearBase);

        setInterval(() => {
            r2.classList.add('highlight');
            setTimeout(() => r2.classList.remove('highlight'), 1000);
        }, 2000);

        // 5. isEmpty Viz
        const vizEmpty = document.getElementById('viz-isempty');
        const emptyMsg = document.createElement('div');
        emptyMsg.className = 'empty-message';
        emptyMsg.innerText = 'Queue is Empty';
        vizEmpty.appendChild(emptyMsg);

        // 6. isFull Viz
        const vizFull = document.getElementById('viz-isfull');
        vizFull.style.flexWrap = 'wrap';
        const fullBase = document.createElement('div');
        fullBase.style.display = 'flex';
        for (let i = 1; i <= 5; i++) {
            fullBase.appendChild(createQueueElement(i));
        }
        vizFull.appendChild(fullBase);
        const fullMsg = document.createElement('div');
        fullMsg.innerText = 'Capacity Reached!';
        fullMsg.style.color = '#ef4444';
        fullMsg.style.fontSize = '0.8rem';
        fullMsg.style.marginTop = '5px';
        vizFull.style.flexDirection = 'column';
        vizFull.appendChild(fullMsg);

        // 7. Size Viz
        const vizSize = document.getElementById('viz-size');
        const sizeBase = document.createElement('div');
        sizeBase.style.display = 'flex';
        sizeBase.appendChild(createQueueElement(10));
        sizeBase.appendChild(createQueueElement(20));
        sizeBase.appendChild(createQueueElement(30));
        vizSize.appendChild(sizeBase);

        const sizeLabel = document.createElement('div');
        sizeLabel.innerText = 'Size: 3';
        sizeLabel.className = 'info-value';
        sizeLabel.style.fontSize = '1.2rem';
        vizSize.style.flexDirection = 'column';
        vizSize.appendChild(sizeLabel);
    });
    </script>
</html>
