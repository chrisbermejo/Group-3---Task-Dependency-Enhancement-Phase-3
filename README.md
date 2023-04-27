# Group-3-Task-Dependency-Enhancement-Phase-3

Delete the README.md file when moving the other files in the proj folder. 

This requires a new table called "task_dependencies"

```sql
CREATE TABLE task_dependencies (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    task_id INT UNSIGNED NOT NULL,
    dependency_id INT UNSIGNED,
    FOREIGN KEY (task_id) REFERENCES task(taskid) ON DELETE CASCADE,
    FOREIGN KEY (dependency_id) REFERENCES task(taskid) ON DELETE SET NULL,
    PRIMARY KEY (id)
);
```

To add this new table, go to http://localhost/phpmyadmin/

Follow the images

Click cscdb
<img src="https://cdn.discordapp.com/attachments/1028895750819692616/1101260952642519110/image.png" alt="alt text" width="400" height="400">
<br>
<p><p>
<br>
Click SQL
<img src="https://cdn.discordapp.com/attachments/1028895750819692616/1101261089464922112/image.png" alt="alt text" width="900" height="400">

