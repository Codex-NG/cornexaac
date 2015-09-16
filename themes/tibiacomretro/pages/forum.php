
<?php 

$forum = app('forum');

// View all boards
if (! isset($_GET['board']) or isset($_GET['post'])):
    $boards = $forum->getBoards();

    include theme('pages/forum/index.php');
endif; 

// Show specific board
if (isset($_GET['board']) && !isset($_GET['thread'])):
    $board = app('forumboard')->where('id', $_GET['board'])->first();
    
    // Redirect to forum if the board not exists
    if (is_null($board)) {
        redirect('?subtopic=forum');
    }

    $threads = $board->threads();

    if (isset($_GET['action'])) {
        include theme('pages/forum/board/'.$_GET['action'].'.php');
    } else {
        include theme('pages/forum/board/show.php');
    }

endif; 

// Show specific thread
if (isset($_GET['thread'])): 
    $thread = app('forumpost')->where('id', $_GET['thread'])->first();

    if (isset($_GET['action'])) {
        include theme('pages/forum/thread/'.$_GET['action'].'.php');
    } else {
        include theme('pages/forum/thread/show.php');
    }

endif; 

?>