-- Добавить внешний ключ
ALTER TABLE posts ADD FOREIGN KEY(category_id) REFERENCES categories(id); 
ALTER TABLE comments ADD FOREIGN KEY(post_id) REFERENCES posts(id);
ALTER TABLE comments ADD FOREIGN KEY(user) REFERENCES posts(id);