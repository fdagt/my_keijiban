<footer>
    <ul>
	<li><a href="/new-thread.php">新しいスレッド</a></li>
	<li><a href="/report.php<?php 
				if (isset($current_thread_id)) 
				    echo '?id=', $current_thread_id;
				?>">通報</a></li>
	<li><a href="/admin/index.php">管理ページ</a></li>
    </ul>
</footer>
