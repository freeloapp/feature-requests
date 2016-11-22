<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hlasování</title>
	<link rel="stylesheet" href="css/layout-public.css">
	<meta name="description" content="">
	<meta name="author" content="Freelo">
	<meta property="fb:app_id" content="">
	<meta property="fb:page_id" content="">
	<meta property="og:image" content="">
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta property="og:type" content="article">
	<meta property="og:site_name" content="">
	<meta name="twitter:site" content="">
	<meta property="twitter:title" content="">
	<meta property="twitter:description" content="">
	<meta property="twitter:card" content="summary_large_image">
	<meta property="twitter:image:src" content="">
    <link rel="icon" type="image/png" href="img/favicon.png">
</head>
<body>
	<div class="container">
    <a href="<?php echo CONFIG_URL; ?>"><img src="img/logo.png" style="-ms-interpolation-mode: bicubic; outline: none; text-decoration: none; border: none; width: 184px; height: 33px;" /></a>
    
    <div class="public-todolists-wrap">
    	<h1 class="public-project-headline">Hlasuj o nových funkcích</h1>
    	
    	
    	<?php
    	
    	$array = [];
        
        require dirname(__FILE__) . '/config.php';
        
        if( isset($_POST['idea']) && !empty($_POST['idea']) )
        {
            $_POST['idea'] = mysqli_real_escape_string($db, $_POST['idea']);
            mysqli_query($db, "INSERT INTO ideas (groupname, idea, likes, dislikes, active, cookie, ip, email) VALUES (NULL, '" . mysqli_real_escape_string($_POST['idea']) . "', 0, 0, 1, '" . mysqli_real_escape_string($_COOKIE['user']) . "', '" . mysqli_real_escape_string($_SERVER['REMOTE_ADDR']) . "', '" . mysqli_real_escape_string($_POST['email']) . "')");
            
            $headers = "";
            if( !empty($_POST['email']) )
            {
                $headers = "From: {$_POST['email']}" . "\r\n";    
            }
            
            mail(CONFIG_EMAIL, "Navrh na funkci", $_POST['idea'], $headers );
        }
        
        $result = mysqli_query($db, "SELECT id, groupname, idea, likes, dislikes, (SELECT vote FROM ideas_log WHERE ideas_id = ideas.id AND cookie = '" . mysqli_real_escape_string($_COOKIE['user']) ."' LIMIT 1 ) AS myrating FROM ideas WHERE active = 1 AND groupname IS NOT NULL ORDER BY id");
  
        while ($row = mysqli_fetch_assoc($result))
        {
            if( $row['myrating'] == null )
                $row['myrating'] = 0;
                
            $array[ $row['groupname'] ][] = $row;
        }
        
        
    	
    	
    	foreach( $array as $list => $item )
    	{
    		echo '<div class="public-todolist">
            <h2 class="public-to-do-list-headline"><span>'.$list.'</span></h2>
            <table>
                <tbody>';
              
			foreach($item as $polozka)
			{
				echo '<tr class="todo " >
                    <td class="public-todo__checkbox">○</td>
                    <td class="public-todo__content">';
                    
                echo '<span class="rating" id="rating-'.$polozka['id'].'" data-myrating="'.$polozka['myrating'].'" data-id="'.$polozka['id'].'">
            <button data-count="'.$polozka['likes'].'" data-vote="1" class="btn btn-default btn-xs like '. ( $polozka['myrating'] == 1 ? 'active' : ''  ) .' "><span class="like-text">Líbí</span> <span class="likes">'.$polozka['likes'].'</span>
            <span class="hlasuj">Hlasuj!</span>
            </button>
            <button data-count="'.$polozka['dislikes'].'" data-vote="-1" class="btn btn-default btn-xs dislike '. ( $polozka['myrating'] == -1 ? 'active' : ''  ) .'"><span class="like-text">Nelíbí</span> <span class="likes">'.$polozka['dislikes'].'</span>
            <span class="hlasuj">Hlasuj!</span>
            </button>
            </span>';
                    
                    echo '<span class="content">'.$polozka['idea'].'</span>';

						if( !empty($polozka['date']) )
						{
							echo '<span class="public-todo__metadata"> Term&iacute;n: '.$polozka['date'].' </span>'; 
						}
				echo '			
					</td>
                </tr>';
			}  
			    
                
            echo '</tbody>
            </table>
        </div>';    
    		
    	}
    	
    	
    	
    	?>

        <div class="public-todolist">
        <h2><span>Navržené funkce <small>(Po diskuzi některé zařadíme do hlasování)</small></span></h2>
        
        <table>
            <tbody>
        
        <?php
        
           	$result = mysqli_query($db, "SELECT idea FROM ideas WHERE active = 1 AND groupname is null ORDER BY id ASC");
      
            while ($row = mysqli_fetch_assoc($result))
            {                
                $items[] = $row;
            }

			foreach($items as $polozka)
			{
				echo '<tr class="todo " >
                    <td class="public-todo__checkbox">○</td>
                    <td class="public-todo__content">';
                 
                    echo '<span class="content">'.$polozka['idea'].'</span>';

		
				echo '			
					</td>
                </tr>';
			}  
        
        ?>
        
            </tbody>
        </table>
        </div>
    	
        
        
    	<h2 id="navrhni"><span>Navrhni funkci</span></h2>

        <form action="#navrhni" method="post" class="well center-block"> 
            <div class="form-group"> <input type="text" name="idea" class="form-control" id="questionFormID" placeholder="Zadej tvůj nápad na funkci…" /> </div>
            <div class="form-group"> <input type="email" name="email" class="form-control" id="questionEmail" placeholder="Pokud chceš, dej nám na sebe e-mail" /> </div>
            <button type="submit" class="btn btn-primary">Odeslat návrh</button>
        </form>
        
    </div>
    <footer class="">
        <a href="<?php echo CONFIG_URL; ?>"> <img src="img/avatar.png" alt="" width="80" /> </a>
    </footer>
    
    
    <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script src="js-cookie.js"></script>
    <script src="ideas.js"></script>

	<!-- Google Analytics and others here. -->

    
</div>
</body>
</html>