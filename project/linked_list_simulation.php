<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linked List Simulation Playground</title>
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
        
        .ll-container {
             display: flex;
            align-items: center;
            min-height: 250px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border: 2px dashed var(--border-color);
            padding: 2rem;
            overflow-x: auto;
        }
        
        .ll-node-visual {
            display: flex;
            align-items: center;
            margin-right: 10px;
            animation: fadeIn 0.5s ease-out;
        }
        
        .node-circle {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
            border: 2px solid white;
        }
        
        .node-arrow {
            width: 40px;
            height: 4px;
            background: var(--link-color, #94a3b8);
            position: relative;
            margin: 0 10px;
        }
        
        .node-arrow::after {
            content: '';
            position: absolute;
            right: -8px;
            top: -6px;
            border: 8px solid transparent;
            border-left-color: var(--link-color, #94a3b8);
        }
        
        .head-label, .tail-label {
            position: absolute;
            top: -30px;
            font-size: 0.8rem;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 10px;
        }
        
        .head-label { background: var(--success-color); color: white; }
        .tail-label { background: var(--warning-color); color: white; }

        .null-node {
            font-family: 'Fira Code', monospace;
            color: var(--danger-color);
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container sim-container">
        <div class="nav-header">
            <a href="linked_list.php" class="back-link">← Back to Theory & Cards</a>
        </div>

        <header class="header">
            <h1>Linked List Simulation</h1>
            <p class="subtitle">Interactive Dynamic List Visualization</p>
        </header>

        <!-- Visualization Canvas -->
        <section class="card">
            <div class="ll-container" id="llVisual">
                <div class="empty-message">List is Empty</div>
            </div>

            <!-- Detailed Status Bar -->
             <div class="queue-info">
                <div class="info-item">
                    <span class="info-label">Size</span>
                    <span id="llSize" class="info-value">0</span>
                </div>
                 <div class="info-item">
                    <span class="info-label">Start Value</span>
                    <span id="llStart" class="info-value">-</span>
                </div>
                 <div class="info-item">
                    <span class="info-label">End Value</span>
                    <span id="llEnd" class="info-value">-</span>
                </div>
            </div>
        </section>

        <div class="controls-panel">
            <!-- Operations Column -->
            <div class="control-card">
                <h3 style="margin-bottom: 1rem; color: var(--accent-color);">Operations</h3>
                <div class="controls">
                    <!-- Row 1: Front/Last Insertion -->
                    <div class="input-group" style="margin-bottom: 15px;">
                        <input type="number" id="llValue" placeholder="Value" class="value-input" style="width: 100px;">
                        <button onclick="prependNode()" class="btn btn-primary" title="Insert at Front">Insert Front</button>
                        <button onclick="appendNode()" class="btn btn-primary" title="Insert at Last" style="background: linear-gradient(135deg, #4f46e5, #4338ca);">Insert Last</button>
                    </div>

                    <!-- Row 2: Position Insertion -->
                    <div class="input-group" style="margin-bottom: 25px;">
                         <input type="number" id="llPosInsert" placeholder="Pos" class="value-input" style="width: 80px; border-color: var(--accent-color);">
                         <button onclick="insertAtPosition()" class="btn btn-info" style="width: 100%;">Insert at Position</button>
                    </div>
                    
                    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 15px 0;">

                    <!-- Row 3: Deletions -->
                    <div class="button-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-bottom: 15px;">
                        <button onclick="deleteFirst()" class="btn btn-danger">Delete Front</button>
                        <button onclick="deleteLast()" class="btn btn-danger">Delete Last</button>
                    </div>

                    <!-- Row 4: Position Deletion -->
                    <div class="input-group">
                        <input type="number" id="llPosDelete" placeholder="Pos" class="value-input" style="width: 80px; border-color: var(--danger-color);">
                        <button onclick="deleteAtPosition()" class="btn btn-danger" style="width: 100%; background: linear-gradient(135deg, #ef4444, #dc2626);">Delete at Position</button>
                    </div>
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
            return { success: true, message: `Inserted at Last: ${value}` };
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
            return { success: true, message: `Inserted at Front: ${value}` };
        }

        insertAt(value, pos) { // 1-based index
            if (pos < 1 || pos > this.size + 1) {
                return { success: false, message: `Invalid Position (1 to ${this.size + 1})` };
            }
            if (pos === 1) return this.prepend(value);
            if (pos === this.size + 1) return this.append(value);

            const newNode = new Node(value);
            let current = this.head;
            let prev = null;
            let idx = 1;
            while(idx < pos) {
                prev = current;
                current = current.next;
                idx++;
            }
            prev.next = newNode;
            newNode.next = current;
            this.size++;
            return { success: true, message: `Inserted ${value} at Pos ${pos}` };
        }

        deleteFirst() {
            if (!this.head) return { success: false, message: 'List is empty' };

            const val = this.head.value;
            this.head = this.head.next;
            this.size--;

            if (this.size === 0) this.tail = null;

            return { success: true, message: `Deleted Front: ${val}` };
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

        deleteAt(pos) { // 1-based index
            if (pos < 1 || pos > this.size) {
                 return { success: false, message: `Invalid Position (1 to ${this.size})` };
            }
            if (pos === 1) return this.deleteFirst();
            if (pos === this.size) return this.deleteLast();

            let current = this.head;
            let prev = null;
            let idx = 1;
            while(idx < pos) {
                prev = current;
                current = current.next;
                idx++;
            }
            const val = current.value;
            prev.next = current.next;
            if(current === this.tail) this.tail = prev; // Should be handled by deleteLast check above but safe to have
            this.size--;
            return { success: true, message: `Deleted Pos ${pos}: ${val}` };
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

    const ll = new LinkedList();
    const visualContainer = document.getElementById('llVisual');

    function updateVisualization() {
        visualContainer.innerHTML = '';

        let current = ll.head;
        let index = 0;

        if (!current) {
            visualContainer.innerHTML = '<div class="empty-message">List is Empty</div>';
        } else {
            while (current) {
                const nodeDiv = document.createElement('div');
                nodeDiv.className = 'll-node-visual';

                // Node Circle
                const circle = document.createElement('div');
                circle.className = 'node-circle';
                circle.innerText = current.value;

                // Labels
                if (index === 0) {
                    const headLbl = document.createElement('div');
                    headLbl.className = 'head-label';
                    headLbl.innerText = 'Start';
                    circle.appendChild(headLbl);
                }
                if (!current.next) {
                    const tailLbl = document.createElement('div');
                    tailLbl.className = 'tail-label';
                    tailLbl.innerText = 'End';
                    circle.appendChild(tailLbl);
                }

                nodeDiv.appendChild(circle);

                // Arrow (if next exists) or NULL
                if (current.next) {
                    const arrow = document.createElement('div');
                    arrow.className = 'node-arrow';
                    nodeDiv.appendChild(arrow);
                } else {
                    const arrow = document.createElement('div');
                    arrow.className = 'node-arrow';
                    nodeDiv.appendChild(arrow);

                    const nullNode = document.createElement('div');
                    nullNode.className = 'null-node';
                    nullNode.innerText = 'NULL';
                    nodeDiv.appendChild(nullNode);
                }

                visualContainer.appendChild(nodeDiv);

                current = current.next;
                index++;
            }
        }

        // Status
        document.getElementById('llSize').innerText = ll.size;
        document.getElementById('llStart').innerText = ll.head ? ll.head.value : '-';
        document.getElementById('llEnd').innerText = ll.tail ? ll.tail.value : '-';
    }

    function addLog(message, type = 'info') {
        const logContainer = document.getElementById('operationLog');
        const logEntry = document.createElement('div');
        logEntry.className = `log-entry log-${type}`;
        logEntry.innerText = `[${new Date().toLocaleTimeString()}] ${message}`;
        logContainer.appendChild(logEntry);
        logContainer.scrollTop = logContainer.scrollHeight;
    }

    function appendNode() {
        const input = document.getElementById('llValue');
        const val = input.value.trim();
        if (!val) {
            addLog('Please enter a value', 'error');
            return;
        }
        const res = ll.append(parseInt(val));
        addLog(res.message, 'success');
        updateVisualization();
        input.value = '';
    }

    function prependNode() {
        const input = document.getElementById('llValue');
        const val = input.value.trim();
        if (!val) {
            addLog('Please enter a value', 'error');
            return;
        }
        const res = ll.prepend(parseInt(val));
        addLog(res.message, 'success');
        updateVisualization();
        input.value = '';
    }

    function deleteFirst() {
        const res = ll.deleteFirst();
        addLog(res.message, res.success ? 'success' : 'error');
        updateVisualization();
    }

    function deleteLast() {
        const res = ll.deleteLast();
        addLog(res.message, res.success ? 'success' : 'error');
        updateVisualization();
    }

    function insertAtPosition() {
        const valInput = document.getElementById('llValue');
        const posInput = document.getElementById('llPosInsert');
        const val = valInput.value.trim();
        const pos = posInput.value.trim();

        if (!val || !pos) {
            addLog('Please enter both Value and Position', 'error');
            return;
        }
        const res = ll.insertAt(parseInt(val), parseInt(pos));
        addLog(res.message, res.success ? 'success' : 'error');
        updateVisualization();
        if(res.success) { valInput.value = ''; posInput.value = ''; }
    }

    function deleteAtPosition() {
        const posInput = document.getElementById('llPosDelete');
        const pos = posInput.value.trim();

        if (!pos) {
            addLog('Please enter a Position', 'error');
            return;
        }
        const res = ll.deleteAt(parseInt(pos));
        addLog(res.message, res.success ? 'success' : 'error');
        updateVisualization();
        if(res.success) posInput.value = '';
    }

    // Allow Enter
    document.getElementById('llValue').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') appendNode();
    });

    updateVisualization();
    </script>
</html>
