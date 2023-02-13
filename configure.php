<?php

$questions = [
    ':package_name' => 'Package Name',
    ':package_vendor' => 'Package Vendor',
    ':repo_user_name' => 'Repo Username',
    ':package_title' => 'Package Title',
    ':package_description' => 'Package Description',
    ':author_name' => 'Author Name',
    ':author_email' => 'Author Email',
    ':author_homepage' => 'Author Homepage',
];

$files =  [
    'README.md',
    'composer.json',
    'src/PackageServiceProvider.php'
];

function convertStudlyCase($value) {
    return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value)));
}

echo <<<_LOGO

    __                     __              ____
   / /   ____ __________ _/ /_____  ____  / / /_  ____  _  __
  / /   / __ `/ ___/ __ `/ __/ __ \/ __ \/ / __ \/ __ \| |/_/
 / /___/ /_/ / /  / /_/ / /_/ /_/ / /_/ / / /_/ / /_/ />  <
/_____/\__,_/_/   \__,_/\__/\____/\____/_/_.___/\____/_/|_|

Note : Use dash(-) or underline(_) if vendor name or package name has multi word
_LOGO;

foreach ($questions as $key => $question) {
    $answers[$key] = readline(sprintf('%s : ', $question));
}
$answers[':package_name_namespace'] = convertStudlyCase($answers[':package_name']);
$answers[':package_vendor_namespace'] = convertStudlyCase($answers[':package_vendor']);

foreach ($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace(array_reverse(array_keys($answers)), array_reverse(array_values($answers)), $content);
    file_put_contents($file, $content);
}

echo 'Completed.'.PHP_EOL;

if (readline('Delete file ? [y/n] ') === 'y') {
    unlink('configure.php');
}
