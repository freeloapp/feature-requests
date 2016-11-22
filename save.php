<?php

if( !empty($_POST) )
{
    require dirname( __FILE__ ) . '/config.php';
    
    mysqli_query($db, "DELETE FROM ideas_log WHERE cookie = '{$_COOKIE['user']}' AND ideas_id = '{$_POST['id']}' ");
    
    if( $_POST['vote'] != 0 )
        mysqli_query($db, "INSERT INTO ideas_log (ideas_id, cookie, ip, `date`, `vote` ) VALUES ('{$_POST['id']}', '{$_COOKIE['user']}', '{$_SERVER['REMOTE_ADDR']}', NOW(), '{$_POST['vote']}' );");
    
    mysqli_query($db, "UPDATE ideas SET likes = ( SELECT COUNT(*) FROM ideas_log WHERE vote = 1 AND ideas_id = '{$_POST['id']}' ) WHERE id = '{$_POST['id']}'");
    mysqli_query($db, "UPDATE ideas SET dislikes = ( SELECT COUNT(*) FROM ideas_log WHERE vote = -1 AND ideas_id = '{$_POST['id']}' ) WHERE id = '{$_POST['id']}'");
    
}