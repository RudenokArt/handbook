-- Добавить индекс
ALTER TABLE `products` ADD INDEX(`category_id`);
-- Добавить внешний ключ
ALTER TABLE posts ADD FOREIGN KEY(category_id) REFERENCES categories(id); 
ALTER TABLE comments ADD FOREIGN KEY(post_id) REFERENCES posts(id);
ALTER TABLE comments ADD FOREIGN KEY(user) REFERENCES posts(id);

-- Удалить внешний ключ
alter table posts drop constraint posts_ibfk_1

-- JOIN один ко многим
SELECT * FROM `products` INNER JOIN `categories` ON `products`.`category_id`=`categories`.`id`

-- Многие ко многим
SELECT * FROM `products_tags` 
INNER JOIN `products` ON `products_tags`.`product_id`=`products`.`id`
INNER JOIN `tags` ON `products_tags`.`tag_id`=`tags`.`id`

-- Импортировать БД из консоли:
-- mysql -u root -p elfbar-vapes < elfbar_vapes_wp_34pcs.sql
-- mysql -u rudenok -p rudenok < elfbar_vapes_wp_34pcs.sql