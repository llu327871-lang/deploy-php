<?php
Auth::requireLogin();

$user = Auth::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Editor - User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .editor-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .editor-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .editor-toolbar {
            background: #f8f9fa;
            padding: 0.5rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }
        .btn-editor {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-editor:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(102, 126, 234, 0.3);
        }
        .language-selector {
            min-width: 120px;
        }
        #editor {
            height: calc(100vh - 200px);
            width: 100%;
        }
        .sidebar {
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 1rem;
            min-height: calc(100vh - 140px);
        }
        .file-tree {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .file-item {
            padding: 0.5rem;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .file-item:hover {
            background-color: #e9ecef;
        }
        .file-item.active {
            background-color: #667eea;
            color: white;
        }
        .output-panel {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 1rem;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            border-top: 1px solid #dee2e6;
            max-height: 200px;
            overflow-y: auto;
        }
        .status-bar {
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            color: #6c757d;
        }
        .split-panel {
            display: flex;
            height: calc(100vh - 140px);
        }
        .main-editor {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand text-white fw-bold" href="/dashboard">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="badge bg-light text-dark me-3">
                    <i class="fas fa-code me-1"></i>Code Editor
                </span>
                <span class="text-white me-3">
                    <i class="fas fa-user-circle me-2"></i><?php echo htmlspecialchars($user['name']); ?>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-3">
        <div class="editor-container">
            <div class="editor-header">
                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-code me-2"></i>Online Code Editor
                    </h5>
                    <small class="text-light opacity-75">Write, edit, and test your code</small>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-light btn-sm" onclick="runCode()">
                        <i class="fas fa-play me-1"></i>Run
                    </button>
                    <button class="btn btn-outline-light btn-sm" onclick="saveFile()">
                        <i class="fas fa-save me-1"></i>Save
                    </button>
                    <button class="btn btn-outline-light btn-sm" onclick="downloadFile()">
                        <i class="fas fa-download me-1"></i>Download
                    </button>
                </div>
            </div>

            <div class="editor-toolbar">
                <select class="form-select form-select-sm language-selector" id="languageSelect">
                    <option value="javascript">JavaScript</option>
                    <option value="python">Python</option>
                    <option value="php">PHP</option>
                    <option value="html">HTML</option>
                    <option value="css">CSS</option>
                    <option value="java">Java</option>
                    <option value="cpp">C++</option>
                    <option value="csharp">C#</option>
                    <option value="typescript">TypeScript</option>
                    <option value="sql">SQL</option>
                    <option value="json">JSON</option>
                    <option value="xml">XML</option>
                </select>

                <div class="vr"></div>

                <button class="btn btn-editor btn-sm" onclick="newFile()">
                    <i class="fas fa-file-plus me-1"></i>New
                </button>
                <button class="btn btn-editor btn-sm" onclick="openFile()">
                    <i class="fas fa-folder-open me-1"></i>Open
                </button>

                <div class="vr"></div>

                <button class="btn btn-editor btn-sm" onclick="undo()">
                    <i class="fas fa-undo me-1"></i>Undo
                </button>
                <button class="btn btn-editor btn-sm" onclick="redo()">
                    <i class="fas fa-redo me-1"></i>Redo
                </button>

                <div class="vr"></div>

                <button class="btn btn-editor btn-sm" onclick="formatCode()">
                    <i class="fas fa-magic me-1"></i>Format
                </button>
                <button class="btn btn-editor btn-sm" onclick="findReplace()">
                    <i class="fas fa-search me-1"></i>Find
                </button>
            </div>

            <div class="split-panel">
                <!-- Sidebar -->
                <div class="sidebar d-none d-md-block" style="width: 250px;">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-folder me-2"></i>Files
                    </h6>
                    <ul class="file-tree" id="fileTree">
                        <li class="file-item active" data-file="welcome.js">
                            <i class="fas fa-file-code me-2"></i>welcome.js
                        </li>
                        <li class="file-item" data-file="example.html">
                            <i class="fas fa-file-code me-2"></i>example.html
                        </li>
                        <li class="file-item" data-file="styles.css">
                            <i class="fas fa-file-code me-2"></i>styles.css
                        </li>
                    </ul>

                    <hr class="my-3">

                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-terminal me-2"></i>Console
                    </h6>
                    <div class="output-panel" id="outputPanel">
                        Welcome to the Code Editor!<br>
                        Select a language and start coding...<br>
                    </div>
                </div>

                <!-- Main Editor -->
                <div class="main-editor">
                    <div id="editor"></div>
                    <div class="status-bar">
                        <span id="cursorPosition">Ln 1, Col 1</span>
                        <span id="fileEncoding" class="ms-3">UTF-8</span>
                        <span id="languageStatus" class="ms-3">JavaScript</span>
                        <span id="fileSize" class="ms-3">0 bytes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monaco Editor Loader -->
    <script src="vs/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let editor;
        let currentFile = 'welcome.js';
        let currentLanguage = 'javascript';

        // Sample code for different languages
        const sampleCode = {
            javascript: `// Welcome to JavaScript!
function greet(name) {
    console.log(\`Hello, \${name}!\`);
    return \`Welcome to the code editor, \${name}!\`;
}

// Call the function
const result = greet('Developer');
console.log(result);

// Try editing this code and click Run to see the output!
`,
            python: `# Welcome to Python!
def greet(name):
    print(f"Hello, {name}!")
    return f"Welcome to the code editor, {name}!"

# Call the function
result = greet("Developer")
print(result)

# Try editing this code and click Run to see the output!
`,
            php: `<?php
// Welcome to PHP!
function greet($name) {
    echo "Hello, $name!" . PHP_EOL;
    return "Welcome to the code editor, $name!";
}

// Call the function
$result = greet("Developer");
echo $result . PHP_EOL;

// Try editing this code and click Run to see the output!
?>`,
            html: `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Web Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #667eea;
        }
    </style>
</head>
<body>
    <h1>Hello, World!</h1>
    <p>Welcome to the code editor!</p>
    <p>This is a sample HTML page.</p>
</body>
</html>`,
            css: `/* Welcome to CSS! */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    margin: 0;
    padding: 50px;
    text-align: center;
}

h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
}

.button {
    background: rgba(255,255,255,0.2);
    border: 2px solid white;
    color: white;
    padding: 12px 30px;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.button:hover {
    background: white;
    color: #667eea;
    transform: translateY(-2px);
}`
        };

        // Initialize Monaco Editor
        require.config({ paths: { vs: 'vs' } });
        require(['vs/editor/editor.main'], function() {
            editor = monaco.editor.create(document.getElementById('editor'), {
                value: sampleCode.javascript,
                language: 'javascript',
                theme: 'vs-dark',
                fontSize: 14,
                minimap: { enabled: true },
                scrollBeyondLastLine: false,
                automaticLayout: true,
                wordWrap: 'on',
                tabSize: 4,
                insertSpaces: true
            });

            // Update status bar
            updateStatusBar();

            // Listen for changes
            editor.onDidChangeCursorPosition(updateCursorPosition);
            editor.onDidChangeModelContent(updateFileSize);
        });

        // Language selector
        document.getElementById('languageSelect').addEventListener('change', function() {
            currentLanguage = this.value;
            const model = editor.getModel();
            monaco.editor.setModelLanguage(model, currentLanguage);

            // Load sample code for the selected language
            if (sampleCode[currentLanguage]) {
                editor.setValue(sampleCode[currentLanguage]);
            }

            updateStatusBar();
        });

        // File tree interaction
        document.querySelectorAll('.file-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.file-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                currentFile = this.dataset.file;
                // In a real implementation, you'd load the file content here
                console.log('Loading file:', currentFile);
            });
        });

        function updateStatusBar() {
            document.getElementById('languageStatus').textContent = document.getElementById('languageSelect').options[document.getElementById('languageSelect').selectedIndex].text;
            updateFileSize();
        }

        function updateCursorPosition() {
            const position = editor.getPosition();
            document.getElementById('cursorPosition').textContent = `Ln ${position.lineNumber}, Col ${position.column}`;
        }

        function updateFileSize() {
            const content = editor.getValue();
            const size = new Blob([content]).size;
            document.getElementById('fileSize').textContent = formatBytes(size);
        }

        function formatBytes(bytes) {
            if (bytes === 0) return '0 bytes';
            const k = 1024;
            const sizes = ['bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function runCode() {
            const code = editor.getValue();
            const output = document.getElementById('outputPanel');

            // Clear previous output
            output.innerHTML = '<div class="text-warning">Running code...</div>';

            // Simulate code execution (in a real implementation, you'd send to a backend)
            setTimeout(() => {
                let result = '';

                if (currentLanguage === 'javascript') {
                    try {
                        // Simple JS execution simulation
                        if (code.includes('console.log')) {
                            result = 'Code executed successfully!\nCheck browser console for output.';
                        } else {
                            result = 'Code executed successfully!';
                        }
                    } catch (e) {
                        result = `Error: ${e.message}`;
                    }
                } else {
                    result = `${currentLanguage.toUpperCase()} code execution simulation complete!\n\nIn a full implementation, this would run the code on a server.`;
                }

                output.innerHTML = result.replace(/\n/g, '<br>');
            }, 1000);
        }

        function saveFile() {
            const code = editor.getValue();
            const blob = new Blob([code], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = currentFile;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            showToast('File saved successfully!', 'success');
        }

        function downloadFile() {
            saveFile(); // Same as save for now
        }

        function newFile() {
            editor.setValue('');
            currentFile = 'untitled.' + getFileExtension(currentLanguage);
            updateStatusBar();
            showToast('New file created', 'info');
        }

        function openFile() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.js,.py,.php,.html,.css,.java,.cpp,.cs,.ts,.sql,.json,.xml,.txt';
            input.onchange = function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        editor.setValue(e.target.result);
                        currentFile = file.name;
                        // Try to detect language from extension
                        const ext = file.name.split('.').pop().toLowerCase();
                        const langMap = {
                            'js': 'javascript', 'py': 'python', 'php': 'php', 'html': 'html', 'css': 'css',
                            'java': 'java', 'cpp': 'cpp', 'cc': 'cpp', 'cxx': 'cpp', 'c': 'c',
                            'cs': 'csharp', 'ts': 'typescript', 'sql': 'sql', 'json': 'json', 'xml': 'xml'
                        };
                        if (langMap[ext]) {
                            currentLanguage = langMap[ext];
                            document.getElementById('languageSelect').value = currentLanguage;
                            const model = editor.getModel();
                            monaco.editor.setModelLanguage(model, currentLanguage);
                        }
                        updateStatusBar();
                        showToast(`File "${file.name}" loaded successfully!`, 'success');
                    };
                    reader.readAsText(file);
                }
            };
            input.click();
        }

        function getFileExtension(language) {
            const extMap = {
                'javascript': 'js', 'python': 'py', 'php': 'php', 'html': 'html', 'css': 'css',
                'java': 'java', 'cpp': 'cpp', 'csharp': 'cs', 'typescript': 'ts', 'sql': 'sql',
                'json': 'json', 'xml': 'xml'
            };
            return extMap[language] || 'txt';
        }

        function undo() {
            editor.trigger('', 'undo');
        }

        function redo() {
            editor.trigger('', 'redo');
        }

        function formatCode() {
            editor.getAction('editor.action.formatDocument').run();
        }

        function findReplace() {
            editor.getAction('actions.find').run();
        }

        function showToast(message, type) {
            const toastContainer = document.getElementById('toastContainer') || createToastContainer();

            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
            return container;
        }
    </script>
</body>
</html>