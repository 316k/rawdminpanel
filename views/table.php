<h2><?php echo $table ?></h2>
<table>
    <tr>
        <?php foreach($columns as $column): ?>
            <th><?php echo $column ?></th>
        <?php endforeach ?>
    </tr>
    <?php foreach($data as $row => $values): ?>
        <tr>
            <?php foreach($columns as $column): ?>
                <td><?php echo $values[$column]['column'] ?></td>
            <?php endforeach ?>
        </tr>
    <?php endforeach ?>
</table>
