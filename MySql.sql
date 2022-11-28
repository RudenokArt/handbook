-- Добавить внешний ключ
ALTER TABLE posts ADD FOREIGN KEY(category_id) REFERENCES categories(id); 
