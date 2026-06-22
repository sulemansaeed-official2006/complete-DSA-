<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stack Data Structure - Concepts & Operations</title>
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
            height: 200px; /* Taller for vertical stack */
            background: #0f172a;
            border-radius: 10px;
            display: flex;
            align-items: flex-end; /* Bottom alignment for stack */
            justify-content: center;
            margin: 1rem 0;
            overflow: hidden;
            border: 1px dashed #334155;
            position: relative;
            padding-bottom: 20px;
        }
        
        .stack-base {
            border-bottom: 4px solid #667eea;
            display: flex;
            flex-direction: column-reverse; /* Stack from bottom up */
            gap: 5px;
            width: 80px;
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
            <a href="stack_simulation.php" class="cta-button">🚀 Go to Simulation Playground</a>
        </div>

        <header class="header">
            <h1>Stack Operations</h1>
            <p class="subtitle">Deep Dive into Stack Functions with Theory & Code</p>
        </header>

        <section class="card">
            <h2>What is a Stack?</h2>
            <p style="color: var(--text-secondary); margin-bottom: 1rem;">
                A Stack is a linear data structure that follows the <strong>Last In First Out (LIFO)</strong> principle. 
                Imagine a stack of plates; you add plate to the top, and remove from the top. The last plate added is the first one removed.
            </p>
        </section>

        <div class="cards-grid">
            <!-- Setup Card -->
            <div class="card">
                <h2>0. Class Setup</h2>
                <p style="color: var(--text-secondary)">Define the class, array, and initialize the top pointer.</p>
                
                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">stack.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">#define MAX 100

class Stack {
    int top;
    int arr[MAX];

public:
    Stack() {
        top = -1;
    }
};</code></pre>
                    </div>
                </div>
            </div>
            <!-- Push Card -->
            <div class="card">
                <h2>1. Push(x)</h2>
                <p style="color: var(--text-secondary)">Adds an element <code>x</code> to the <strong>top</strong> of the stack.</p>
                
                <div class="mini-viz-container" id="viz-push">
                    <!-- JS will render here -->
                </div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">push.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">void push(int x) {
    if (top >= capacity - 1) {
        cout << "Stack Overflow";
        return;
    }
    arr[++top] = x;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Pop Card -->
            <div class="card">
                <h2>2. Pop()</h2>
                <p style="color: var(--text-secondary)">Removes and returns the element from the <strong>top</strong> of the stack.</p>
                
                <div class="mini-viz-container" id="viz-pop"></div>

                <div class="mac-window">
                    <div class="mac-header">
                        <div class="mac-dot red"></div>
                        <div class="mac-dot yellow"></div>
                        <div class="mac-dot green"></div>
                        <span class="mac-title">pop.cpp</span>
                    </div>
                    <div class="code-content">
<pre><code class="cpp">int pop() {
    if (top < 0) {
        cout << "Stack Underflow";
        return -1;
    }
    return arr[top--];
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Peek Card -->
            <div class="card">
                <h2>3. Peek() / Top()</h2>
                <p style="color: var(--text-secondary)">Returns the element at the <strong>top</strong> without removing it.</p>
                
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
    return arr[top];
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- isEmpty Card -->
            <div class="card">
                <h2>4. isEmpty()</h2>
                <p style="color: var(--text-secondary)">Checks if the stack contains no elements.</p>
                
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
    return top < 0;
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- isFull Card -->
            <div class="card">
                <h2>5. isFull()</h2>
                <p style="color: var(--text-secondary)">Checks if the stack has reached its maximum capacity.</p>
                
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
    return top >= capacity - 1;
}</code></pre>
                    </div>
                </div>
            </div>

             <!-- Size Card -->
            <div class="card">
                <h2>6. Size()</h2>
                <p style="color: var(--text-secondary)">Returns the total number of elements currently in the stack.</p>
                
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
    return top + 1;
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
                        <li><strong>Simplicity:</strong> Easy to implement and understand (LIFO principle).</li>
                        <li><strong>Efficient Memory:</strong> Operations are constant time O(1) and memory is managed automatically in function calls.</li>
                        <li><strong>Recursion Support:</strong> Essential for implementing recursive algorithms and function call management.</li>
                    </ul>
                </div>
                <div class="cons">
                    <h3>Disadvantages</h3>
                    <ul>
                        <li><strong>Limited Access:</strong> Valid only for top element access; random access is not allowed.</li>
                        <li><strong>Stack Overflow:</strong> Fixed size stacks can run out of memory if too many items are pushed.</li>
                        <li><strong>Not Dynamic:</strong> Array-based stacks have a fixed size; resizing requires creating a new array.</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Real World Examples -->
        <section class="card" style="margin-top: 2rem;">
            <h2>Real-World Examples</h2>
            <div class="examples-grid">
                <div class="example-card">
                    <span class="example-icon">↩️</span>
                    <div class="example-title">Undo Mechanism</div>
                    <div class="example-desc">
                        Text editors use stacks to store changes. Ctrl+Z pops the last action from the stack to revert it.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🌐</span>
                    <div class="example-title">Browser History</div>
                    <div class="example-desc">
                        Web browsers use a stack to track visited pages. The Back button pops the current page to show the previous one.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🧩</span>
                    <div class="example-title">Expression Evaluation</div>
                    <div class="example-desc">
                        Compilers use stacks to parse expressions (e.g., matching parentheses) and evaluate mathematical formulas.
                    </div>
                </div>
                <div class="example-card">
                    <span class="example-icon">🔄</span>
                    <div class="example-title">Function Call Stack</div>
                    <div class="example-desc">
                        Programming languages use the call stack to manage function execution, local variables, and return addresses.
                    </div>
                </div>
            </div>
        </section>

        <!-- Complete C++ Implementation -->
        <section class="card" style="margin-top: 2rem;">
            <h2><i class="fa-brands fa-cuttlefish"></i> Complete C++ Implementation</h2>
            <p style="color:var(--text-secondary); margin-bottom:15px;">Standard Stack implementation using an array.</p>
            
            <div class="mac-window" style="height: 400px; overflow-y: auto;">
                <div class="mac-header">
                    <span class="mac-title">Stack.cpp</span>
                </div>
                <div class="code-content">
<pre><code class="cpp">#include &lt;iostream&gt;
using namespace std;

#define MAX 1000

class Stack {
    int top;

public:
    int a[MAX]; // Maximum size of Stack

    Stack() { top = -1; }
    
    bool push(int x) {
        if (top &gt;= (MAX - 1)) {
            cout &lt;&lt; "Stack Overflow";
            return false;
        } else {
            a[++top] = x;
            cout &lt;&lt; x &lt;&lt; " pushed into stack\n";
            return true;
        }
    }

    int pop() {
        if (top &lt; 0) {
            cout &lt;&lt; "Stack Underflow";
            return 0;
        } else {
            int x = a[top--];
            return x;
        }
    }

    int peek() {
        if (top &lt; 0) {
            cout &lt;&lt; "Stack is Empty";
            return 0;
        } else {
            int x = a[top];
            return x;
        }
    }

    bool isEmpty() {
        return (top &lt; 0);
    }
};

int main() {
    Stack s;
    s.push(10);
    s.push(20);
    s.push(30);
    
    cout &lt;&lt; s.pop() &lt;&lt; " Popped from stack\n";
    cout &lt;&lt; "Top element is " &lt;&lt; s.peek() &lt;&lt; endl;
    cout &lt;&lt; "Elements present in stack : ";
    while(!s.isEmpty()) {
        cout &lt;&lt; s.peek() &lt;&lt; " ";
        s.pop();
    }
    return 0;
}</code></pre>
                </div>
            </div>




        <div style="text-align: center; margin-top: 3rem; margin-bottom: 3rem;">
            <a href="stack_simulation.php" class="cta-button">🚀 Try the Simulation Playground</a>
        </div>
    </div>

    <script>
    // Stack Implementation
    class Stack {
        constructor(capacity = 10) {
            this.items = [];
            this.capacity = capacity;
        }

        push(element) {
            if (this.isFull()) {
                return { success: false, message: 'Stack Overflow! Stack is full.' };
            }
            this.items.push(element);
            return { success: true, message: `Pushed: ${element}`, value: element };
        }

        pop() {
            if (this.isEmpty()) {
                return { success: false, message: 'Stack Underflow! Stack is empty.' };
            }
            const element = this.items.pop();
            return { success: true, message: `Popped: ${element}`, value: element };
        }

        peek() {
            if (this.isEmpty()) {
                return { success: false, message: 'Stack is empty!' };
            }
            return { success: true, message: `Top element: ${this.items[this.items.length - 1]}`, value: this.items[this.items.length - 1] };
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
            return { success: true, message: 'Stack cleared!' };
        }

        getItems() {
            return [...this.items];
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Helper to create stack elements
        function createStackElement(value, color = '#667eea') {
            const el = document.createElement('div');
            el.className = 'stack-element';
            el.innerText = value;
            el.style.width = '80px';
            el.style.height = '40px';
            el.style.backgroundColor = color;
            el.style.color = 'white';
            el.style.display = 'flex';
            el.style.alignItems = 'center';
            el.style.justifyContent = 'center';
            el.style.marginBottom = '5px';
            el.style.borderRadius = '5px';
            el.style.fontWeight = 'bold';
            return el;
        }

        // Reuse helper to create a base container for stack
        function createBase() {
            const base = document.createElement('div');
            base.className = 'stack-base';
            return base;
        }

        // 1. Push Viz
        const vizPush = document.getElementById('viz-push');
        setInterval(() => {
            vizPush.innerHTML = '';
            const base = createBase();
            base.appendChild(createStackElement(10));
            base.appendChild(createStackElement(20));
            vizPush.appendChild(base);

            setTimeout(() => {
                const newEl = createStackElement(30);
                newEl.style.opacity = '0';
                newEl.style.transform = 'translateY(-20px)';
                base.appendChild(newEl); // will be added to top because of flex-direction: column-reverse

                requestAnimationFrame(() => {
                    newEl.style.transition = 'all 0.5s ease';
                    newEl.style.opacity = '1';
                    newEl.style.transform = 'translateY(0)';
                });
            }, 500);
        }, 2000);

        // 2. Pop Viz
        const vizPop = document.getElementById('viz-pop');
        setInterval(() => {
            vizPop.innerHTML = '';
            const base = createBase();
            base.appendChild(createStackElement(10));
            base.appendChild(createStackElement(20));
            const el3 = createStackElement(30);
            base.appendChild(el3);
            vizPop.appendChild(base);

            setTimeout(() => {
                el3.style.transition = 'all 0.5s ease';
                el3.style.opacity = '0';
                el3.style.transform = 'translateY(-30px)';
            }, 500);
        }, 2000);

        // 3. Peek Viz
        const vizPeek = document.getElementById('viz-peek');
        const peekBase = createBase();
        peekBase.appendChild(createStackElement(10));
        const p2 = createStackElement(20);
        peekBase.appendChild(p2);
        vizPeek.appendChild(peekBase);

        setInterval(() => {
            p2.style.boxShadow = '0 0 15px #f093fb';
            setTimeout(() => p2.style.boxShadow = 'none', 1000);
        }, 2000);


        // 4. isEmpty Viz
        const vizEmpty = document.getElementById('viz-isempty');
        const emptyMsg = document.createElement('div');
        emptyMsg.className = 'empty-message';
        emptyMsg.innerText = 'Stack is Empty';
        vizEmpty.style.alignItems = 'center'; // Center vert
        vizEmpty.style.paddingBottom = '0';
        vizEmpty.appendChild(emptyMsg);

        // 5. isFull Viz
        const vizFull = document.getElementById('viz-isfull');
        const fullBase = createBase();
        for (let i = 1; i <= 5; i++) {
            fullBase.appendChild(createStackElement(i));
        }
        vizFull.appendChild(fullBase);

        // 6. Size Viz
        const vizSize = document.getElementById('viz-size');
        const sizeBase = createBase();
        sizeBase.appendChild(createStackElement(10));
        sizeBase.appendChild(createStackElement(20));
        sizeBase.appendChild(createStackElement(30));
        vizSize.appendChild(sizeBase);

        const sizeLabel = document.createElement('div');
        sizeLabel.innerText = 'Size: 3';
        sizeLabel.className = 'info-value';
        sizeLabel.style.position = 'absolute';
        sizeLabel.style.top = '10px';
        sizeLabel.style.right = '10px';
        vizSize.appendChild(sizeLabel);
    });
    </script>
</html>
