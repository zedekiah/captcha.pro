CREATE TABLE synonym_group (id BIGINT AUTO_INCREMENT, description VARCHAR(255), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE validation (id INT UNSIGNED AUTO_INCREMENT, hash VARCHAR(255), synonym_group_id BIGINT NOT NULL, INDEX synonym_group_id_idx (synonym_group_id), PRIMARY KEY(id, hash)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE word (id BIGINT AUTO_INCREMENT, name VARCHAR(255) NOT NULL UNIQUE, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
CREATE TABLE word_synonym_group (word_id BIGINT, synonym_group_id BIGINT, PRIMARY KEY(word_id, synonym_group_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;
ALTER TABLE validation ADD CONSTRAINT validation_synonym_group_id_synonym_group_id FOREIGN KEY (synonym_group_id) REFERENCES synonym_group(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE word_synonym_group ADD CONSTRAINT word_synonym_group_word_id_word_id FOREIGN KEY (word_id) REFERENCES word(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE word_synonym_group ADD CONSTRAINT word_synonym_group_synonym_group_id_synonym_group_id FOREIGN KEY (synonym_group_id) REFERENCES synonym_group(id) ON UPDATE CASCADE ON DELETE CASCADE;
