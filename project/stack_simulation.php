<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stack Simulation Playground</title>
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
        
        /* Stack specific visualization */
        .stack-container {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            min-height: 400px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border: 2px dashed var(--border-color);
            padding: 2rem;
        }
        
        .stack-visual {
            display: flex;
            flex-direction: column-reverse;
            gap: 10px;
            width: 200px;
            border-bottom: 5px solid var(--primary-color);
            border-left: 5px solid var(--primary-color);
            border-right: 5px solid var(--primary-color);
            padding: 10px;
            border-radius: 0 0 10px 10px;
            min-height: 50px;
        }

        .stack-item {
            height: 50px;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 5px;
            animation: slideDown 0.5s ease-out;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stack-item.highlight {
            background: var(--accent-color);
            box-shadow: 0 0 20px var(--accent-color);
            transform: scale(1.05);
        }

        .top-indicator {
            position: absolute;
            left: -80px;
            top: 50%;
            color: var(--accent-color);
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container sim-container">
        <div class="nav-header">
            <a href="stack.php" class="back-link">← Back to Theory & Cards</a>
        </div>

        <header class="header">
            <h1>Stack Simulation Playground</h1>
            <p class="subtitle">Interactive Environment to Test Stack Operations</p>
        </header>

        <!-- Visualization Canvas -->
        <section class="card">
            <div class="stack-container">
                <div id="stackVisual" class="stack-visual">
                    <div class="empty-message">Stack is Empty</div>
                </div>
            </div>

            <!-- Detailed Status Bar -->
            <div class="queue-info">
                <div class="info-item">
                    <span class="info-label">Size</span>
                    <span id="stackSize" class="info-value">0</span>
                </div>
                 <div class="info-item">
                    <span class="info-label">Top Element</span>
                    <span id="stackTop" class="info-value">-</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Capacity</span>
                    <span id="stackCapacity" class="info-value">10</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span id="stackStatus" class="info-value status-empty">Empty</span>
                </div>
            </div>
        </section>

        <div class="controls-panel">
            <!-- Operations Column -->
            <div class="control-card">
                <h3 style="margin-bottom: 1rem; color: var(--accent-color);">Operations</h3>
                <div class="controls">
                    <div class="input-group">
                        <input type="number" id="pushValue" placeholder="Value (Pos Int)" class="value-input" min="0" step="1" onkeypress="return (event.charCode >= 48 && event.charCode <= 57) || event.key === 'Enter'">
                        <button onclick="pushElement()" class="btn btn-primary">Push</button>
                    </div>
                    <button onclick="popElement()" class="btn btn-danger">Pop</button>
                    <button onclick="peekElement()" class="btn btn-info">Peek Top</button>
                    <button onclick="clearStack()" class="btn btn-warning">Clear Stack</button>
                </div>
            </div>

            <!-- Demo / Advanced Column -->
            <div class="control-card">
                <h3 style="margin-bottom: 1rem; color: var(--accent-color);">Automation</h3>
                <p style="color: var(--text-secondary); margin-bottom: 1rem;">Run automated scripts to see the stack in action.</p>
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

    // Global stack instance
    const stack = new Stack(10);

    // Update visualization
    function updateVisualization() {
        const stackDisplay = document.getElementById('stackVisual');
        const items = stack.getItems();

        // 1. Update Canvas
        if (items.length === 0) {
            stackDisplay.innerHTML = '<div class="empty-message">Stack is Empty</div>';
        } else {
            // Reverse items for display because flex-direction is column-reverse (bottom to top)
            // Actually flex-direction: column-reverse means the first child is at bottom.
            // Stack items array is [bottom, ..., top]
            // So we just map them directly.
            stackDisplay.innerHTML = items.map((item, index) => {
                return `<div class="stack-item" style="animation-delay: ${index * 0.05}s">${item}</div>`;
            }).join('');
        }

        // 2. Update Info Panel
        document.getElementById('stackSize').textContent = stack.size();
        document.getElementById('stackCapacity').textContent = stack.capacity;

        // Top Values
        const peek = stack.peek();
        document.getElementById('stackTop').textContent = peek.success ? peek.value : '-';

        // Status
        const statusElement = document.getElementById('stackStatus');
        if (stack.isEmpty()) {
            statusElement.textContent = 'Empty';
            statusElement.className = 'info-value status-empty';
        } else if (stack.isFull()) {
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

    // Push operation
    function pushElement() {
        const input = document.getElementById('pushValue');
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

        const result = stack.push(numVal);

        if (result.success) {
            addLog(result.message, 'success');
            updateVisualization();
            input.value = '';
            input.focus();
        } else {
            addLog(result.message, 'error');
        }
    }

    // Pop operation
    function popElement() {
        const result = stack.pop();

        if (result.success) {
            addLog(result.message, 'success');
            updateVisualization();
        } else {
            addLog(result.message, 'error');
        }
    }

    // Peek Top
    function peekElement() {
        const result = stack.peek();

        if (result.success) {
            addLog(result.message, 'info');

            // Highlight the top element
            const elements = document.querySelectorAll('.stack-item');
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
    function clearStack() {
        const result = stack.clear();
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

        clearStack();
        await sleep(800);

        for (let value of [10, 20, 30]) {
            stack.push(value);
            updateVisualization();
            addLog(`Pushed ${value}`, 'success');
            await sleep(800);
        }

        peekElement();
        await sleep(1000);

        popElement();
        updateVisualization();
        await sleep(800);

        addLog('✅ Demonstration complete!', 'success');
    }

    // Allow Enter key
    document.getElementById('pushValue').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            pushElement();
        }
    });

    // Initialize
    updateVisualization();
    </script>
</html>
