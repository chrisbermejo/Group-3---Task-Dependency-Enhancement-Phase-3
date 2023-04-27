# Group-3-Task-Dependency-Enhancement-Phase-3

Create new tabel in SQL

CREATE TABLE task_dependencies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    task_id INT UNSIGNED NOT NULL,
    dependency_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (task_id) REFERENCES task(taskid),
    FOREIGN KEY (dependency_id) REFERENCES task(taskid)
);
