SELECT users.username, users.first_name, users.last_name, users.email, users.phone, user_stats.* FROM user_stats INNER JOIN users ON user_stats.id=users.id;
