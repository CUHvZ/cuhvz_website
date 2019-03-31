<h3 class="row-header">Users</h3>

<style>
.id {
  width: 40px;
}
.username {
  width: 220px;
}
.email {
  width: 250px;
}
.edit {
  width: 40px;
}
</style>

<?php

function buildUserRow($user){
  echo "<div class='table-row'>";
    echo "<div class='cell-container add-line'>";
      echo "<div class='id cell'>".$user["id"]."</div>";
      echo "<div class='username cell'>".$user["username"]."</div>";
      echo "<div class='email cell'>".$user["email"]."</div>";
      echo "<div class='edit cell'>";
      echo "<input type='image' src='images/settings_white.png' alt='edit' width='20' height='20'>";
      echo "</div>";
    echo "</div>";
  echo "</div>";
}

?>

<div class="table">
    <div class="table-row">
      <div class="cell-container add-line">
        <div class="id cell">id</div>
        <div class="username cell">username</div>
        <div class="email cell">email</div>
        <div class="edit cell">edit</div>
      </div>
    </div>
    <?php

      $query = "SELECT user_stats.*, users.* FROM user_stats INNER JOIN users ON user_stats.id=users.id";
      $userData = $database->executeQueryFetchAll($query);
      foreach ($userData as $user) {
        buildUserRow($user);
      }

    ?>
</div>
