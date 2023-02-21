Добавить индекс
ALTER TABLE `products` ADD INDEX(`category_id`);
Добавить внешний ключ
ALTER TABLE posts ADD FOREIGN KEY(category_id) REFERENCES categories(id); 
ALTER TABLE comments ADD FOREIGN KEY(post_id) REFERENCES posts(id);
ALTER TABLE comments ADD FOREIGN KEY(user) REFERENCES posts(id);

Удалить внешний ключ
alter table posts drop constraint posts_ibfk_1