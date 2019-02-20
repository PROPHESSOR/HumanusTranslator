<?php
@ob_start();
echo "Создаётся backup...";
copy('data/users.json', 'backup/' . date('D_M_d_Y_H_i_s') . '_users.json');
copy('data/translation.json', 'backup/' . date('D_M_d_Y_H_i_s') . '_translation.json');

echo 'Backup ' . date('D_M_d_Y_H_i_s') . ' успешно создан!';