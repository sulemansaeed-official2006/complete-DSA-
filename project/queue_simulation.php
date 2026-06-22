<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Simulation Playground</title>
    <link rel="stylesheet" href="ds_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <style>
        .sim-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        .controls-panel {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-top: 2rem;
        }
        .control-card {
            background: var(--card-bg);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--border-color);
        }
        .log-panel {
            grid-column: 1 / -1;
        }
    </style>
</head>
<body>
    <div class="container sim-container">
        <div class="nav-header">
            <a href="queue.php" class="back-link">← Back to Theory & Cards</a>
        </div>

        <header class="header">
            <h1>Queue Simulation Playground</h1>
            <p class="subtitle">Interactive Environment to Test Queue Operations</p>
        </header>

        <!-- Visualization Canvas -->
        <section class="card">
            <div class="queue-container" style="min-height: 200px;">
                <div class="queue-label">Front</div>
                <div id="queueVisualization" class="queue-display">
                    <div class="empty-message">Queue is Empty</div>
                </div>
                <div class="queue-label">Rear</div>
            </div>

            <!-- Detailed Status Bar -->
            <div class="queue-info">
                <div class="info-item">
                    <span class="info-label">Size</span>
                    <span id="queueSize" class="info-value">0</span>
                </div>
                 <div class="info-item">
                    <span class="info-label">Front Element</span>
                    <span id="valFront" class="info-value">-</span>
                </div>
                 <div class="info-item">
                    <span class="info-label">Rear Element</span>
                    <span id="valRear" class="info-value">-</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Capacity</span>
                    <span id="queueCapacity" class="info-value">10</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span id="queueStatus" class="info-value status-empty">Empty</span>
                </div>
            </div>
        </section>

        <div class="controls-panel">
            <!-- Operations Column -->
            <div class="control-card">
                <h3 style="margin-bottom: 1rem; color: var(--accent-color);">Operations</h3>
                <div class="controls">
                    <div class="input-group">
                        <input type="number" id="enqueueValue" placeholder="Value (Pos Int)" class="value-input" min="0" step="1" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.key === 'Enter'">
                        <button onclick="enqueueElement()" class="btn btn-primary">Enqueue</button>
                    </div>
                    <button onclick="dequeueElement()" class="btn btn-danger">Dequeue</button>
                    <button onclick="peekElement()" class="btn btn-info">Peek Front</button>
                    <button onclick="peekRearElement()" class="btn btn-info" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">Peek Rear</button>
                    <button onclick="clearQueue()" class="btn btn-warning">Clear Queue</button>
                </div>
            </div>

            <!-- Demo / Advanced Column -->
            <div class="control-card">
                <h3 style="margin-bottom: 1rem; color: var(--accent-color);">Automation</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">Run automated scripts to see the queue in action.</p>
                <button onclick="demonstrateAll()" class="btn btn-demo" style="width: 100%">
                    🚀 Run Full Demonstration
                </button>
            </div>

            <!-- Log Panel -->
             <div class="control-card log-panel">
                <h3 style="margin-bottom: 1rem; color: var(--accent-color);">Execution Log</h3>
                <div id="operationLog" class="operation-log" style="height: 200px;"></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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

    // Global queue instance
    const queue = new Queue(10);

    // Update visualization
    function updateVisualization() {
        const queueDisplay = document.getElementById('queueVisualization');
        const items = queue.getItems();

        // 1. Update Canvas
        if (items.length === 0) {
            queueDisplay.innerHTML = '<div class="empty-message">Queue is Empty</div>';
        } else {
            queueDisplay.innerHTML = items.map((item, index) => {
                return `<div class="queue-element" style="animation-delay: ${index * 0.1}s">${item}</div>`;
            }).join('');
        }

        // 2. Update Info Panel
        document.getElementById('queueSize').textContent = queue.size();
        document.getElementById('queueCapacity').textContent = queue.capacity;

        // Front/Rear Values
        const peek = queue.peek();
        const rear = queue.rear();
        document.getElementById('valFront').textContent = peek.success ? peek.value : '-';
        document.getElementById('valRear').textContent = rear.success ? rear.value : '-';

        // Status
        const statusElement = document.getElementById('queueStatus');
        if (queue.isEmpty()) {
            statusElement.textContent = 'Empty';
            statusElement.className = 'info-value status-empty';
        } else if (queue.isFull()) {
            statusElement.textContent = 'Full';
            statusElement.className = 'info-value status-full';
        } else {
            statusElement.textContent = 'Normal';
            statusElement.className = 'info-value status-normal';
        }
    }

    // Add log entry
    function addLog(message, type = 'info') {
        const logContainer = document.getElementById('operationLog');
        const logEntry = document.createElement('div');
        logEntry.className = `log-entry log-${type}`;

        const timestamp = new Date().toLocaleTimeString();
        logEntry.textContent = `[${timestamp}] ${message}`;

        logContainer.appendChild(logEntry);
        logContainer.scrollTop = logContainer.scrollHeight;
    }

    // Enqueue operation
    function enqueueElement() {
        const input = document.getElementById('enqueueValue');
        const rawValue = input.value;
        const value = input.value.trim();

        if (value === '') {
            addLog('Please enter a value!', 'error');
            return;
        }

        // Strict Validation
        if (value.includes('.') || value.includes(',') || rawValue.includes('e')) {
             addLog('Decimals/Floats are NOT allowed!', 'error');
             return;
        }

        const numVal = Number(value);
        if (numVal < 0) {
             addLog('Negative numbers are NOT allowed!', 'error');
             return;
        }
        
        if (!Number.isInteger(numVal)) {
             addLog('Only integers are allowed!', 'error');
             return;
        }

        const result = queue.enqueue(numVal);

        if (result.success) {
            addLog(result.message, 'success');
            updateVisualization();
            input.value = '';
            input.focus();

            // Highlight the last element
            setTimeout(() => {
                const elements = document.querySelectorAll('.queue-element');
                if (elements.length > 0) {
                    elements[elements.length - 1].classList.add('highlight');
                    setTimeout(() => {
                        elements[elements.length - 1].classList.remove('highlight');
                    }, 500);
                }
            }, 100);
        } else {
            addLog(result.message, 'error');
        }
    }

    // Dequeue operation
    function dequeueElement() {
        const result = queue.dequeue();

        if (result.success) {
            addLog(result.message, 'success');
            updateVisualization();
        } else {
            addLog(result.message, 'error');
        }
    }

    // Peek Front
    function peekElement() {
        const result = queue.peek();

        if (result.success) {
            addLog(result.message, 'info');

            // Highlight the front element
            const elements = document.querySelectorAll('.queue-element');
            if (elements.length > 0) {
                elements[0].classList.add('highlight');
                setTimeout(() => {
                    elements[0].classList.remove('highlight');
                }, 1000);
            }
        } else {
            addLog(result.message, 'error');
        }
    }

    // Peek Rear
    function peekRearElement() {
        const result = queue.rear();

        if (result.success) {
            addLog(result.message, 'info');

            // Highlight the rear element
            const elements = document.querySelectorAll('.queue-element');
            if (elements.length > 0) {
                elements[elements.length - 1].classList.add('highlight');
                setTimeout(() => {
                    elements[elements.length - 1].classList.remove('highlight');
                }, 1000);
            }
        } else {
            addLog(result.message, 'error');
        }
    }

    // Clear
    function clearQueue() {
        const result = queue.clear();
        addLog(result.message, 'success');
        updateVisualization();
    }

    // Helper function for delays
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // Demonstrate all
    async function demonstrateAll() {
        addLog('🚀 Starting demonstration...', 'info');

        clearQueue();
        await sleep(800);

        for (let value of [10, 20, 30]) {
            queue.enqueue(value);
            updateVisualization();
            addLog(`Enqueued ${value}`, 'success');
            await sleep(800);
        }

        peekElement();
        await sleep(1000);

        peekRearElement();
        await sleep(1000);

        dequeueElement();
        updateVisualization();
        await sleep(800);

        addLog('✅ Demonstration complete!', 'success');
    }

    // Allow Enter key
    document.getElementById('enqueueValue').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            enqueueElement();
        }
    });

    // Initialize
    updateVisualization();
    </script>
</html>
