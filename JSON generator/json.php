<?php
// Define an array of GitHub repositories


// Read the JSON file
$file = 'apps.json';
$json = file_get_contents($file);

// Convert the JSON string to a PHP array
$github_repos = json_decode($json, true);

// Loop through each repository and retrieve the latest release information
$data = array();
foreach ($github_repos as $repo) {
    $release_url = "https://api.github.com/repos/{$repo['user']}/{$repo['repo']}/releases";
    $ch = curl_init($release_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: PHP'));
    $result = curl_exec($ch);
    curl_close($ch);
    $releases = json_decode($result);

    $latest_apk_release = null;

    foreach ($releases as $release) {
        foreach ($release->assets as $asset) {
            if (strtolower(pathinfo($asset->name, PATHINFO_EXTENSION)) === 'apk') {
                if (!$latest_apk_release || strtotime($release->published_at) > strtotime($latest_apk_release->published_at)) {
                    $latest_apk_release = $release;
                }
                break;
            }
        }
    }

    if ($latest_apk_release) {
        $file_url = $latest_apk_release->assets[0]->browser_download_url;
        $moreinfo = 'https://github.com/'. $repo['user'] . '/' . $repo['repo'];
        $data[] = array('user' => $repo['user'], 'name' => $repo['repo'], 'latest_release_file' => $file_url, 'type' => $repo['type'], 'moreinfo' => $moreinfo);
    }
}


// Save the links to the latest release files in a JSON file
file_put_contents('latest-release.json', json_encode($data, JSON_PRETTY_PRINT));
?>