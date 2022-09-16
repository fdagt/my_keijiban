<div id="post-<?=$post['id']?>">
    <div>
	<?php if ($post['is_hidden']) echo '<del>'; ?>
	<?=$count?>. <?=htmlspecialchars($post['poster_nickname'])?> <?=htmlspecialchars($post['created_at'])?> IP:<?=htmlspecialchars($post['ip_address'])?>
	<?php if ($post['is_hidden']) echo '</del>'; ?>
    </div>
    <form method="post" action="/admin/set-is-hidden-action.php">
	<input type="hidden" name="thread_id" value="<?=$post['thread_id']?>">
	<input type="hidden" name="post_id" value="<?=$post['id']?>">
	<input type="hidden" name="value" value="<?=$post['is_hidden'] ? 'false' : 'true'?>">
	<input type="submit" name="submit" value="<?=$post['is_hidden'] ? '表示' : '非表示'?>">
    </form>
    <pre><?=htmlspecialchars($post['content'])?></pre>
</div>
