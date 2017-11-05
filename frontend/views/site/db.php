<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?php echo $user->id ?>
            <?php echo $user->username ?>
            <?php echo $user->mobile ?>
            <?php echo $user->created_at?>
        </li>
    <?php endforeach ?>
</ul>