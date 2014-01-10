<?php

$dists = array();

echo '<h1>Choose your CodeIgniter dist:</h1>';

echo '<ul>';

foreach(glob('dists/CodeIgniter_*', GLOB_ONLYDIR) as $dist) {
    $dist_id = md5($dist);
    $dists[$dist_id] = array(realpath($dist.'/system/'), realpath($dist.'/application/'), null, array('encryption_key' => 'TEST_KEY'));
    echo '<li><a href="'.$_SERVER['PHP_SELF'].'?dist_id='.$dist_id.'">'.str_replace(array('_', 'dists/'), array(' ', ''), $dist).'</a></li>';
}

echo '</ul>';

if (!$dists) {
    echo '<p>No dists found. Please refer to tests/dists/readme file for instructions.</p>';
}

if (isset($_GET['dist_id']) && isset($dists[$_GET['dist_id']])) {
    $dist = $dists[$_GET['dist_id']];
    echo '<h2>Testing the <code>'.str_replace('/system', '', $dist[0]).'</code>:</h2>';
    echo '<hr />';
    
    require '../CoreIgniter.php';
    
    try {
        $CI = call_user_func_array(array('CoreIgniter', 'init'), $dist);
    } catch (CoreIgniterException $e) {
        exit($e->getMessage());
    }
    
    $CI->load->library('session');
    
    echo '<h3>Session functionality <code>$CI->session->userdata</code>:</h3>';
    
    echo '<pre>';
    print_r($CI->session->userdata);
    echo '</pre>';
    
    echo '<hr />';
    
    echo "<h3>Input and XSS filtering functionality <code>\$CI->input->get('dist_id', true)</code>:</h3>";
    
    echo '<pre>';
    print_r($CI->input->get('dist_id', true));
    echo '</pre>';
    
    //@TODO more tests
}