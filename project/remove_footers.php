<?php
$directory = 'd:/XAMPP/htdocs/project';
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filePath = $file->getRealPath();
        $content = file_get_contents($filePath);
        
        // Match the footer block that contains "Created with ❤️"
        // Pattern: <footer class="footer"> ... Created with ❤️ ... </footer>
        // Using s flag for dot to match newlines
        $pattern = '/\s*<footer class="footer">\s*<p>Created with ❤️.*?<\/p>\s*<\/footer>/s';
        
        if (preg_match($pattern, $content)) {
            $newContent = preg_replace($pattern, '', $content);
            file_put_contents($filePath, $newContent);
            echo "Cleaned: $filePath\n";
        }
    }
}
echo "All done!\n";
?>
