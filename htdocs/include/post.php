<?php
require_once __DIR__.'/model/const.php';
require_once __DIR__.'/model/util.php';

if ($post['is_hidden'] === IS_HIDDEN_FALSE): ?>
    <div id="post-<?=$post['id']?>">
	<div><?=$count?>. <?=htmlspecialchars(nickname($post['poster_nickname']))?> <?=$post['created_at']?></div>
	<pre><?=htmlspecialchars($post['content'])?></pre>
    </div>
<?php endif; ?>
