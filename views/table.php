<h2><?php echo $table ?></h2>
<table>
    <tr>
        <?php foreach($columns as $alias => $column): ?>
            <th><?php echo is_int($alias) ? $column : $alias ?></th>
        <?php endforeach ?>
    </tr>
    <?php foreach($data as $row => $values): ?>
        <tr>
            <?php foreach($columns as $column): ?>
            <?php
                $value = $values[$column]['column'];
                $type = $values[$column]['type']; 
                if($type == "enum") {
                    $options = $values[$column]['options'];
                }
                ?>
                <td>
                    <?php // Null ? ?>
                    <?php if(in_array($type, array('string', 'int', 'float'))): ?>
                        <input type="text" value="<?php echo $value ?>" />
                    <?php elseif($type == 'enum'): ?>
                        <select>
                            <?php foreach($options as $option): ?>
                                <option<?php echo ($option == $value ? ' selected' : '')?>><?php echo $option ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php elseif($type == 'boolean'): ?>
                        <input type="checkbox" <?php echo $value ? 'checked' : '' ?>/>
                    <?php elseif($type == 'readonly'): ?>
                        <p><?php echo $value ?></p>
                    <?php endif; ?>
                </td>
            <?php endforeach ?>
        </tr>
    <?php endforeach ?>
</table>
