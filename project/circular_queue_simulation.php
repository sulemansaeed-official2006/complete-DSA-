<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Circular Queue Simulation Playground</title>
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
        
        .cq-container {
             display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border: 2px dashed var(--border-color);
            padding: 2rem;
            position: relative;
        }
        
        .cq-visual {
            width: 300px;
            height: 300px;
            position: relative;
            border-radius: 50%;
            border: 2px dashed rgba(255,255,255,0.1);
        }
        
        .cq-cell {
            width: 60px;
            height: 60px;
            position: absolute;
            background: #1e293b;
            border: 2px solid #334155;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: white;
            transition: all 0.3s ease;
        }
        
        .cq-cell.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-color: var(--accent-color);
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.5);
        }
        
        .cq-cell .index-label {
            position: absolute;
            top: -20px;
            font-size: 0.8rem;
            color: var(--text-secondary);
        }
        
        .pointer-label {
            position: absolute;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 3px;
        }
        
        .front-pointer {
            background: var(--success-color);
            color: white;
            z-index: 10;
        }
        
        .rear-pointer {
            background: var(--danger-color);
            color: white;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="container sim-container">
        <div class="nav-header">
            <a href="circular_queue.php" class="back-link">← Back to Theory & Cards</a>
        </div>

        <header class="header">
            <h1>Circular Queue Simulation</h1>
            <p class="subtitle">Interactive Circular Array Visualization</p>
        </header>

        <!-- Visualization Canvas -->
        <section class="card">
            <div class="cq-container">
                <div id="cqVisual" class="cq-visual">
                    <!-- JS will generate cells -->
                </div>
            </div>

            <!-- Detailed Status Bar -->
             <div class="queue-info">
                <div class="info-item">
                    <span class="info-label">Size</span>
                    <span id="cqSize" class="info-value">0</span>
                </div>
                 <div class="info-item">
                    <span class="info-label">Front Index</span>
                    <span id="cqFront" class="info-value">-1</span>
                </div>
                 <div class="info-item">
                    <span class="info-label">Rear Index</span>
                    <span id="cqRear" class="info-value">-1</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Capacity</span>
                    <span id="cqCapacity" class="info-value">5</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span id="cqStatus" class="info-value status-empty">Empty</span>
                </div>
            </div>
        </section>

        <div class="controls-panel">
            <!-- Operations Column -->
            <div class="control-card">
                <h3 style="margin-bottom: 1rem; color: var(--accent-color);">Operations</h3>
                <div class="controls">
                    <div class="input-group">
                        <input type="number" id="enqueueValue" placeholder="Value" class="value-input">
                        <button onclick="enqueueElement()" class="btn btn-primary">Enqueue</button>
                    </div>
                    <button onclick="dequeueElement()" class="btn btn-danger">Dequeue</button>
                    <button onclick="peekElement()" class="btn btn-info">Peek</button>
                </div>
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

    const capacity = 5;
    const cq = new CircularQueue(capacity);
    const visualContainer = document.getElementById('cqVisual');

    // Initialize cells
    function initVisuals() {
        visualContainer.innerHTML = '';
        const r = 120; // Radius
        const centerX = 150;
        const centerY = 150;

        for (let i = 0; i < capacity; i++) {
            const angle = (i * 360 / capacity) - 90; // Start from top
            const rad = angle * (Math.PI / 180);
            const x = centerX + r * Math.cos(rad) - 30; // -30 for center offset (width/2)
            const y = centerY + r * Math.sin(rad) - 30;

            const cell = document.createElement('div');
            cell.className = 'cq-cell';
            cell.id = `cell-${i}`;
            cell.style.left = `${x}px`;
            cell.style.top = `${y}px`;
            cell.innerHTML = `<span class="index-label">${i}</span><span class="value"></span>`;
            visualContainer.appendChild(cell);
        }
    }

    function updateVisualization() {
        const items = cq.getItems();

        // Update cells
        for (let i = 0; i < capacity; i++) {
            const cell = document.getElementById(`cell-${i}`);
            const valSpan = cell.querySelector('.value');

            // Clear pointers
            const oldFront = cell.querySelector('.front-pointer');
            const oldRear = cell.querySelector('.rear-pointer');
            if (oldFront) oldFront.remove();
            if (oldRear) oldRear.remove();

            if (items[i] !== null) {
                cell.classList.add('active');
                valSpan.innerText = items[i];
            } else {
                cell.classList.remove('active');
                valSpan.innerText = '';
            }

            // Add pointers
            if (!cq.isEmpty()) {
                if (i === cq.front) {
                    const fp = document.createElement('div');
                    fp.className = 'pointer-label front-pointer';
                    fp.innerText = 'F';
                    fp.style.top = '-25px';
                    fp.style.left = '-10px';
                    cell.appendChild(fp);
                }
                if (i === cq.rear) {
                    const rp = document.createElement('div');
                    rp.className = 'pointer-label rear-pointer';
                    rp.innerText = 'R';
                    rp.style.bottom = '-25px';
                    rp.style.right = '-10px';
                    cell.appendChild(rp);
                }
            }
        }

        // Status Info
        document.getElementById('cqSize').textContent = cq.size;
        document.getElementById('cqFront').textContent = cq.front;
        document.getElementById('cqRear').textContent = cq.rear;

        const statusElement = document.getElementById('cqStatus');
        if (cq.isEmpty()) {
            statusElement.textContent = 'Empty';
            statusElement.className = 'info-value status-empty';
        } else if (cq.isFull()) {
            statusElement.textContent = 'Full';
            statusElement.className = 'info-value status-full';
        } else {
            statusElement.textContent = 'Normal';
            statusElement.className = 'info-value status-normal';
        }
    }


    function addLog(message, type = 'info') {
        const logContainer = document.getElementById('operationLog');
        const logEntry = document.createElement('div');
        logEntry.className = `log-entry log-${type}`;
        logEntry.innerText = `[${new Date().toLocaleTimeString()}] ${message}`;
        logContainer.appendChild(logEntry);
        logContainer.scrollTop = logContainer.scrollHeight;
    }

    function enqueueElement() {
        const input = document.getElementById('enqueueValue');
        const val = input.value.trim();
        if (!val) {
            addLog('Please enter a value', 'error');
            return;
        }

        const res = cq.enqueue(parseInt(val));
        if (res.success) {
            addLog(res.message, 'success');
            updateVisualization();
            input.value = '';
        } else {
            addLog(res.message, 'error');
        }
    }

    function dequeueElement() {
        const res = cq.dequeue();
        if (res.success) {
            addLog(res.message, 'success');
            updateVisualization();
        } else {
            addLog(res.message, 'error');
        }
    }

    function peekElement() {
        const res = cq.peek();
        if (res.success) {
            addLog(res.message, 'info');
            // Highlight front
            const cell = document.getElementById(`cell-${cq.front}`);
            if (cell) {
                cell.style.boxShadow = '0 0 20px #fff';
                setTimeout(() => cell.style.boxShadow = '', 1000);
            }
        } else {
            addLog(res.message, 'error');
        }
    }

    // Allow Enter key
    document.getElementById('enqueueValue').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            enqueueElement();
        }
    });


    initVisuals();
    updateVisualization();
    </script>
</html>
