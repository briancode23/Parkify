<?php
$hash = '$2y$10$y7zYlCwL3nZk8XQe5XwT0eH9A3oZyJz0u2H9Jz6m1Yx5f5qvZ9ZyK';

var_dump(password_verify('123456', $hash));
