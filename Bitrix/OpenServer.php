На данный момент актуальная версия OpenServer - 5.4.0, в его конфиге nginx прописана блокировка доступа к скрытым папка и файлам («Disable access to hidden files/folders»), т.е. тех, которые начинаются с точки. Убирается следующим образом:
нажмите правой кнопкой на иконке OpenServer около часов, выберите «Дополнительно» - «Конфигурация» - и нажмите пункт, который содержит Apache + nginx или просто nginx. В текстовом редакторе откроется либо 4 файла в первом случае, либо 2 файла во втором случае.
среди открытых файлов найдите тот, который заканчивается на «_vhostn.conf» (не путайте с «_vhosta.conf» - это для Apache).
в этом файле найдите блок, начинающийся с комментария «Disable access to hidden files/folders»
Код
    # Disable access to hidden files/folders
    location ~* /\.(?!well-known/) {
        deny all;
        log_not_found off;
        access_log off;
    }

удалите весь этот блок.
перезапустите OpenServer.